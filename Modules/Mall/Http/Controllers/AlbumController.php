<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/28
 * Time: 9:36 AM
 */

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use App\Utils\Oss;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\AlbumPhoto;
use Modules\Mall\Entities\AlbumUser;
use OSS\OssClient;

class AlbumController extends Controller
{
    use EchoJson;

    private $album_id_list = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->album_id_list = AlbumUser::where('user_id', Auth::id())->get()->pluck('id')->toArray();
            return $next($request);
        });
    }

    public static function getAlbumInfo()
    {
        $data = [];
        AlbumUser::where(['user_id' => Auth::id(), 'soft_delete' => false])->get()->map(function ($v) use (&$data) {
            $tmp                = $v->toArray();
            $tmp['photo_count'] = $v->album_photo->count();
            array_push($data, $tmp);
        });
        return $data;
    }

    public function createAlbum(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'album_name'  => 'required',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        if ($request->input('album_name') == 'Default Album') {
            return $this->echoErrorJson('Album name cannot be Default album!');
        }

        if (AlbumUser::where(
            [
                ['album_name', '=', $data['album_name']],
                ['user_id', '=', Auth::id()],
            ]
        )->exists()) {
            return $this->echoErrorJson('Error!The same name album exists!Can\'t create!');
        }

        $data['user_id'] = Auth::id();
        AlbumUser::create(
            $data
        );

        $res_data = self::getAlbumInfo();

        return $this->echoSuccessJson('The album was created successfully.!', $res_data);
    }

    public function editAlbum(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'album_id'          => 'required|exists:album_user,id',
            'album_name'        => 'nullable',
            'album_description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if ($album->soft_delete) {
            return $this->echoErrorJson('Error!Cannot modify deleted album!');
        }

        if ($album->user_id != Auth::id()) {
            return $this->echoErrorJson('Error!Users can only modify their own albums!');
        }

        if ($album->alnum_name == 'Default Album') {
            return $this->echoErrorJson('Error!Cannot modify default album!');
        }

        if (AlbumUser::where(
            [
                ['album_name', '=', $data['album_name']],
                ['id', '!=', $data['album_id']],
                ['user_id', '=', Auth::id()],
            ]
        )->exists()) {
            return $this->echoErrorJson('Error!The same name album exists!Cannot be modified!');
        }

        unset($data['album_id']);

        $album->update(
            $data
        );

        $res_data = self::getAlbumInfo();

        return $this->echoSuccessJson('Update album successfully!', $res_data);
    }

    public function deleteAlbum(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'album_id' => 'required|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if ($album->user_id != Auth::id()) {
            return $this->echoErrorJson('Error!Users can only delete their own albums!');
        }

        if ($album->album_name == 'Default Album') {
            return $this->echoErrorJson('Error!Cannot delete default album!');
        }

        $album->update([
            'soft_delete' => true,
        ]);

        $res_data = self::getAlbumInfo();

        return $this->echoSuccessJson('Delete album successfully!', $res_data);

    }

    public function uploadImgToAlbum(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'images' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $images = $request->file('images');
        if ($images == null) {
            return $this->echoErrorJson('Error!No pictures!');
        }

        if (count($images) == 1) {
            $res = UtilsController::uploadFile($images[0], UtilsController::getUserAlbumDirectory(), true);
        } else {
            $res = UtilsController::uploadMultipleFile($images, UtilsController::getUserAlbumDirectory(), true, true);
        }

        return $this->echoSuccessJson('Success!', $res);
    }

    public function saveImgToAlbum(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'photo_name_url_list'     => 'required|array',
            'album_id'                => 'nullable|exists:album_user,id',
            'upload_to_default_album' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $album_id = $request->input('album_id');

        if ($album_id != null) {
            $album = AlbumUser::find($album_id);
            if ($album->user_id != Auth::id()) {
                return $this->echoErrorJson('错误!只能上传到用户自己的相册!');
            }
        }

        $input_data = $request->input('photo_name_url_list');

        if (!is_array($input_data) || count($input_data) == 0) {
            return $this->echoErrorJson('photo_name_url_list必须是个数组');
        }

        $carbon = new Carbon;

        $insert_data = [];

        $upload_to_default_album = $request->input('upload_to_default_album', false);

        if ($upload_to_default_album) {
            $data              = ['album_name' => 'Default Album', 'user_id' => Auth::id()];
            $default_album_obj = AlbumUser::updateOrCreate($data, $data);
            $data['album_id']  = $default_album_obj->id;
        }

        $oss                    = Oss::getInstance();
        $res_data               = [];
        $res_data['un_success'] = [];
        foreach ($input_data as $key => $value) {
            try {
                $oss->size($value['path']);
            }catch (\Exception $e){
                array_push($res_data['un_success'],[$value['name']=>UtilsController::getPathFileUrl($value['path'])]);
                Log::error($e->getMessage());
                continue;
            }

            if(AlbumPhoto::where(['photo_name'=>$value['name'],'photo_url'=>$value['path'],'album_id'=>$data['album_id']])->count() == 0){
                $tmp = [];
                $tmp['album_id'] = $data['album_id'];
                $tmp['created_at'] = $carbon;
                $tmp['photo_name'] = $value['name'];
                $tmp['photo_url'] = $value['path'];
                $res_data['success'] = [$value['name']=>UtilsController::getPathFileUrl($value['path'])];
                $insert_data[] = $tmp;
            }
        }

        $res = AlbumPhoto::insert($insert_data);
        if ($res) {
            return $this->echoSuccessJson('Success!', $res_data);
        }
    }

    public function albumPhotoList(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'album_id' => 'required|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if ($album->user_id != Auth::id()) {
            return $this->echoErrorJson('错误!只能查看用户的相册!');
        }

        $data = AlbumPhoto::where(['album_id' => $album->id, 'soft_delete' => false])->get()->toArray();

        $oss = Oss::getInstance();

        $bucket    = env('OSS_BUCKET');
        $ossClient = new OssClient(env('OSS_ACCESS_KEY'), env('OSS_SECRET_KEY'), env('OSS_ENDPOINT'));
        $ossClient->setUseSSL(true);

        $options = array(OssClient::OSS_PROCESS => "image/info");

        foreach ($data as $k => $v) {
            try {
                $file_info                   = json_decode($ossClient->getObject($bucket, $v['photo_url'], $options));
                $data[$k]['photo_url']       = UtilsController::getPathFileUrl($v['photo_url']);
                $data[$k]['photo_path']      = $v['photo_url'];
                $data[$k]['photo_file_size'] = round($oss->size($v['photo_url']) / 1024, 2) . 'kb';
                $data[$k]['photo_size']      = $file_info->ImageWidth->value . 'x' . $file_info->ImageHeight->value;
            } catch (Exception $e) {
                continue;
            }

        }

        return $this->echoSuccessJson('获取相册图片列表Success!', $data);
    }

    public function albumList()
    {
        $data = self::getAlbumInfo();
        return $this->echoSuccessJson('Success!', $data);
    }

    public function modifyPhotos(Request $request)
    {
        $data = $request->all();
        Validator::extend('check_photo_exist', function ($attribute, $value) {
            $t_num = AlbumPhoto::whereIn('id', $value)->count();
            if ($t_num !== count($value)) {
                return false;
            } else {
                return true;
            }
        }); //检测

        $validator = Validator::make($data, [
            'photo_id_list' => 'required|array|check_photo_exist',
            'action'        => 'in:delete,move|required',
            'to_album_id'   => 'required_if:action,move|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $action = $request->input('action');

        $photo_id_list = $request->input('photo_id_list');

        if ($action == 'move') {
            $to_album_id = $request->input('to_album_id');
            if (!in_array($to_album_id, $this->album_id_list)) {
                return $this->echoErrorJson('只能移动图片到用户自己的相册中!');
            }
            $res = AlbumPhoto::whereIn('id', $photo_id_list)->whereIn('album_id', $this->album_id_list)->update([
                'album_id' => $to_album_id,
            ]);

            if ($res) {
                return $this->echoSuccessJson('移动图片Success!');
            } else {
                return $this->echoErrorJson('移动图片失败!');
            }
        } elseif ($action == 'delete') {
            $res = AlbumPhoto::whereIn('id', $photo_id_list)->whereIn('album_id', $this->album_id_list)->update([
                'soft_delete' => true,
            ]);

            if ($res) {
                return $this->echoSuccessJson('删除图片Success!');
            } else {
                return $this->echoErrorJson('删除图片失败!');
            }
        }
    }

    public function replaceImgToAlbum(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'image'    => 'required|image|max:1024',
            'photo_id' => 'required|exists:album_photo,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $photo_id = $request->input('photo_id');

        $photo_obj = AlbumPhoto::where('id', $photo_id)->get()->first();

        if ($photo_obj->album_user->user_id != Auth::id()) {
            return $this->echoErrorJson('错误!这张图片不属于你的相册中!');
        }

        $image = $request->file('image');

        $res = UtilsController::uploadFile($image, UtilsController::getUserAlbumDirectory(), true);

        $photo_obj->photo_url = $res['path'];

        $photo_obj->save();

        return $this->echoSuccessJson('替换图片Success!', $photo_obj->toArray());
    }

    public function getImgInfo(Request $request)
    {
        $image_path = $request->input('image_path');
        $client     = new Client();
        $ali_url    = env('OSS_URL');
        $response   = $client->get($ali_url . $image_path . '?x-oss-process=image/info');
        return Response::json(json_decode($response->getBody()));
    }

}

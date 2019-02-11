<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/28
 * Time: 9:36 AM
 */

namespace Modules\Mall\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Modules\Mall\Entities\AlbumPhoto;
use Modules\Mall\Entities\AlbumUser;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    use EchoJson;

    private $album_id_list = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->album_id_list = AlbumUser::where('user_id',Auth::id())->get()->pluck('id')->toArray();
            return $next($request);
        });
    }

    public function createAlbum(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'album_name'=>'required',
            'description'=>'nullable',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        if($request->input('album_name') == 'Default Album'){
            return $this->echoErrorJson('album name 不能是 Default Album!');
        }

        $data['user_id'] = Auth::id();
        AlbumUser::create(
            $data
        );
        return $this->echoSuccessJson('创建相册成功!');
    }

    public function editAlbum(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'album_id'=>'required|exists:album_user,id',
            'album_name'=>'nullable',
            'album_description'=>'nullable',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if($album->user_id != Auth::id()){
            return $this->echoErrorJson('错误!只能修改用户自己的相册!');
        }

        if($album->alnum_name == 'Default Album'){
            return $this->echoErrorJson('错误!不能修改默认相册!');
        }

        unset($data['album_id']);

        $album->update(
            $data
        );

        return $this->echoSuccessJson('更新相册成功!');
    }

    public function deleteAlbum(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'album_id'=>'required|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if($album->user_id != Auth::id()){
            return $this->echoErrorJson('错误!只能删除用户自己的相册!');
        }


        if($album->album_name == 'Default Album'){
            return $this->echoErrorJson('错误!不能删除默认相册!');
        }

        $album->update([
            'soft_delete'=>true
        ]);

        return $this->echoSuccessJson('删除相册成功!');

    }

    public function uploadImgToAlbum(Request $request){
        $images = $request->file('images');
        if(count($images) == 1){
           $res = UtilsController::uploadFile($images,UtilsController::getUserAlbumDirectory(),true);
        }else{
           $res = UtilsController::uploadMultipleFile($images,UtilsController::getUserAlbumDirectory(),true);
        }

        $this->echoSuccessJson('成功!',$res);
    }

    public function saveImgToAlbum(Request $request){
        $data = $request->all();

        Validator::extend('check_photo', function($attribute, $value){
            if(is_array($value) && count($value) >= 1){
                $mark = true;
                foreach ($value as $v){
                    if(strpos($v['photo_url'],'http://') === false){
                        $mark = false;
                    }
                }
                return $mark;
            }else{
                return false;
            }
        }); //检测

        $validator = Validator::make($data,[
            'photo_name_url_list'=>'required|array|check_photo',
            'album_id'=>'required|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }


        $album = AlbumUser::find($data['album_id']);

        if($album->user_id != Auth::id()){
            return $this->echoErrorJson('错误!只能上传到用户自己的相册!');
        }

        $insert_data = $request->input('photo_name_url_list');

        $carbon = new Carbon;

        foreach ($insert_data as $key=>$value){
            $insert_data[$key]['album_id'] = $data['album_id'];
            $insert_data[$key]['created_at'] = $carbon;
        }

        $res = AlbumPhoto::insert($insert_data);
        if($res){
            return $this->echoSuccessJson('保存成功!');
        }
    }

    public function albumPhotoList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'album_id'=>'required|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $album = AlbumUser::find($data['album_id']);

        if($album->user_id != Auth::id()){
            return $this->echoErrorJson('错误!只能查看用户的相册!');
        }

        $data = AlbumPhoto::where(['album_id'=>$album->id,'soft_delete'=>false])->get()->toArray();

        return $this->echoSuccessJson('获取相册图片列表成功!',$data);
    }

    public function albumList(){
        $data = AlbumUser::where(['user_id'=>Auth::id(),'soft_delete'=>false])->get()->toArray();
        return $this->echoSuccessJson('成功!',$data);
    }

    public function modifyPhotos(Request $request){
        $data = $request->all();
        Validator::extend('check_photo_exist', function($attribute, $value){
            $t_num  =AlbumPhoto::whereIn('id',$value)->count();
            if($t_num !== count($value)){
                return false;
            }else{
                return true;
            }
        }); //检测

        $validator = Validator::make($data,[
            'photo_id_list'=>'required|array|check_photo_exist',
            'action'=>'in:delete,move,',
            'to_album_id'=>'required_if:action,move|exists:album_user,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $action  = $request->input('action');

        $photo_id_list = $request->input('photo_id_list');

        if($action == 'move') {
            $to_album_id = $request->input('to_album_id');
            if (!in_array($to_album_id, $this->album_id_list)) {
                return $this->echoErrorJson('只能移动图片到用户自己的相册中!');
            }
            $res = AlbumPhoto::whereIn('id', $photo_id_list)->whereIn('album_id', $this->album_id_list)->update([
                'album_id' => $to_album_id
            ]);

            if ($res) {
                return $this->echoSuccessJson('移动图片成功!');
            } else {
                return $this->echoErrorJson('移动图片失败!');
            }
        }elseif ($action == 'delete'){
            $res = AlbumPhoto::whereIn('id', $photo_id_list)->whereIn('album_id', $this->album_id_list)->update([
                'soft_delete' => true
            ]);

            if ($res) {
                return $this->echoSuccessJson('删除图片成功!');
            } else {
                return $this->echoErrorJson('删除图片失败!');
            }
        }
    }

}

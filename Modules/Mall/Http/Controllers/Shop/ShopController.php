<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;
use App\Utils\EchoJson;
use DeepCopy\f001\A;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\ProductsAttr;
use Modules\Mall\Entities\ProductsCategories;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Shop;
use Modules\Mall\Http\Controllers\UtilsController;

class ShopController extends Controller
{
    use EchoJson;
    public function setShopBanner(Request $request){
        $data = $request->all();

        Validator::extend('banner_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'banner_img_base64'=>'required|banner_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $img = UtilsController::uploadFilesByBase64([$request->input('banner_img_base64')]);

        $img_path = $img[0]['path'];
        $img_url = $img[0]['file_url'];

        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj->get()->first()->update([
               'banner_url'=>$img_path
            ]);
        }else{
            Shop::create([
                'company_id'=>$company_id,
                'banner_url'=>$img_path,
            ]);
        }

        return $this->echoSuccessJson('更新成功!',['img_path'=>$img_path,'img_url'=>$img_url]);
    }

    public function getShopBanner(){
        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj  = $shop_obj->get()->first();
            if($shop_obj->banner_url == null){
                return $this->echoErrorJson('错误!没有设置过banner!');
            }
            return $this->echoSuccessJson('获取banner成功!',['banner_path'=>$shop_obj->banner_url,'banner_url'=>UtilsController::getPathFileUrl($shop_obj->banner_url)]);
        }else{
            return $this->echoErrorJson('错误!没有设置过banner!');
        }
    }

    public function setSlides(Request $request){
        $data = $request->all();

        Validator::extend('slide_list_check', function($attribute, $value, $parameters)
        {
            if(is_array($value)){
                foreach ($value as $v){
                    if(!(isset($v['url_path']) && isset($v['sort']))){
                        return false;
                    }
                }
                return true;
            }else{
                return false;
            }
        });

        $validator = Validator::make($data, [
            'slides_list'=>'array|slide_list_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }


        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);
        $input_slides_url_list = $request->input('slides_list');
        if($shop_obj->exists()){
            $slides_url_list = $shop_obj->get()->first()->slides_url_list;
            $db_sort_list = array_column($slides_url_list,'sort');

            if($slides_url_list != null){
                foreach ($input_slides_url_list as $k=>$v){
                    foreach ($slides_url_list as $kk=>$vv){
                        if($v['sort'] == $vv['sort']){
                            $slides_url_list[$kk] = $v;
                        }elseif (!in_array($v['sort'],$db_sort_list)){
                            if(!in_array($v,$slides_url_list)){
                                array_push($slides_url_list,$v);
                            }
                        }
                    }
                }
            }

            $re_order =array_column($slides_url_list,'sort');
            array_multisort($re_order,SORT_ASC, $slides_url_list);

            $S = $shop_obj->get()->first()->update([
                'slides_url_list'=>$slides_url_list
            ]);
        }else{
            Shop::create([
                'company_id'=>$company_id,
                'slides_url_list'=>$input_slides_url_list,
            ]);
        }

        return $this->echoSuccessJson('设置幻灯图片成功!');
    }

    public function uploadSlide(Request $request){
        $data = $request->all();

        Validator::extend('slide_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'slide_img_base64'=>'required|slide_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $img = UtilsController::uploadFilesByBase64([$request->input('slide_img_base64')]);
        return $this->echoSuccessJson('上传成功!',['img_path'=>$img[0]['path'],'img_url'=>$img[0]['file_url']]);
    }

    public function getSlidesList(Request $request){
        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);
        if($shop_obj->exists()){
            $shop_obj = $shop_obj->get()->first();
            if($shop_obj->slides_url_list == null){
                return $this->echoErrorJson('获取店铺幻灯片失败!未设置幻灯片!');
            }else{
                $res_data = $shop_obj->slides_url_list;
                foreach ($res_data as $k=>$v){
                    $res_data[$k]['url'] = UtilsController::getPathFileUrl($v['url_path']);
                }
                return $this->echoSuccessJson('获取幻灯片列表成功!',$res_data);
            }
        }else{
            return $this->echoErrorJson('获取店铺幻灯片失败!未设置幻灯片!');
        }
    }

}
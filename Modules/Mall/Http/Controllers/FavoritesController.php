<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/2/23
 * Time: 9:26 AM
 */

namespace Modules\Mall\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Favorites;
use Modules\Mall\Entities\Products;

class FavoritesController extends Controller
{
    use EchoJson;

    public function setFavorites(Request $request){
        $data = $request->all();
        Validator::extend('check_product_or_company_id', function($attribute, $value, $parameters,$validator){
            $type = $validator->getData()['type'];
            if($type == 'product'){
                if(Products::find($value) == null){
                    $validator->setCustomMessages(['check_product_or_company_id' => 'product id don\'t exist!']);
                    return false;
                }
            }elseif ($type == 'company'){
                if(Company::find($value) == null){
                    $validator->setCustomMessages(['check_product_or_company_id' => 'company id don\'t exist!']);
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($data,[
            'type'=>'required|in:product,company',
            'product_or_company_id'=>'required|check_product_or_company_id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $company_id = Auth::user()->company->id;
        $type = $request->input('type');
        $product_or_company_id = $request->input('product_or_company_id');
        $data = ['company_id' => $company_id,'type'=>$type,'product_or_company_id'=>$product_or_company_id];
        $res = Favorites::updateOrCreate($data,$data);
        if($res){
            $res_data = self::getFavoritesData();
            return $this->echoSuccessJson('加入收藏成功!',$res_data);
        }else{
            return $this->echoErrorJson('操作失败!');
        }
    }

    public static function getFavoritesData(){
        $company_id = Auth::user()->company->id;
        $res = Favorites::where('company_id',$company_id)->get();
        $res_data = [];
        $res_data['product'] = [];
        $res_data['company'] = [];
        if($res){
            foreach ($res as $v){
                if($v->type == 'product'){
                    $tmp = $v->toArray();
                    unset($tmp['company_id']);
                    $tmp['product_name'] = Products::where('id',$v->product_or_company_id)->get()->first()->product_name;
                    array_push( $res_data['product'],$tmp);
                }elseif ($v->type == 'company'){
                    $tmp = $v->toArray();
                    unset($tmp['company_id']);
                    $tmp['company_name'] = Company::where('id',$v->product_or_company_id)->get()->first()->company_name;
                    $tmp['company_af_id'] = Company::where('id',$v->product_or_company_id)->get()->first()->user->usersExtends->af_id;
                    array_push( $res_data['company'],$tmp);
                }
            }
        }
        return $res_data;
    }

    public function getFavorites(){
        $res = self::getFavoritesData();
        return $this->echoSuccessJson('获取收藏数据成功!',$res);
    }

    public function deleteFavorites(Request $request){
        $data = $request->all();

        Validator::extend('check_product_or_company_id_list', function($attribute, $value, $parameters,$validator){
            $type = $validator->getData()['type'];

            if(!is_array($value)){
                $validator->setCustomMessages(['check_product_or_company_id_list' => 'list must be a array!']);
                return false;
            }

            if($type == 'product'){
                foreach ($value as $v){
                    if(Products::find($v) == null){
                        $validator->setCustomMessages(['check_product_or_company_id_list' => 'product id don\'t exist!id:'.$v]);
                        return false;
                    }
                }
            }elseif ($type == 'company'){
                foreach ($value as $v){
                    if(Company::find($v) == null){
                        $validator->setCustomMessages(['check_product_or_company_id_list' => 'company id don\'t exist!id:'.$v]);
                        return false;
                    }
                }
            }
            return true;
        });

        $validator = Validator::make($data,[
            'type'=>'required|in:product,company',
            'product_or_company_id_list'=>'required|check_product_or_company_id_list',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $company_id = Auth::user()->company->id;
        $type = $request->input('type');
        Favorites::where(
            [
               ['company_id','=',$company_id],
               ['type','=',$type],
            ]
        )->whereIn('product_or_company_id',$request->input('product_or_company_id_list'))->delete();
        $res_data = self::getFavoritesData();
        return $this->echoSuccessJson('操作成功!',$res_data);
    }

}

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
                    $validator->setCustomMessages(['check_product_or_company_id' => 'product_id don\'t exists!']);
                    return false;
                }
            }elseif ($type == 'company'){
                if(Company::find($value) == null){
                    $validator->setCustomMessages(['check_product_or_company_id' => 'company_id don\'t exists!']);
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
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $company_id = Auth::user()->company->id;
        $type = $request->input('type');
        $product_or_company_id = $request->input('product_or_company_id');
        $data = ['company_id' => $company_id,'type'=>$type,'product_or_company_id'=>$product_or_company_id];
        $res = Favorites::updateOrCreate($data,$data);
        if($res){
            $res_data = self::getFavoritesData();
            return $this->echoSuccessJson('Add Success to favorites!',$res_data);
        }else{
            return $this->echoErrorJson('The operation failure!');
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
                    if(Company::where('id',$v->product_or_company_id)->exists()){
                        $company = Company::where('id',$v->product_or_company_id)->get()->first();
                        $tmp['company_name'] = $company->company_name;
                        $tmp['company_af_id'] =$company->user->usersExtends->af_id;
                    }else{
                        $tmp['company_name'] = '';
                        $tmp['company_af_id'] = '';
                    }
                    
                    array_push( $res_data['company'],$tmp);
                }
            }
        }
        return $res_data;
    }

    public function getFavorites(){
        $res = self::getFavoritesData();
        return $this->echoSuccessJson('Fetch the favorite data Success!',$res);
    }

    public function deleteFavorites(Request $request){
        $data = $request->all();

        Validator::extend('check_product_or_company_id_list', function($attribute, $value, $parameters,$validator){
            $type = $validator->getData()['type'];

            if(!is_array($value)){
                $validator->setCustomMessages(['check_product_or_company_id_list' => 'The parameter must be an array!']);
                return false;
            }

            if($type == 'product'){
                foreach ($value as $v){
                    if(Products::find($v) == null){
                        $validator->setCustomMessages(['check_product_or_company_id_list' => 'product_id don\'t exists! ,id:'.$v]);
                        return false;
                    }
                }
            }elseif ($type == 'company'){
                foreach ($value as $v){
                    if(Company::find($v) == null){
                        $validator->setCustomMessages(['check_product_or_company_id_list' => 'company_id don\'t exists!id:'.$v]);
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
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
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
        return $this->echoSuccessJson('Operation Success!',$res_data);
    }

}

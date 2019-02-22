<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;

use App\Utils\City;
use App\Utils\EchoJson;
use App\Utils\Oss;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\ProductsGroup;
use Modules\Mall\Entities\ProductsProductsGroup;
use Modules\Mall\Entities\UsersExtends;

class ProductsGroupsController extends Controller
{
    use EchoJson;

    public static function arr_sort($array,$key,$order="asc") {
        $arr_num = $arr = array();
        foreach ($array as $k => $v) {
            $arr_num[$k] = $v[$key]; //将排序的键值取出
            if($v['children'] !== null){
                $v['children'] = self::arr_sort($v['children'],'sort',$order);
                $array[$k] = $v;
            }
        }
        if($order == "asc") {//对键值进行排序，并保留索引
            asort($arr_num);
        } else {
            arsort($arr_num);
        }
        $zero = [];
        foreach ($arr_num as $kk=>$vv){
            if($vv == 0){
                unset($arr_num[$kk]);
                array_push($zero,$kk);
            }
         }

        foreach ($arr_num as $k => $v) {
            $arr[] = $array[$k];//按照跑留的索引进行赋值
        }

        foreach ($zero as $v){
            $arr[] = $array[$v];
        }
        return $arr;
    }

    public static function getProductGroupInfo(){
        $product_group = ProductsGroup::where('user_id',Auth::id())->get()->toArray();
        if($product_group == null){
            return [];
        }
        $product_group_list = [];
        foreach ($product_group as $v){
            if($v['parent_id'] == 0){
                $v['children'] = null;
                $product_group_list[] = $v;
            }else{
                foreach ($product_group_list as $k=>$vv){
                    if($vv['id'] == $v['parent_id']){
                        $v['children'] = null;
                        $product_group_list[$k]['children'][] = $v;
                    }
                }
            }
        }

        $group_list = self::arr_sort($product_group_list,'sort');
        return $group_list;
    }

    public function productsGroupsList(){
        $group_list = elf::getProductGroupInfo();
        return $this->echoSuccessJson('获取商品分组成功!',$group_list);

    }

    public function editProductsGroup(Request $request){
         $data = $request->all();

        $validator = Validator::make($data,[
            'product_group_id'=>'required|exists:products_group,id',
            'group_name'=>'required',
            'show_home_page'=>'boolean|required',
            'sort'=>'integer|required',
        ]);


        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $product_group = ProductsGroup::where(['user_id'=>Auth::id(),'id'=>$request->input('product_group_id')])->get()->first();

        if($product_group == null){
            return $this->echoErrorJson('错误!只能修改自己的分组!');
        }

        $group_name = $request->input('group_name');

        $re_name_check_num = ProductsGroup::where(['user_id'=>Auth::id(),'group_name'=>$group_name])->where('id','!=',$product_group->id)->count();

        if($re_name_check_num > 0){
            return $this->echoErrorJson('存在相同名称的分组,无法进行修改!');
        }

        $product_group->update(
            [
                'group_name'=>$group_name,
                'show_home_page'=>$request->input('show_home_page'),
                'sort'=>(integer)$request->input('sort'),
            ]
        );

        $group_list = elf::getProductGroupInfo();

        return $this->echoSuccessJson('更新商品分组成功!',$group_list);
    }

    public function createProductsGroup(Request $request){
        $data = $request->all();

        Validator::extend('check_group_parent_id', function($attribute, $value, $parameters,$validator)
        {
            if($value == null){
                return true;
            }else{
                $p_group = ProductsGroup::where(['user_id'=>Auth::id(),'id'=>$value]);
                if($p_group->count() == 0){
                    $validator->setCustomMessages(['check_group_parent_id' => 'parent id is dot\'t exists!']);
                    return false;
                }else{
                    if($p_group->get()->first()->parent_id != 0){
                        $validator->setCustomMessages(['check_group_parent_id' => 'max parent is tow!']);
                        return false;
                    }else{
                        return true;
                    }
                }
            }
        });

        $validator = Validator::make($data,[
            'group_parent_id'=>'check_group_parent_id',
            'group_name'=>'required',
            'show_home_page'=>'boolean|required',
            'sort'=>'integer|required'
        ]);


        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $group_name = $request->input('group_name');
        $re_name_check_num = ProductsGroup::where(['user_id'=>Auth::id(),'group_name'=>$group_name])->count();

        if($re_name_check_num > 0){
            return $this->echoErrorJson('存在相同名称的分组,无法进行创建!');
        }

        $group_parent_id = $request->input('group_parent_id');
        ProductsGroup::create(
            [
                'group_name'=>$group_name,
                'show_home_page'=>$request->input('show_home_page'),
                'parent_id'=>$group_parent_id == null ? 0 : $group_parent_id,
                'sort'=>$request->input('sort'),
                'user_id'=>Auth::id()
            ]
        );

        $group_list = self::getProductGroupInfo();

        return $this->echoSuccessJson('创建分组成功!',$group_list);

    }

    public function deleteProductsGroup(Request $request){
         $data = $request->all();
         $validator = Validator::make($data,[
            'product_group_id'=>'required|exists:products_group,id',
        ]);
         if ($validator->fails()) {
                return $this->echoErrorJson('表单验证失败!'.$validator->messages());
         }

        $product_group = ProductsGroup::where(['user_id'=>Auth::id(),'id'=>$request->input('product_group_id')])->get()->first();
         if($product_group == null){
             return $this->echoErrorJson('错误!没有找到该分组信息!');
         }

        $product_group->delete();
         if (!$product_group->trashed()) {
             return redirect()->back()->with('danger', '分组删除失败，分组ID：'.$product_group->id);
         }

        $group_list = self::getProductGroupInfo();

        return $this->echoSuccessJson('分组删除成功! 分组ID：'.$product_group->id,$group_list);
    }

}
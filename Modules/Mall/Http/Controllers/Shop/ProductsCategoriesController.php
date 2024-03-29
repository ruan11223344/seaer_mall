<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\ProductsAttr;
use Modules\Mall\Entities\ProductsCategories;
use Illuminate\Support\Facades\Validator;

class ProductsCategoriesController extends Controller
{
    use EchoJson;
    public function getProductsCategories(){
        $data = ProductsCategories::get()->toTree()->toArray();
        return $this->echoSuccessJson('Success!',$data);
    }

    public function getCategoriesRoot(){
        $root = ProductsCategories::whereIsRoot()->get()->toArray();

        return $this->echoSuccessJson('Get the root classification Success!',$root);
    }

    public function getCategoriesParent(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'categories_id'=>'required|exists:products_categories,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $category = ProductsCategories::where('id',$request->input('categories_id'))->get()->first();

        if($category->isRoot()){
            return $this->echoErrorJson('The top category of this category, there\'s no parent category.!');
        }

        $child = $category->parent->toArray();

        return $this->echoSuccessJson('Gets the parent classification Success!',$child);

    }

    public function getCategoriesChild(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'categories_id'=>'required|exists:products_categories,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $category = ProductsCategories::where('id',$request->input('categories_id'))->get()->first();

        if($category->isLeaf()){
            return $this->echoErrorJson('This is the lowest level of classification, no sub-classification!');
        }

        $child = $category->children->toArray();

        return $this->echoSuccessJson('Gets the parent classification Success!',$child);
    }

    public static function getCategoriesParentTreeStr($categories_id_list){
        $count  = array_count_values($categories_id_list);
        $category_id_list = array_keys($count);
        $category_model = ProductsCategories::whereIn('id',$category_id_list)->get();

        $res_list = [];

        foreach ($category_model as $v){
            if($v->isRoot()){
                continue;
            }

            if($v->isLeaf()){
                $parent_name = $v->parent->name;
                if($v->parent->hasParent()){
                    $parent_parent_name = $v->parent->parent->name;
                }
                $res_list[] = ['name'=>$parent_parent_name.' > '.$parent_name.' > '.$v->name,"categories_id"=>$v->id,"re_sort"=>$count[$v->id]];
            }

            if($v->hasParent() && !$v->isLeaf()){
                $parent_name = $v->parent->name;
                $res_list[] = ['name'=>$parent_name.' > '.$v->name,"categories_id"=>$v->id,"re_sort"=>$count[$v->id]];
            }
        }

        $re_order =array_column($res_list,'re_sort');
        array_multisort($re_order,SORT_DESC, $res_list);

        foreach ($res_list as $k=>$v){
            unset($v['re_sort']);
            $res_list[$k] = $v;
        }

        return $res_list;
    }

    public function searchProductsCategories(Request $request){
        $keywords = $request->input('keywords');

        $categories_list = ProductsCategories::where('name', 'like','%'.$keywords.'%')->get()->pluck('id')->toArray();
        $products_attr_id_list = ProductsAttr::where('attr_specs', 'like','%'.$keywords.'%')->pluck('id')->toArray();


        $products = Products::where(
            'product_name','like','%'.$keywords.'%'
        )->orWhere(
            'product_keywords','like','%'.$keywords.'%'
        )->orWhereIn(
            'product_attr_id',$products_attr_id_list
        )->get();


        if($products !== null){
            foreach ($products as $v){
                $categories_list[] = $v->product_categories_id;
            }
        }

        if($categories_list == null){
            return $this->echoErrorJson('No keyword category found!');
        }

        $res_str_list = self::getCategoriesParentTreeStr($categories_list);

        return $this->echoSuccessJson('The search keyword classification was successful!',$res_str_list);
    }

    public function getCategoriesProduct(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'categories_id'=>'required|exists:products_categories,id',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $categories_id = $request->input('categories_id');

        $categories_orm = ProductsCategories::where('id',$categories_id)->get()->first();

        $categories_id_list  = $categories_orm->descendants->pluck('id')->toArray();
        $products_orm = Products::where([
            ['product_categories_id',$categories_id],
            ['product_status',ProductsController::PRODUCT_STATUS_SALE],
            ['product_audit_status',ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS],
        ])->orWhereIn('product_categories_id',$categories_id_list);
        if($products_orm->get()->isEmpty()){
            return $this->echoErrorJson('There are no goods in this category!');
        }else{
            $res_data = ProductsController::getProductFormatInfo($products_orm);
            return $this->echoSuccessJson('The product classification is successful!',$res_data);
        }

    }

    public function getLastProductsCategories(){
        $product_categories_id_list = Products::where('company_id',Auth::user()->company->id)->get()->pluck('product_categories_id')->unique()->toArray();
        if($product_categories_id_list == null){
            return $this->echoErrorJson('Failure, there is no recently selected category!');
        }else{
            $res_str_list = self::getCategoriesParentTreeStr($product_categories_id_list);
            return $this->echoSuccessJson('Gets the recently selected category success!',$res_str_list);
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;
use App\Utils\EchoJson;
use Illuminate\Routing\Controller;
use Modules\Mall\Entities\ProductsCategories;

class ProductsCategoriesController extends Controller
{
    use EchoJson;
    public function getProductsCategories(){
        $data = ProductsCategories::get()->toTree()->toArray();
        return $this->echoSuccessJson('成功!',$data);
    }
}
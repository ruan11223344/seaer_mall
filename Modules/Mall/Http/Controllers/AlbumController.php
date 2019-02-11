<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/28
 * Time: 9:36 AM
 */

namespace Modules\Mall\Http\Controllers;

use App\Utils\City;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mews\Captcha\Facades\Captcha;
use Khsing\World\Models\Country;
use Modules\Mall\Entities\ProductsCategories;
use Modules\Mall\Entities\RegisterTemp;


class AlbumController extends Controller
{
    use EchoJson;

    public function createAlbum(Request $request){

    }

    public function editAlbum(Request $request){

    }

    public function uploadImgToAlbum(Request $request){

    }

}

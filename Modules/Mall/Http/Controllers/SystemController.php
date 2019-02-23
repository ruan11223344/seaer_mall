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
use Illuminate\Support\Facades\Cache;
use Modules\Mall\Entities\AlbumPhoto;
use Modules\Mall\Entities\AlbumUser;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    use EchoJson;

    public function sysConfig(){
        $data = [];
        $data['oss_url_prefix']  = env('OSS_URL');
        $data['timestamp'] = time();
        return $this->echoSuccessJson('成功!',$data);
    }


}

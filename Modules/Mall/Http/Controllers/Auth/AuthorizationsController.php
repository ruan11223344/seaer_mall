<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/10
 * Time: 4:49 PM
 */

namespace Modules\Mall\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\AuthorizationServer;
use Illuminate\Support\Facades\Auth;
use App\Utils\EchoJson;
class AuthorizationsController extends Controller
{
    use EchoJson;
    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        try {
            return $server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201);
        } catch (OAuthServerException $e) {
            return $this->echoErrorJson($e->getMessage());
        }
    }

    public function getUserInfo()
    {
        $user = Auth::user();
        return $this->echoSuccessJson('获取用户信息成功！',$user->toArray());
    }
}
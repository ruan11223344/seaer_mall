<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    use EchoJson;

    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest){
        $data = $serverRequest->getParsedBody();
        if($data === []){
            return $this->echoErrorJson('Error!Parameter cannot be empty!',[]);
        }

        if(isset($data['username'])){
            $validator = Validator::make($data, [
                'key' => 'required',
                'captcha' => 'required|captcha_api:' . $data['key'],
            ]);

            if ($validator->fails()) {
                return $this->echoErrorJson('Verification code verification failed!'.$validator->messages());
            }
        }


        try {
            $token_data = json_decode((string)$server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201)->getBody());
            $data = [
                'token_type'=>$token_data->token_type,
                'expires_in'=>$token_data->expires_in,
                'access_token'=>$token_data->access_token,
                'refresh_token'=>$token_data->refresh_token,
            ];
            return $this->echoSuccessJson('Success!',$data);
        } catch (OAuthServerException $e) {
            return $this->echoErrorJson($e->getMessage());
        }
    }

    public function logout(Request $request){
        $value = $request->bearerToken();
        if ($value) {
            $id = (new Parser())->parse($value)->getHeader('jti');
            DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
        }
        return $this->echoSuccessJson('登出成功!');
    }

}
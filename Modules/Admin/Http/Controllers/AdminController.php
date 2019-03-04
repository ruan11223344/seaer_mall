<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    use EchoJson;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */


    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest){
        $data = $serverRequest->getParsedBody();
        if($data === []){
            return $this->echoErrorJson('Error!Parameter cannot be empty!',[]);
        }
        $this->ip = $serverRequest->getServerParams()['REMOTE_ADDR'];
        $this->username = $data['username'];


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

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}

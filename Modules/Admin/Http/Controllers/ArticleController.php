<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Entities\Article;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class ArticleController extends Controller
{
    use EchoJson;
    public function getSystemArticleList(Request $request){

    }

    public function getUserAgreementsList(Request $request){

    }

    public function getSystemAnnouncementList(Request $request){

    }

    public function publishArticle(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'type'=>'required|in:user_agreements,system_announcement,system_article',
            'content'=>'required',
            'title'=>'required',
            //'system_article','system_announcement','user_agreements'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $admin_id = Auth::id();

        $data['admin_id'] = $admin_id;

        $article = Article::create(
            $data
        );

        return $this->echoSuccessJson('发布成功!',$article->toArray());
    }

    public function getArticleDetail(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'article_id'=>'required|exists:article,id',
            //'system_article','system_announcement','user_agreements'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $article_id = $request->input('article_id');
        $article = Article::find($article_id);

        if($article == null){
            return $this->echoErrorJson('错误!这篇文章不存在!');
        }

        return $this->echoSuccessJson('成功!',$article->toArray());
    }

    public function editArticle(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'article_id'=>'required|exists:article,id',
            'content'=>'nullable',
            'title'=>'nullable',
            //'system_article','system_announcement','user_agreements'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $article_id = $request->input('article_id');
        $article = Article::find($article_id);

        if($article == null){
            return $this->echoErrorJson('错误!这篇文章不存在!');
        }

        $content = $request->input('content',null);
        $title = $request->input('title',null);

        if($content != null){
            $article->content = $content;
        }
        if ($title != null){
            $article->title = $title;
        }

        $article->save();

        return $this->echoSuccessJson('编辑成功!',$article->toArray());
    }

    public function deleteArticle(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'article_id'=>'required|exists:article,id',
            //'system_article','system_announcement','user_agreements'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $article_id = $request->input('article_id');
        $article = Article::find($article_id);

        if($article == null){
            return $this->echoErrorJson('错误!这篇文章不存在!');
        }

        $article->delete();
        return $this->echoSuccessJson('删除成功!');
    }

}
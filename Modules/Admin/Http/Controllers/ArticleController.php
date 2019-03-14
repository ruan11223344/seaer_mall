<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Article;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    use EchoJson;

    public static function getArticleData($article_orm,$page,$size){
        $article_clone = clone $article_orm;
        $count = $article_clone->count();
        $data_list =[];
        $article_orm->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$data_list,$page,$size){
            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);
            $tmp['article_id'] = $v->id;
            $tmp['article_title'] = $v->title;
            $tmp['publish_time'] = Carbon::parse($v->created_at)->format('Y-m-d H:i:s');
            $tmp['article_type'] = $v->type;
            $data_list[] = $tmp;
        });

        $res_data['data'] = $data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;
        return $res_data;
    }

    public function getSystemArticleList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);

        $article_orm = Article::where('type','system_article');
        $res_data = self::getArticleData($article_orm,$page,$size);
        return $this->echoSuccessJson('获取系统文章列表成功!',$res_data);
    }

    public function getAgreementsList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }


        $page = $request->input('page',1);
        $size = $request->input('size',20);

        $article_type_list = ['buyers_register_agreement','merchants_register_agreement'];

        $article_orm = Article::whereIn('type',$article_type_list);
        $res_data = self::getArticleData($article_orm,$page,$size);
        return $this->echoSuccessJson('获取用户协议列表成功!',$res_data);
    }

    public function getSystemAnnouncementList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);

        $article_orm = Article::where('type','system_announcement');
        $res_data = self::getArticleData($article_orm,$page,$size);
        return $this->echoSuccessJson('获取系统公告列表成功!',$res_data);
    }

    public function publishArticle(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'type'=>'required|in:buyers_register_agreement,merchants_register_agreement,system_announcement,system_article',
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
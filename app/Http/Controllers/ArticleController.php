<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * 記事一覧
     */
    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at');

        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * 記事投稿画面
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * 記事登録処理
     */
    public function store(ArticleRequest $request, Article $article)
    {
        // $article->title = $request->title;
        // $article->body = $request->body;
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }
}

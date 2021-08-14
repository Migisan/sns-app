<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }
    
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
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }

    /**
     * 記事更新画面
     */
    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * 記事更新処理
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

    /**
     * 記事削除処理
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    /**
     * 記事詳細画面
     */
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }
}


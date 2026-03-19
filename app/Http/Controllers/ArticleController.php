<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = Article::query();
        $query->orderBy('created_at', 'DESC');
        $articles = $query->paginate(3)->withQueryString();

        return Inertia::render('Article/Index', [
            'title' => 'Статьи',
            'articles' => $articles
        ]);
    }

    public function show(Article $article)
    {
        return Inertia::render('Article/Item', [
            'title' => $article->title,
            'article' => $article
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()->orderBy('id', 'desc')->published()->paginate(9);
        return Inertia::render('News/Index', [
            'news' => $news
        ]);
    }

    public function show($slug)
    {
        $article = News::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $relatedArticles = News::published()
            ->news()
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return Inertia::render('News/Show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }

    public function promos()
    {
        $promos = News::published()->promo()->paginate(9);

        return Inertia::render('News/Promos', [
            'promos' => $promos
        ]);
    }
}

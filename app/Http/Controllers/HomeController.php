<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('active', true)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $latestNews = News::published()
            ->take(3)
            ->get();

        $promos = News::published()
            ->promo()
            ->take(3)
            ->get();

        $categories = Category::where('active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return Inertia::render('Home', [
            'featuredProducts' => $featuredProducts,
            'latestNews' => $latestNews,
            'promos' => $promos,
            'categories' => $categories
        ]);
    }
}

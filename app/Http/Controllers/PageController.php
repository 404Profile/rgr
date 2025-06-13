<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('active', true)
            ->select(['id', 'title', 'slug', 'content'])
            ->get();

        return Inertia::render('Pages/Index', [
            'pages' => $pages
        ]);
    }

    public function show($slug)
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            $page = Page::query()
                ->where('slug', $slug)
                ->firstOrFail();
        } else {
            $page = Page::query()
                ->where('slug', $slug)
                ->where('active', true)
                ->firstOrFail();
        }

        return Inertia::render('Pages/Show', [
            'page' => $page
        ]);
    }

    public function about()
    {
        return Inertia::render('About');
    }

    public function contact()
    {
        $page = Page::where('slug', 'contacts')
            ->where('active', true)
            ->first();

        $contact = Contact::first();

        return Inertia::render('Contact', [
            'page' => $page,
            'contact' => $contact
        ]);
    }

    public function sitemap()
    {
        return Inertia::render('Sitemap');
    }
}

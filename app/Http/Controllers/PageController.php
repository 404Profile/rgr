<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Product;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
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

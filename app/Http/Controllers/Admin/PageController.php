<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->paginate(15);

        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Pages/Create');
    }

    public function store(StorePageRequest $request)
    {
        $data = $request->validated();

        // Генерация slug, если он не указан
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title_ru']);
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно создана');
    }

    public function show(Page $page)
    {
        return Inertia::render('Admin/Pages/Show', [
            'page' => $page
        ]);
    }

    public function edit(Page $page)
    {
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $data = $request->validated();

        // Генерация slug, если он не указан
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title_ru']);
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно обновлена');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно удалена');
    }
}

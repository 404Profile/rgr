<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'desc')->paginate(15);
        return Inertia::render('Admin/News/Index', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/News/Create');
    }

    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно создана');
    }

    public function show(News $news)
    {
        return Inertia::render('Admin/News/Show', [
            'news' => $news
        ]);
    }

    public function edit(News $news)
    {
        return Inertia::render('Admin/News/Edit', [
            'news' => $news
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $validated = $request->validated();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Удаление изображения только если выбрана опция
        if ($request->boolean('remove_image') && $news->image) {
            Storage::disk('public')->delete($news->image);
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        } else {
            // Оставляем старое изображение, если новое не загружено
            $validated['image'] = $news->image;
        }

        // Обновляем новость
        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Новость успешно обновлена');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно удалена');
    }
}

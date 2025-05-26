<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::where('active', true)->get();
        $brands = Brand::where('active', true)->get();

        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Генерация slug, если он не указан
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_ru']);
        }

        // Загрузка основного изображения
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Загрузка галереи изображений
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно создан');
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Products/Show', [
            'product' => $product->load(['category', 'brand'])
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->get();
        $brands = Brand::where('active', true)->get();

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Генерация slug, если он не указан
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_ru']);
        }

        // Загрузка основного изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Загрузка галереи изображений
        if ($request->hasFile('gallery')) {
            // Удаление старых изображений
            if ($product->gallery) {
                foreach ($product->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    public function destroy(Product $product)
    {
        // Удаление изображений
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->gallery) {
            foreach ($product->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален');
    }
}

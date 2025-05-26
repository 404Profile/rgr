<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'brand'])->where('active', true);

        $this->applyFilters($request, $query);

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Catalog/Index', [
            'products' => $products,
            'categories' => $this->getCategoriesWithCounts(),
            'brands' => $this->getBrandsWithCounts(),
            'currentCategory' => null,
            'selectedCategory' => null,
            'selectedBrands' => $request->input('brands', []),
            'filters' => [
                'price_min' => $request->input('price_min'),
                'price_max' => $request->input('price_max'),
                'sort' => $request->input('sort', 'newest'),
            ],
        ]);
    }

    public function byCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail()
            ->append(['name', 'description']); // Добавляем аксессоры

        $categoryIds = [$category->id];
        if ($category->children()->count() > 0) {
            $categoryIds = array_merge($categoryIds, $category->children()->pluck('id')->toArray());
        }

        $query = Product::whereIn('category_id', $categoryIds)->with(['category', 'brand'])->where('active', true);

        $this->applyFilters($request, $query);

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Catalog/Category', [
            'products' => $products,
            'categories' => $this->getCategoriesWithCounts(),
            'brands' => $this->getBrandsWithCounts(),
            'category' => $category,
            'selectedBrands' => $request->input('brands', []),
            'filters' => [
                'price_min' => $request->input('price_min'),
                'price_max' => $request->input('price_max'),
                'sort' => $request->input('sort', 'newest'),
            ],
        ]);
    }

    public function byBrand(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail()
            ->append(['name', 'description']); // Добавляем аксессоры

        $query = Product::where('brand_id', $brand->id)->with(['category', 'brand'])->where('active', true);

        $this->applyFilters($request, $query);

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Catalog/Brand', [
            'products' => $products,
            'categories' => $this->getCategoriesWithCounts(),
            'brands' => $this->getBrandsWithCounts(),
            'brand' => $brand,
            'selectedBrands' => $request->input('brands', []),
            'filters' => [
                'price_min' => $request->input('price_min'),
                'price_max' => $request->input('price_max'),
                'sort' => $request->input('sort', 'newest'),
            ],
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'brand'])
            ->where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return Inertia::render('Catalog/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    private function applyFilters(Request $request, $query)
    {
        // Фильтр по брендам
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }

        // Фильтр по цене (минимум)
        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }

        // Фильтр по цене (максимум)
        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }

        // Сортировка
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name_ru', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name_ru', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    // Получение категорий с количеством товаров
    private function getCategoriesWithCounts()
    {
        $categories = Category::where('parent_id', null)
            ->where('active', true)
            ->withCount(['products' => function ($query) {
                $query->where('active', true);
            }])
            ->with(['children' => function ($query) {
                $query->where('active', true)
                    ->withCount(['products' => function ($query) {
                        $query->where('active', true);
                    }]);
            }])
            ->get()
            ->append(['name']); // Добавляем аксессор name

        // Добавляем name для детей категорий
        $categories->each(function ($category) {
            if ($category->children) {
                $category->children->each(function ($child) {
                    $child->append(['name']);
                });
            }
        });

        return $categories;
    }

    // Получение брендов с количеством товаров
    private function getBrandsWithCounts()
    {
        $brands = Brand::where('active', true)
            ->withCount(['products' => function ($query) {
                $query->where('active', true);
            }])
            ->get()
            ->append(['name']); // Добавляем аксессор name

        return $brands;
    }
}

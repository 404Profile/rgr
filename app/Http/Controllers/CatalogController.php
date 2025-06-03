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
            ->firstOrFail();

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
            ->firstOrFail();

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
//dd($product, $relatedProducts);
        return Inertia::render('Catalog/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }

        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
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
            ->get();

        return $categories;
    }

    private function getBrandsWithCounts()
    {
        $brands = Brand::where('active', true)
            ->withCount(['products' => function ($query) {
                $query->where('active', true);
            }])
            ->get();

        return $brands;
    }
}

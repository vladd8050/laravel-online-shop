<?php

namespace AutoKit\Http\Controllers;

use AutoKit\Category;
use AutoKit\Menu;
use AutoKit\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view(
            'main',
            [
                'menu_navigation' => Menu::with('categories')->get(),
                'categories' => Category::whereNotNull('img')->with('menu')->inRandomOrder()->take(8)->get(),
                'top_products' => Product::where('is_top', 1)->inRandomOrder()->take(4)->get(),
                'new_products' => Product::where('is_new', 1)->inRandomOrder()->take(4)->get()
            ]);
    }
}
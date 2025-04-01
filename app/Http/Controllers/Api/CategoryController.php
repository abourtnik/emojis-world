<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{

    public function index(): ResourceCollection
    {
        return new CategoryCollection(
            Category::query()
                ->select('id', 'name', 'count')
                ->with('subCategories')
                ->orderBy('id')
                ->get()
        );
    }
}

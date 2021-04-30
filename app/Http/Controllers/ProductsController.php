<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Image\Manipulations;
use Webpatser\Uuid\Uuid;

class ProductsController extends Controller
{
    public function lists() {

        $products = Product::where('status',1)-> paginate(10);
        return response($products, 200);

    }

}

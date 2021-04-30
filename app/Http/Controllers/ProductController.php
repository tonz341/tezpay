<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Image\Manipulations;
use Webpatser\Uuid\Uuid;

class ProductController extends Controller
{
    public function index($product) {

        $product = Product::where('uid',$product)->first();

        return view('product.index', ['product' => $product]);
    }


    public function create() {

        return view('product.create');
    }

    public function store(Request $request) {

        $path_1 = '';
        $path_2 = '';

        if($request->hasFile('image')) {
            $image       = $request->file('image');
//            $filename    = $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());

            $canvas = Image::canvas(640, 640);
            $canvas->insert($image_resize, 'center');
            $canvas->save(public_path($path_1 = 'images/products/' .md5(uniqid(mt_rand(), true)).'.jpg'));

            $canvas = Image::canvas(800, 800);
            $canvas->insert($image_resize, 'center');
            $canvas->save(public_path($path_2 = 'images/products/' .md5(uniqid(mt_rand(), true)).'.jpg'));
        }

        return Product::create([
            '640_640' => $path_1,
            '800_800' => $path_2,
            'name' => $request->name,
            'description' => $request->description,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'status' => true
        ]);
    }


}

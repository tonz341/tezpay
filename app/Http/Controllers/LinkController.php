<?php

namespace App\Http\Controllers;

use App\Link;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Image\Manipulations;
use Webpatser\Uuid\Uuid;

class LinkController extends Controller
{
    public function index($product) {

        $link = Link::where('uid',$product)->first();
        $usd = Cache::get('XTZUSDT');

        if(!$link) {
            $link = collect([]);
        }

        return view('link', ['link' => $link, 'usd' => $usd]);
    }


    public function store(Request $request) {

        $link = Link::create([
            'address' => $request->address,
            'name' => $request->name,
            'currency' => $request->currency,
            'price' => $request->price,
            'uid' => $this->uidGenerator()
        ]);

        return response(['link' => $link->uid ], 200);
    }


    public function conversion() {
        return response(['conversion' => Cache::get('XTZUSDT') ], 200);
    }

    private function uidGenerator(){

        $uid = Str::random(7);
        $link = Link::where('uid',$uid)->first();

        if($link) {
            $this->uidGenerator();
            return;
        }

        return $uid;
    }
}

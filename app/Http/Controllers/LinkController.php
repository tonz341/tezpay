<?php

namespace App\Http\Controllers;

use App\Link;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Image\Manipulations;
use Webpatser\Uuid\Uuid;

class LinkController extends Controller
{
    public function index($product) {

        $link = Link::where('uid',$product)->first();
        $usd = Cache::get('XTZUSDT');
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

        $uid = implode("",array_map(create_function('$s','return substr($s,mt_rand(0,strlen($s)),1);'),array_fill(0,7,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")));
        $link = Link::where('uid',$uid)->first();

        if($link) {
            $this->uidGenerator();
            return;
        }

        return $uid;
    }
}

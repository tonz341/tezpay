<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    //
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $uid = implode("",array_map(create_function('$s','return substr($s,mt_rand(0,strlen($s)),1);'),array_fill(0,7,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")));
            $model->uid = (string) $uid;
            $model->user_id = auth()->user()->id;
        });
    }
}

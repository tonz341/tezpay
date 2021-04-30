<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Link extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['expired_at'];


    public function getExpiredAtAttribute() {

        return $this->created_at->addYear()->format('d M Y');


    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // protected this field from create from array or class
    protected $guarded = ['id'];
}

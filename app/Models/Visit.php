<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visit extends Model
{
    protected $fillable = ['name','email','latitud','longitud'];


    public const paginate = 10;
}

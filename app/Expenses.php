<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

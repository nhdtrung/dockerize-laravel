<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagerTransaction extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['wager_id', 'buying_price', 'bought_at'];
}

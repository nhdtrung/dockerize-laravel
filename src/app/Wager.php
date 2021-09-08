<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wager extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['total_wager_value', 'odds', 'selling_percentage', 'selling_price', 'current_selling_price', 'placed_at'];
}

<?php

namespace App\Http\Resources\Wager;

use Illuminate\Http\Resources\Json\JsonResource;

class WagerResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total_wager_value' => $this->total_wager_value,
            'odds' => $this->odds,
            'selling_percentage' => $this->selling_percentage,
            'selling_price' => $this->selling_price,
            'current_selling_price' => $this->current_selling_price,
            'percentage_sold' => $this->percentage_sold,
            'amount_sold' => $this->amount_sold,
            'placed_at' => $this->placed_at,
        ];
    }
}

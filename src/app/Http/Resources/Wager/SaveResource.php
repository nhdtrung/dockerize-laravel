<?php

namespace App\Http\Resources\Wager;

use Illuminate\Http\Resources\Json\JsonResource;

class SaveResource extends JsonResource
{
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
            'wager_id' => $this->wager_id,
            'buying_price' => $this->buying_price,
            'bought_at' => $this->bought_at,
        ];
    }
}

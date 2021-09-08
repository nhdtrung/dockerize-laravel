<?php

namespace App\Repositories\Wager;

use App\Wager;
use Illuminate\Support\Carbon;

class WagerRepository
{
    /**
     * @var Wager
     */
    protected $wager;

    /**
     * WagerRepository constructor.
     *
     * @param Wager $wager
     */
    public function __construct(Wager $wager)
    {
        $this->wager = $wager;
    }

    /**
     * Store wager data
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        $wager = new $this->wager;

        $wager->total_wager_value = $data['total_wager_value'];
        $wager->odds = $data['odds'];
        $wager->selling_percentage = $data['selling_percentage'];
        $wager->selling_price = $data['selling_price'];
        $wager->current_selling_price = $data['selling_price'];
        $wager->placed_at = Carbon::now();
        $wager->save($data);

        return $wager->fresh();
    }

    /**
     * @param array $data
     * @param int $id
     */
    public function buy(array $data, int $id)
    {
        $wager = $this->getFirstById($id);

        $wager->amount_sold = $data['amount_sold'];
        $wager->percentage_sold = $data['percentage_sold'];
        $wager->current_selling_price = $data['current_selling_price'];

        $wager->save();
    }

    /**
     * Return list of wager with pagination
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    public function show(array $data)
    {
        $limit = $data['limit'];
        $page = $data['page'];

        return $this->wager->limit($limit)->offset(($page - 1) * $limit)->get();
    }

    /**
     * Get first wager by id
     *
     * @param $id
     * @return mixed
     */
    public function getFirstById($id)
    {
        return $this->wager
            ->where('id', $id)
            ->first();
    }
}

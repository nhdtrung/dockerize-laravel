<?php

namespace App\Repositories\Wager;

use App\WagerTransaction;
use Illuminate\Support\Carbon;

class WagerTransactionRepository
{
    /**
     * @var WagerTransaction
     */
    protected $wagerTransaction;

    /**
     * WagerRepository constructor.
     *
     * @param WagerTransaction $wagerTransaction
     */
    public function __construct(WagerTransaction $wagerTransaction)
    {
        $this->wagerTransaction = $wagerTransaction;
    }

    /**
     * Store wager transaction data
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function buy(array $data, int $id)
    {
        $wagerTrans = new $this->wagerTransaction;

        $wagerTrans->wager_id = $id;
        $wagerTrans->buying_price = $data['buying_price'];
        $wagerTrans->bought_at = Carbon::now();
        $wagerTrans->save();

        return $wagerTrans->fresh();
    }
}

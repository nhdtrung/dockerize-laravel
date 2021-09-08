<?php

namespace App\Services;

use App\Wager;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Repositories\Wager\WagerRepository;
use App\Repositories\Wager\WagerTransactionRepository;

class WagerService
{
    /**
     * @var $wagerRepository
     */
    protected $wagerRepository;

    /**
     * @var $wager
     */
    protected $wager;

    /**
     * @var $wager
     */
    protected $wagerTransactionRepository;

    /**
     * PostService constructor.
     *
     * @param WagerRepository $wagerRepository
     * @param WagerTransactionRepository $wagerTransactionRepository
     * @param Wager $wager
     */
    public function __construct(
        WagerRepository $wagerRepository,
        WagerTransactionRepository $wagerTransactionRepository,
        Wager $wager
    )
    {
        $this->wagerRepository = $wagerRepository;
        $this->wager = $wager;
        $this->wagerTransactionRepository = $wagerTransactionRepository;
    }

    /**
     * Validate and store wager.
     *
     * @throws CustomException
     * @throws Exception
     */
    public function store($data)
    {
        if ($data['selling_price'] <= $data['total_wager_value'] * ($data['selling_percentage'] / 100)) {
            throw new CustomException("Selling price must be greater than wager value * (selling_percentage / 100)!");
        }

        if ($data['selling_price'] > $data['total_wager_value']) {
            throw new CustomException("Selling price must be less or equal total wager value!");
        }

        try {
            $result = $this->wagerRepository->store($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage());
        }

        return $result;
    }

    /**
     * Validate and buy wager.
     *
     * @param array $data
     * @param int $id
     * @return mixed
     * @throws CustomException
     */
    public function buy(array $data, int $id)
    {
        $wager = $this->wager->where('id', $id)->first();
        $data['current_selling_price'] = $wager->current_selling_price;
        $data['current_buying_price'] = $data['buying_price'];
        $data['total_wager_value'] = $wager->total_wager_value;
        $data['amount_sold'] = $wager->amount_sold;

        if ($data['current_selling_price'] <= 0) {
            throw new CustomException("Wager out of stock!");
        }

        if ($data['current_buying_price'] > $data['current_selling_price']) {
            throw new CustomException("Buying price must be lesser or equal to selling price!");
        }

        if (is_null($data['amount_sold'])) {
            $data['amount_sold'] = $data['current_buying_price'];
        }

        $data['amount_sold'] += $data['current_buying_price'];
        $data['percentage_sold'] = $data['amount_sold'] * 100 / $data['total_wager_value'];
        $data['current_selling_price'] = $data['total_wager_value'] - $data['amount_sold'];

        DB::beginTransaction();
        try {
            $this->wagerRepository->buy($data, $id);
            $result = $this->wagerTransactionRepository->buy($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Get wager by condition params
     *
     * @param $data
     * @return \Illuminate\Support\Collection
     * @throws CustomException
     */
    public function show($data)
    {
        try {
            $result = $this->wagerRepository->show($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new CustomException($e->getMessage());
        }

        return $result;
    }
}

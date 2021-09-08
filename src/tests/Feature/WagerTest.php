<?php

namespace Tests\Feature;

use App\Wager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_wager_can_store()
    {
        $this->withoutExceptionHandling();

        $this->postJson("/wagers", [
            'total_wager_value' => 100000,
            'odds' => 5,
            'selling_percentage' => 10,
            'selling_price' => 50000,
        ]);

        $this->assertCount(1, Wager::all());
    }

    /** @test */
    public function test_wager_response_correct_json_structure()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson("/wagers", [
            'total_wager_value' => 100000,
            'odds' => 5,
            'selling_percentage' => 10,
            'selling_price' => 50000,
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'id',
            'total_wager_value',
            'odds',
            'selling_percentage',
            'selling_price',
            'current_selling_price',
            'percentage_sold',
            'amount_sold',
            'placed_at'
        ]);
    }

    /** @test */
    public function test_wager_store_has_error_with_total_wager_value_is_negative()
    {
        $response = $this->postJson("/wagers", [
            'total_wager_value' => -1,
            'odds' => 5,
            'selling_percentage' => 10,
            'selling_price' => 5000,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_wager_store_has_error_with_total_wager_value_not_int()
    {
        $response = $this->postJson("/wagers", [
            'total_wager_value' => 10.1,
            'odds' => 5,
            'selling_percentage' => 10,
            'selling_price' => 5000,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_wager_store_has_error_with_odds_not_int()
    {
        $response = $this->postJson("/wagers", [
            'total_wager_value' => 10000,
            'odds' => 55.5,
            'selling_percentage' => 10,
            'selling_price' => 5000,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_wager_store_has_error_with_selling_percentage_not_between_1_to_100()
    {
        $response = $this->postJson("/wagers", [
            'total_wager_value' => 10000,
            'odds' => 5,
            'selling_percentage' => 111,
            'selling_price' => 5000,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_wager_store_has_error_with_selling_percentage_not_int()
    {
        $response = $this->postJson("/wagers", [
            'total_wager_value' => 10000,
            'odds' => 5,
            'selling_percentage' => 10.5,
            'selling_price' => 5000,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_buy_wager_with_buying_price()
    {
        $wager = Wager::create([
            "total_wager_value" => 10000,
            "odds" => 5,
            "selling_percentage" => 10,
            "selling_price" => "20.00",
            "current_selling_price" => "20.00",
            "percentage_sold" => null,
            "amount_sold" => null,
            "placed_at" => "2021-06-22 15:55:42"
        ]);

        $response = $this->postJson("/buy/" . $wager->id, [
            'buying_price' => 20,
        ]);

        $response->assertJsonStructure([
            'id',
            'wager_id',
            'buying_price',
            'bought_at'
        ]);
    }

    /** @test */
    public function test_buy_wager_with_buying_price_greater_than_selling_price()
    {
        $wager = Wager::create([
            "total_wager_value" => 10000,
            "odds" => 5,
            "selling_percentage" => 10,
            "selling_price" => "20.00",
            "current_selling_price" => "20.00",
            "percentage_sold" => null,
            "amount_sold" => null,
            "placed_at" => "2021-06-22 15:55:42"
        ]);

        $response = $this->postJson("/buy/" . $wager->id, [
            'buying_price' => 200,
        ]);

        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_get_wager_listed_successfully()
    {
        Wager::create([
            "total_wager_value" => 100,
            "odds" => 10,
            "selling_percentage" => 10,
            "selling_price" => "20.00",
            "current_selling_price" => "20.00",
            "percentage_sold" => null,
            "amount_sold" => null,
            "placed_at" => "2021-06-22 15:55:42"
        ]);

        Wager::create([
            "total_wager_value" => 1000,
            "odds" => 10,
            "selling_percentage" => 10,
            "selling_price" => "20.00",
            "current_selling_price" => "20.00",
            "percentage_sold" => null,
            "amount_sold" => null,
            "placed_at" => "2021-06-22 15:55:42"
        ]);

        $this->json('GET', '/wagers?page=1&limit=2', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "total_wager_value",
                    "odds",
                    "selling_percentage",
                    "selling_price",
                    "current_selling_price",
                    "percentage_sold",
                    "amount_sold",
                    "placed_at"
                ],
                [
                    "id",
                    "total_wager_value",
                    "odds",
                    "selling_percentage",
                    "selling_price",
                    "current_selling_price",
                    "percentage_sold",
                    "amount_sold",
                    "placed_at"
                ]
            ]);
    }
}

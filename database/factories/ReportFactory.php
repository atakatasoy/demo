<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    private $buyerYielder;
    private $sellerYielder;
    private $current;

    public function __construct($count = null,
                                ?Collection $states = null,
                                ?Collection $has = null,
                                ?Collection $for = null,
                                ?Collection $afterMaking = null,
                                ?Collection $afterCreating = null,
                                $connection = null)
    {
        $this->buyerYielder = $this->buyerIncrementer();
        $this->sellerYielder = $this->sellerIncrementer();
        
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {        
        return [
            'report_type_id' => $this->faker->numberBetween(1,3),
            'user_id' => null,
            'last_sent_at' => null,
        ];
    }

    public function sellerIncrementer()
    {
        yield 'initial';

        for($i = 1;$i < 41 ;$i++){
            yield $i;

            if($i == 40) $i = 0;
        }
    }

    public function buyerIncrementer()
    {
        yield 'initial';

        for($i = 41; $i < 541 ; $i++){
            yield $i;

            if($i == 540) $i = 40;
        }
    }

    public function getNextBuyer()
    {
        $this->buyerYielder->next();

        return $this->buyerYielder->current();
    }

    public function getNextSeller()
    {
        $this->sellerYielder->next();

        return $this->sellerYielder->current();
    }

    public function seller()
    {
        return $this->state(function (array $attributes){
            return [
                'user_id' => $this->getNextSeller()
            ];
        });
    }

    public function buyer()
    {
        return $this->state(function (array $attributes){
            return [
                'user_id' => $this->getNextBuyer()
            ];
        });
    }

    public function dailyReport()
    {
        return $this->state(function (array $attributes){
            return [
                'report_type_id' => 1
            ];
        });
    }

    public function weeklyReport()
    {
        return $this->state(function (array $attributes){
            return [
                'report_type_id' => 2
            ];
        });
    }

    public function monthlyReport()
    {
        return $this->state(function (array $attributes){
            return [
                'report_type_id' => 3
            ];
        });
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Fabricante;
use App\Vehiculo;
use Faker\Factory as Faker;

class VehiculoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $cantidad = Fabricante::all()->count();
        for($i = 0; $i < 10; $i++){
            Vehiculo::create
            ([
                "color" => $faker->safeColorName(),
                "cilindraje" => $faker->randomNumber(3),
                "potencia" => $faker->randomNumber(3),
                "peso" => $faker->randomNumber(3),
                "fabricante_id" => $faker->numberBetween(1,$cantidad)
            ]);
        }
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equip;
use App\Models\Client;
use Faker\Factory as Faker;

class EquipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $clientId = Client::inRandomOrder()->value('idAuvo');

            Equip::create([
                'auvoId' => $faker->numerify('#####'),
                'clientAuvoId' => $clientId,
            ]);


        }
    }
}

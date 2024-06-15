<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;


class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Client::factory(1)->create();
        //\App\Models\User::factory(100)->create();
        //\App\Models\Client::factory(100)->create();
        //User::factory(20)->create();
        $this->call([
            ClientSeeder::class,
        ]);
    }
}

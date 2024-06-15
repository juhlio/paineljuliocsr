<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 1000; $i++) {
            Client::create([
                'razaoSocial' => $faker->company,
                'nome' => $faker->name,
                'cnpj' => $faker->numerify('##.###.###/####-##'),
                'cnpjFormatado' => $faker->numerify('##############'),
                'classificacao' => 'GRANDE PORTE',
                'telefone' => $faker->numerify('(##)#########'),
                'cep' => $faker->numerify('#####-###'),
                'endereco' => $faker->address,
                'bairro' => $faker->word,
                'cidade' => $faker->city,
                'uf' => $faker->stateAbbr,
                'email' => $faker->safeEmail,
                'emailCobranca' => $faker->safeEmail,
                'idAuvo' => $faker->randomNumber(5, true),
            ]);
        }
    }
}

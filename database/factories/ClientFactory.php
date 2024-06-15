<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'razaoSocial' => $this->faker->name,
            'nome' => $this->faker->name,
            'cnpj' => $this->faker->numerify('##.###.###/####-##'),
            'cnpjFormatado' => $this->faker->numerify('##############'),
            'classificacao' => $this->faker->text('GRANDE PORTE'),
            'telefone' => $this->faker->numerify('(##)#########'),
            'cep' => $this->faker->numerify('#####-###'),
            'endereco' => $this->faker->address,
            'bairro' => $this->faker->text(5),
            'cidade' => $this->faker->text(10),
            'uf' => $this->faker->stateAbbr,
            'email' => $this->faker->safeEmail,
            'emailCobranca' => $this->faker->safeEmail,
            'idAuvo' => $this->faker->numerify(5),
        ];
    }
}

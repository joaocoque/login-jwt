<?php

namespace Database\Seeders;

use App\Models\Faq\Faq;
use App\Models\FaqCategory\FaqCategory;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqCategory::create([
            'title' => 'Perguntas Gerais',
            'active' => true
        ]);

        FaqCategory::create([
            'title' => 'Perguntas sobre login',
            'active' => true
        ]);

         Faq::create([
            'question' => 'porque o sol é amarelo?',
            'answer' => 'Na verdade, o Sol é branco!
            O engano acontece porque a atmosfera da Terra filtra a luz solar, separando as cores. Ela espalha raios azuis e violeta, fazendo com que só as outras cores cheguem até nossos olhos. Esses tons restantes é que dão a impressão de o Sol ser amarelo.',
            'active' => true,
            'category_id' => 1
        ]);

        Faq::create([
            'question' => 'porque a agua do oceano é salgada?',
            'answer' => 'A água do mar é composta por uma solução de uma série de diferentes tipos de sais minerais que são dissolvidos ao longo de centenas de milhões de anos. Esses sais tem origem na erosão da chuva, do mar, do vento, de caudais dos rios e do arrasto de pequenas partículas de rochas em direção ao mar.',
            'active' => true,
            'category_id' => 1
        ]);

        Faq::create([
            'question' => 'porque tenho problemas ao realizar login?',
            'answer' => 'Confira antes suas credenciais corretamene e tente novamente.',
            'active' => true,
            'category_id' => 2
        ]);
    }
}

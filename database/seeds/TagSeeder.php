<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('tags')->insert([
            [
                'name' => 'Yaya',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Aydinlatma',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Bisiklet',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Trafik',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Agaclandirma',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Park',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Enerji',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Geri donusum',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Diger',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Kaldirim',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Kiyi',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Meydan',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Toplu Tasima',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Egitim',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Saglik',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Sosyal etkinlikler',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Güvenlik',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Kültür ve Sanat',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Altyapi',
                'background' => '#f1b328'
            ],
            [
                'name' => 'Su',
                'background' => '#f1b328'
            ]
        ]);
    }
}

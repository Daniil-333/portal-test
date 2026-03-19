<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            'title' => 'Сладкие',
            'slug' => Str::of('Сладкие')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Фруктовые',
            'slug' => Str::of('Фруктовые')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Ягодные',
            'slug' => Str::of('Ягодные')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Мужские',
            'slug' => Str::of('Мужские')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'IT',
            'slug' => Str::of('IT')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => '9 мая',
            'slug' => Str::of('9 мая')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'СССР',
            'slug' => Str::of('СССР')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Стойкие',
            'slug' => Str::of('Стойкие')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Овощные',
            'slug' => Str::of('Овощные')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Цитрусовые',
            'slug' => Str::of('Цитрусовые')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Лечебные',
            'slug' => Str::of('Лечебные')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'Мангал',
            'slug' => Str::of('Мангал')->slug('-'),
        ]);

        DB::table('tags')->insert([
            'title' => 'ПП',
            'slug' => Str::of('ПП')->slug('-'),
        ]);
    }
}

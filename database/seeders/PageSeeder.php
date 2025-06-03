<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Условия использования',
                'slug' => 'terms',
                'content' => '<h2>Условия использования</h2><p>Текст условий использования...</p>',
                'meta_description' => 'Условия использования нашего сайта',
            ],
            [
                'title' => 'Политика конфиденциальности',
                'slug' => 'privacy',
                'content' => '<h2>Политика конфиденциальности</h2><p>Текст политики конфиденциальности...</p>',
                'meta_description' => 'Политика конфиденциальности нашего сайта',
            ],
            [
                'title' => 'Доставка и оплата',
                'slug' => 'shipping',
                'content' => '<h2>Доставка и оплата</h2><p>Информация о доставке и оплате...</p>',
                'meta_description' => 'Информация о доставке и оплате',
            ],
        ];

        foreach ($pages as $page) {
            Page::create(array_merge($page, ['active' => true]));
        }

        Page::factory(3)->create();
    }
}

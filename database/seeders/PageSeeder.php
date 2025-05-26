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
                'title_ru' => 'Условия использования',
                'title_en' => 'Terms of Use',
                'slug' => 'terms',
                'content_ru' => '<h2>Условия использования</h2><p>Текст условий использования...</p>',
                'content_en' => '<h2>Terms of Use</h2><p>Terms of use text...</p>',
                'meta_description_ru' => 'Условия использования нашего сайта',
                'meta_description_en' => 'Terms of use for our website',
            ],
            [
                'title_ru' => 'Политика конфиденциальности',
                'title_en' => 'Privacy Policy',
                'slug' => 'privacy',
                'content_ru' => '<h2>Политика конфиденциальности</h2><p>Текст политики конфиденциальности...</p>',
                'content_en' => '<h2>Privacy Policy</h2><p>Privacy policy text...</p>',
                'meta_description_ru' => 'Политика конфиденциальности нашего сайта',
                'meta_description_en' => 'Privacy policy for our website',
            ],
            [
                'title_ru' => 'Доставка и оплата',
                'title_en' => 'Shipping and Payment',
                'slug' => 'shipping',
                'content_ru' => '<h2>Доставка и оплата</h2><p>Информация о доставке и оплате...</p>',
                'content_en' => '<h2>Shipping and Payment</h2><p>Shipping and payment information...</p>',
                'meta_description_ru' => 'Информация о доставке и оплате',
                'meta_description_en' => 'Information about shipping and payment',
            ],
        ];

        foreach ($pages as $page) {
            Page::create(array_merge($page, ['active' => true]));
        }

        Page::factory(3)->create();
    }
}

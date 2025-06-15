<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->generateRussianProductName();

        $description = $this->generateRussianDescription();

        $imageWidth = 640;
        $imageHeight = 480;
        $imagePath = $this->generateAndSaveImage('images', $imageWidth, $imageHeight);

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'name' => $name,
            'name_en' => null,
            'slug' => Str::slug($name),
            'description' => $description,
            'description_en' => null,
            'price' => $this->faker->numberBetween(100, 10000),
            'image' => $imagePath,
            'gallery' => null,
            'specifications' => [
                'weight' => $this->faker->numberBetween(100, 5000) . ' г',
                'dimensions' => $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . ' см',
                'color' => $this->getRussianColorName()
            ],
            'quantity' => $this->faker->numberBetween(0, 100),
            'active' => true,
        ];
    }

    protected function generateRussianProductName(): string
    {
        $productTypes = [
            'Смартфон', 'Ноутбук', 'Телевизор', 'Наушники', 'Фотоаппарат',
            'Планшет', 'Монитор', 'Клавиатура', 'Мышь', 'Принтер',
            'Холодильник', 'Стиральная машина', 'Микроволновая печь', 'Пылесос', 'Утюг'
        ];

        $brands = [
            'Pro', 'Elite', 'Premium', 'Gold', 'Platinum',
            'Max', 'Ultra', 'Super', 'Mega', 'Turbo'
        ];

        $features = [
            'с 4K экраном', 'с поддержкой 5G', 'с функцией AI', 'с голосовым управлением',
            'с защитой от воды', 'с быстрой зарядкой', 'с расширенной гарантией', 'с улучшенной камерой'
        ];

        return sprintf(
            '%s %s %s',
            $this->faker->randomElement($productTypes),
            $this->faker->randomElement($brands),
            $this->faker->randomElement($features)
        );
    }

    protected function generateRussianDescription(): string
    {
        $paragraphs = [];

        $introPhrases = [
            'Представляем вашему вниманию',
            'Новинка на рынке -',
            'Инновационный продукт -',
            'Современное решение для вашего дома -',
            'Профессиональное оборудование -'
        ];

        $features = [
            'Высокое качество сборки и материалов.',
            'Эргономичный дизайн для максимального комфорта.',
            'Интуитивно понятный интерфейс управления.',
            'Энергоэффективная работа позволяет экономить на эксплуатации.',
            'Поддержка всех современных стандартов и технологий.',
            'Долгий срок службы гарантирован производителем.',
            'Быстрая и отзывчивая работа системы.',
            'Удобство использования подтверждено тысячами покупателей.'
        ];

        $warranty = [
            'Гарантия 2 года от производителя.',
            'Официальная гарантия в России.',
            'Сервисное обслуживание по всей стране.',
            'Поддержка 24/7 от нашей службы заботы о клиентах.'
        ];

        $paragraphs[] = $this->faker->randomElement($introPhrases) . ' ' . $this->faker->sentence(6);
        $paragraphs[] = implode(' ', $this->faker->randomElements($features, 3));
        $paragraphs[] = $this->faker->randomElement($warranty);

        return implode("\n\n", $paragraphs);
    }

    protected function getRussianColorName(): string
    {
        $colors = [
            'белый', 'черный', 'красный', 'синий', 'зеленый',
            'желтый', 'серый', 'серебристый', 'золотой', 'розовый',
            'фиолетовый', 'оранжевый', 'коричневый', 'бежевый', 'голубой'
        ];

        return $this->faker->randomElement($colors);
    }

    protected function generateAndSaveImage(string $folder, int $width, int $height): string
    {
        $image = imagecreatetruecolor($width, $height);

        $bgColor = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
        $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

        imagefill($image, 0, 0, $bgColor);

        $text = $this->faker->word();
        $fontSize = 5;

        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $centerX = ($width - $textWidth) / 2;
        $centerY = ($height - $textHeight) / 2;

        imagestring($image, $fontSize, $centerX, $centerY, $text, $textColor);

        for ($i = 0; $i < 10; $i++) {
            $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline(
                $image,
                rand(0, $width), rand(0, $height),
                rand(0, $width), rand(0, $height),
                $lineColor
            );
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'img');
        imagepng($image, $tmpFile);
        imagedestroy($image);

        $fileName = $folder . '/' . uniqid('photo_', true) . '.png';

        $filePath = Storage::disk('public')->putFileAs(
            $folder,
            $tmpFile,
            basename($fileName)
        );

        unlink($tmpFile);

        return $filePath;
    }
}

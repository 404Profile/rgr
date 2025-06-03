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
        $name = $this->faker->words(3, true);

        $imageWidth = 640;
        $imageHeight = 480;
        $imagePath = $this->generateAndSaveImage('images', $imageWidth, $imageHeight);

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(100, 10000),
            'image' => $imagePath,
            'gallery' => null,
            'specifications' => [
                'weight' => $this->faker->numberBetween(100, 5000) . ' г',
                'dimensions' => $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . ' см',
                'color' => $this->faker->colorName()
            ],
            'quantity' => $this->faker->numberBetween(0, 100),
            'active' => true,
        ];
    }

    protected function generateAndSaveImage(string $folder, int $width, int $height): string
    {
        $image = imagecreatetruecolor($width, $height);

        $bgColor = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
        $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

        imagefill($image, 0, 0, $bgColor);

        $text = fake()->word();
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

<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        $imageWidth = 640;
        $imageHeight = 480;
        $imagePath = $this->generateAndSaveImage('images', $imageWidth, $imageHeight);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'image' => $imagePath,
            'type' => 'news',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'active' => true,
        ];
    }

    public function promo(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'promo',
            ];
        });
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

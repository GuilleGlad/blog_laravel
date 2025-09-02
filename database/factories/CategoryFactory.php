<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $temp_image = $this->faker->image('app/temp', 640, 480, null, false);
        $file = new UploadedFile(
            $temp_image,
            'fake_image.jpg',
            null,
            true
        );
        $image = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'Categories',
            ])->getSecurePath();

        $name = $this->faker->unique()->word(10);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $image,
            'is_featured' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}

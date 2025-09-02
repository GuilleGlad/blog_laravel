<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
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
                'folder' => 'Articles',
            ])->getSecurePath();
        $title = $this->faker->unique()->realText(55);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'introduction' => $this->faker->realText(255, true),
            'image' => $image,
            'body' => $this->faker->text(2000),
            'status' => $this->faker->boolean(), 
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}

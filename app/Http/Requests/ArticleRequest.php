<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $slug = request()->isMethod('put') ? 'required|unique:articles,slug,' . $this->id : 'required|unique:articles'; // Validate slug uniqueness
        // If the request method is PUT, allow the current article's slug to be unchanged
        // Otherwise, ensure the slug is unique across all articles

        // Image validation rules
        // If the request method is PUT, the image is optional; otherwise, it is required
        // The image must be of type jpeg, jpg, png, gif, or svg and not exceed 8000 KB
        $image = request()->isMethod('put') ? 'nullable|mimes:jpeg,jpg,png,gif,svg|max:8000' : 'required|mimes:jpeg,jpg,png|max:8000';

        return [
            'title' => 'required|min:5|max:255',
            'slug' => $slug,
            'introduction' => 'required|min:10|max:500',
            'body' => 'required',
            'image' => $image,
            'status' => 'required|boolean',
            'category_id' => 'required|integer',
        ];
    }
}

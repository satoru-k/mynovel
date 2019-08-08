<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\katakana;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $this->user = Auth::user();

        return [
          'name'  => 'required|max:20',
          'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
          'ruby' => ['max:20', new katakana],
          'hobby' => 'max:100',
          'job' => 'max:100',
          'website' => 'max:100|url|active_url|nullable',
          'introduction' => 'max:500',
        ];
    }
}

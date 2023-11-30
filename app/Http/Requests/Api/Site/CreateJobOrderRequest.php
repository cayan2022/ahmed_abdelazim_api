<?php

namespace App\Http\Requests\Api\Site;

use App\Models\Country;
use App\Rules\SupportedImage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobOrderRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'phone'=>['required',Rule::phone()->country(Country::query()->pluck('iso_code')->toArray())],
            'email'=>['required', 'email:rfc,dns'],
            'cv' => ['required','max:5120','mimes:jpg,png,jpeg,pdf,doc,docx']
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class OuvrierFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'exists:countries,id'],
            'region_id' => ['required', 'exists:regions,id'],
            'departement_id' => 'required', 'exists:departements,id',
            'metiers' => ['required', 'array', 'exists:metiers,id'],
            'domaines' => ['required', 'array', 'exists:domaines,id'],
            'date_of_birth' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4048'], 
            'phone_number' => ['required', 'string', 'max:255', 'unique:ouvriers,phone_number'],
            'email' => ['nullable', 'email', 'max:255', 'unique:ouvriers,email'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number_2' => ['nullable', 'string', 'max:255'],
            'photo_cni' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4048'], 
            'numero_cni' => ['nullable', 'string', 'max:255', 'unique:ouvriers,numero_cni'],
            'annees_experience' => ['numeric', 'max:255'],
            'user_id' => ['uuid','nullable', 'exists:users,id'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
            'diplomes' => ['array', 'nullable'],
            'diplomes.*' => ['exists:diplomes,id'],
            'entreprises' => ['nullable', 'array'],
            'entreprises.*' => ['nullable', 'string'],
        ];
    }
}



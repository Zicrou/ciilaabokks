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
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:country,id',
            'region_id' => 'required|exists:region,id',
            'departement_id' => 'required|exists:departement,id',
            'metier_id' => 'required|exists:metier,id',
            'domain_id' => 'required|exists:domain,id',
            'date_of_birth' => 'required|date',
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'phone_number' => ['required', 'string', 'max:255', Rule::unique('ouvrier', 'phone_number')->ignore($this->route('ouvrier'))],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number_2' => ['nullable', 'string', 'max:255'],
            'photo_cni' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'numero_cni' => ['nullable', 'string', 'max:255'],
            'annees_experience' => ['numeric', 'max:255'],
            'entreprises' => ['nullable', 'string', 'max:255'],
            'user_id' => ['uuid','nullable'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048'],
            'diplomes' => ['array', 'exists:diplomes,id', 'required'],
            'diplomes.*' => ['uuid'], // or exists:diplomes,id
        ];
    }
}

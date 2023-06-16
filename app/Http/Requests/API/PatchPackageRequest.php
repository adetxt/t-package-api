<?php

namespace App\Http\Requests\API;

use App\Data\PatchPackageData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class PatchPackageRequest extends FormRequest
{
    use WithData;

    protected function dataClass(): string
    {
        return PatchPackageData::class;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'transaction_id' => $this->route('id'),
        ]);
    }

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }
}

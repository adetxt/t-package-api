<?php

namespace App\Http\Requests\API;

use App\Data\PackageData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class PutPackageRequest extends FormRequest
{
    use WithData;

    protected function dataClass(): string
    {
        return PackageData::class;
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
        return [
            'koli_data.*.connote_id' => ['required', 'uuid', 'same:connote.connote_id'],
        ];
    }
}

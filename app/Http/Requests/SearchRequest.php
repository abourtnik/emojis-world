<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    const array AVAILABLE_VERSIONS = ['0.6', '0.7', '1.0', '2.0', '3.0', '4.0', '5.0', '11.0', '12.0', '12.1', '13.0', '13.1', '14.0', '15.0'];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $filters = ['categories', 'sub_categories', 'versions'];

        foreach ($filters as $filter){
            if ($this->has($filter)) {
                $this->merge([$filter => explode(',' ,$this->get($filter))]);
            }
        }

        $this->mergeIfMissing([
            'limit' => 50,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'limit' => [
                'nullable',
                'integer',
                'min:1',
                'max:50'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'categories.*' => [
                'integer',
                'between:1,10'
            ],
            'sub_categories' => [
                'nullable',
                'array'
            ],
            'sub_categories.*' => [
                'integer',
                'between:1,100'
            ],
            'versions' => [
                'nullable',
                'array'
            ],
            'versions.*' => [
                'decimal:1',
                Rule::in(self::AVAILABLE_VERSIONS)
            ],
        ];

        if ($this->routeIs('emojis.search')) {
            $rules['q'] = [
                'required',
                'string',
                'max:100'
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'categories.*' => 'categories must be list of unsigned integers between 1 and 10',
            'sub_categories.*' => 'sub_categories must be list of unsigned integers between 1 and 10',
            'versions.*' => 'versions must be list of floats in this list : ' . implode(', ', self::AVAILABLE_VERSIONS),
        ];
    }
}

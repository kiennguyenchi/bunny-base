<?php

namespace App\Http\Requests;

use App\Models\Rabbit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRabbitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Rabbit::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'tattoo_id' => [
                'required',
                'string',
                'max:255',
                'unique:rabbits'
            ],
            'sex' => [
                'required',
                'string',
                'max:255',
                Rule::in(['buck', 'doe']),
            ],
            'sire_id' => [
                'nullable',
                'integer',
                Rule::exists('rabbits', 'id')->where(function ($query) {
                    $query->where('tenant_id', Auth::user()->tenant_id)
                        ->where('sex', 'buck');
                }),
            ],
            'dam_id' => [
                'nullable',
                'integer',
                Rule::exists('rabbits', 'id')->where(function ($query) {
                    $query->where('tenant_id', Auth::user()->tenant_id)
                        ->where('sex', 'doe');
                }),
            ],
        ];
    }
}

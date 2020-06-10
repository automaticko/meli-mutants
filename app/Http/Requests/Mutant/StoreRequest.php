<?php

namespace App\Http\Requests\Mutant;

use App\Rules\ValidDNA;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function expectsJson()
    {
        return true;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dna' => ['present', new ValidDNA()],
        ];
    }
}

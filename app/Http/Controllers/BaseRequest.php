<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Validate the request before authorize() function
     */
    public function validateResolved()
    {
        $validator = $this->getValidatorInstance();

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        }
    }       
}
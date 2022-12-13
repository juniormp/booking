<?php

namespace Tests;

use Illuminate\Contracts\Validation\Validator as FieldValidator;
use Illuminate\Support\Facades\Validator;

trait RequestValidatorHelper
{
    private array $rules;

    protected function validateField($field, $value): bool
    {
        return $this->getFieldValidator($field, $value)->passes();
    }

    protected function getFieldValidator($field, $value): FieldValidator
    {
        return Validator::make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }
}

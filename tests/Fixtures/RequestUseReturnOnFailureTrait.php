<?php

namespace Tests\Fixtures;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Phu1237\AwesomeValidation\Traits\ReturnRuleOnFailure;

class RequestUseReturnOnFailureTrait
{
    use ReturnRuleOnFailure;

    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function input(string $key) {
        return $this->data[$key] ?? NULL;
    }

    /**
     * @throws HttpResponseException
     */
    public function callFailedValidation(Validator $validator): void {
        $this->failedValidation($validator);
    }
}

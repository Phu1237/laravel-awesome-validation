<?php

namespace Phu1237\AwesomeValidation\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ReturnFailedMessageKey
{
    private $config;

    public function __construct() {
        $this->config = config('awesome_validation.return_failed_message_key');
    }

    protected function failedValidation(Validator $validator) {
        $config = $this->config;

        $errors = $this->creatFailedRulesCollection($validator->failed());
        $errors = $this->createFailedOutput($errors);

        // Remove the number of array validation. Name must be not contains . character
        if ($config['return']['merge_array_validation']) {
            $errors = $errors->mapWithKeys(function ($messages, $key) {
                $shortKey = Str::beforeLast($key, '.');
                return [$shortKey => $messages];
            });
        }

        // Trả về phản hồi JSON
        throw new HttpResponseException(response()->json([
            'errors' => $errors,
        ], $this->config['return']['status_code']));
    }

    private function creatFailedRulesCollection(array $failedRules): Collection {
        return (new Collection($failedRules))->mapWithKeys(function ($rules, $key) {
            $value = $this->input($key);
            $messages = $this->config['return']['return_first_error_only'] ? "" : [];

            foreach ($rules as $rule => $params) {
                $message = [];
                // Check if the rule has parameters (e.g., min:8, max:10)
                $lowerRuleName = strtolower($rule);
                $ruleName = $this->config['return']['prefix'] . $lowerRuleName;
                if (!$this->config['return']['full_rule_name']) {
                    $keyParts = explode("\\", $ruleName);
                    $ruleName = end($keyParts);
                }
                $message['name'] = $ruleName;

                if ($this->config['parameters']['include_in_return']) {
                    $isInIncludeList = empty($this->config['parameters']['include']) || in_array($lowerRuleName, $this->config['parameters']['include']);
                    $isInExcludeList = empty($this->config['parameters']['exclude']) || in_array($lowerRuleName, $this->config['parameters']['exclude']);
                    $message['params'] = !$isInExcludeList && $isInIncludeList ? $params : NULL;
                }

                if ($this->config['value']['include_in_return']) {
                    $message['value'] = $value;
                }

                if ($this->config['return']['return_first_error_only']) {
                    $messages = $message;
                } else {
                    $messages[] = $message;
                }
            }
            return [$key => $messages];
        });
    }

    private function createFailedOutput(Collection $errors): Collection {
        return $errors->mapWithKeys(function ($value, $key) {
            if (is_array($value)) {
                $value = (new Collection($value))->mapWithKeys(function ($itemValue, $itemKey) {
                    return [$itemKey => $this->createFailedOutputValue($itemValue)];
                });
            } else {
                $value = $this->createFailedOutputValue($value);
            }
            return [$key => $value];
        });
    }

    private function createFailedOutputValue($value) {
        if ($this->config['return']['return_type'] === 'string') {
            if (isset($value['params'])) {
                $value['params'] = implode($this->config['return']['separator']['parameter'], $value['params']);
            }
            $value = implode($this->config['return']['separator']['attribute'], $value);
        }
        return $value;
    }
}

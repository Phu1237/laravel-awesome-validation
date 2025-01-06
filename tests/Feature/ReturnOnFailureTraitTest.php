<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Tests\Fixtures\RequestUseReturnOnFailureTrait;

/*
 * Parameters config
 */
test('test config: parameters.include_in_return = true', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10',
            ],
            'decimal' => [
                'decimal:1,2'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: parameters.include_in_return = false', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => false,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: parameters.include is empty', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.parameters.include' => []
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10',
            ],
            'decimal' => [
                'decimal:1,2'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: parameters.include contain 1 item', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.parameters.include' => [
            'between',
        ]
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $request = new RequestUseReturnOnFailureTrait($input);
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2',
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10'
            ],
            'decimal' => [
                'decimal:'
            ]
        ]
    ], 422));

    try {
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: parameters.exclude is empty', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.parameters.exclude' => [],
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10',
            ],
            'decimal' => [
                'decimal:1,2'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: parameters.exclude contain 1 item', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.parameters.exclude' => [
            'between',
        ]
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:',
            ],
            'decimal' => [
                'decimal:1,2'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

/*
 * Value config
 */
test('test config: value.include_in_return = true', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:11',
            ],
            'decimal' => [
                'decimal:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: value.include_in_return = false', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => false,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: value.include is empty', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include' => []
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:11',
            ],
            'decimal' => [
                'decimal:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: value.include contain 1 item', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include' => [
            'between',
        ]
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $request = new RequestUseReturnOnFailureTrait($input);
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2',
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:11'
            ],
            'decimal' => [
                'decimal:'
            ]
        ]
    ], 422));

    try {
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: value.exclude is empty', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.exclude' => [],
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:11',
            ],
            'decimal' => [
                'decimal:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: value.exclude contain 1 item', function () {
    config([
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.exclude' => [
            'between',
        ]
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:',
            ],
            'decimal' => [
                'decimal:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

/*
 * Return config
 */
//test('test config: return.full_rule_name = true', function () {
//    config([
//        'awesome_validation.return_rule_on_failure.return.full_rule_name' => true,
//    ]);
//    $input = [
//        'number' => 11,
//        'decimal' => 11,
//    ];
//    $validator = Validator::make($input, [
//        'number' => 'integer|between:1,10',
//        'decimal' => 'integer|decimal:1,2'
//    ]);
//    $validator->fails();
//
//    $this->expectException(HttpResponseException::class);
//    $expect = new HttpResponseException(response()->json([
//        'errors' => [
//            'number' => [
//                'between:1,10',
//            ],
//            'decimal' => [
//                'decimal:1,2'
//            ]
//        ]
//    ], 422));
//
//    try {
//        $request = new RequestUseReturnOnFailureTrait($input);
//        $request->callFailedValidation($validator);
//    } catch (HttpResponseException $exception) {
//        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
//            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
//        throw $exception;
//    }
//});
//test('test config: return.full_rule_name = false', function () {
//    config([
//        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
//        'awesome_validation.return_rule_on_failure.parameters.exclude' => [],
//    ]);
//    $input = [
//        'number' => 11,
//        'decimal' => 11,
//    ];
//    $validator = Validator::make($input, [
//        'number' => 'integer|between:1,10',
//        'decimal' => 'integer|decimal:1,2'
//    ]);
//    $validator->fails();
//
//    $this->expectException(HttpResponseException::class);
//    $expect = new HttpResponseException(response()->json([
//        'errors' => [
//            'number' => [
//                'between:1,10',
//            ],
//            'decimal' => [
//                'decimal:1,2'
//            ]
//        ]
//    ], 422));
//
//    try {
//        $request = new RequestUseReturnOnFailureTrait($input);
//        $request->callFailedValidation($validator);
//    } catch (HttpResponseException $exception) {
//        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
//            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
//        throw $exception;
//    }
//});

test('test config: return.merge_array_validation = true', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.merge_array_validation' => true,
    ]);
    $input = [
        'array' => [1, 2, 3, 11],
    ];
    $validator = Validator::make($input, [
        'array' => 'array|min:1',
        'array.*' => 'integer|between:1,10'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'array' => [
                'between',
            ],
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.merge_array_validation = false', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.merge_array_validation' => false,
    ]);
    $input = [
        'array' => [1, 2, 3, 11],
    ];
    $validator = Validator::make($input, [
        'array' => 'array|min:1',
        'array.*' => 'integer|between:1,10'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'array.3' => [
                'between',
            ],
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }

});

test('test config: return.prefix is blank', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.prefix' => '',
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.prefix is \'validation.\'', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.prefix' => 'validation.',
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'validation.between',
            ],
            'decimal' => [
                'validation.decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: return.separator.attribute is colon (:)', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.return.separator.attribute' => ":",
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10:11',
            ],
            'decimal' => [
                'decimal:1,2:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.separator.attribute is vertical bar (|)', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.return.separator.attribute' => "|",
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between|1,10|11',
            ],
            'decimal' => [
                'decimal|1,2|11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.separator.parameter is comma (,)', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.return.separator.parameter' => ",",
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1,10:11',
            ],
            'decimal' => [
                'decimal:1,2:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.separator.parameter is semicolon (;)', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.return.separator.parameter' => ";",
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between:1;10:11',
            ],
            'decimal' => [
                'decimal:1;2:11'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: return.return_first_error_only = true', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.return_first_error_only' => true,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => 'between',
            'decimal' => 'decimal'
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.return_first_error_only = false', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.return_first_error_only' => false,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between'
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: return.return_type = string', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.return_type' => 'string',
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.return_type = array', function () {
    config([
        'awesome_validation.return_rule_on_failure.parameters.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.value.include_in_return' => true,
        'awesome_validation.return_rule_on_failure.return.return_type' => 'array',
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                [
                    'name' => 'between',
                    'params' => ["1", "10"],
                    'value' => 11
                ],
            ],
            'decimal' => [
                [
                    'name' => 'decimal',
                    'params' => ["1", "2"],
                    'value' => 11
                ],
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

test('test config: return.status_code = 422', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.status_code' => 422,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 422));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});
test('test config: return.return_type = 400', function () {
    config([
        'awesome_validation.return_rule_on_failure.return.status_code' => 400,
    ]);
    $input = [
        'number' => 11,
        'decimal' => 11,
    ];
    $validator = Validator::make($input, [
        'number' => 'integer|between:1,10',
        'decimal' => 'integer|decimal:1,2'
    ]);
    $validator->fails();

    $this->expectException(HttpResponseException::class);
    $expect = new HttpResponseException(response()->json([
        'errors' => [
            'number' => [
                'between',
            ],
            'decimal' => [
                'decimal'
            ]
        ]
    ], 400));

    try {
        $request = new RequestUseReturnOnFailureTrait($input);
        $request->callFailedValidation($validator);
    } catch (HttpResponseException $exception) {
        expect($exception->getResponse()->getStatusCode())->toBe($expect->getResponse()->getStatusCode())
            ->and($exception->getResponse()->getContent())->toBe($expect->getResponse()->getContent());
        throw $exception;
    }
});

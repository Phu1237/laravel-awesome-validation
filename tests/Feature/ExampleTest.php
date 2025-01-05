<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Tests\Fixtures\Request;

test('confirm environment is set to testing', function () {
	$input = [
		
	];
	$request = new Request($input);
	$validator = Validator::make($input, [
		'title' => 'required'
	]);
	// var_dump($validator->validated());
	if ($validator->fails()) {
		// var_dump($validator->validated());
		var_dump($validator->failed());
	}
	expect(fn() => $request->callFailedValidation($validator))->toThrow(HttpResponseException::class, response()->json([
		'errors' => ['1'],
	], 422));
    // expect(fn() => $request->callFailedValidation($validator))->toThrow(422);
});
<?php
namespace Tests\Fixtures;

use Illuminate\Contracts\Validation\Validator;
use Phu1237\AwesomeValidation\Traits\ReturnFailedMessageKey;

class Request {
	use ReturnFailedMessageKey;
	
	private array $data;
	
	public function __construct(array $data) {
		$this->data = $data;
	}
	public function input(string $key) {
		return isset($data[$key]) ? $data[$key] : NULL;
	}

	public function callFailedValidation(Validator $validator) {
		try {
			/* Your Code */
			$this->failedValidation($validator);
		  } catch (\Exception $e) {
			 var_dump($e->getLine(), [
				$e->getFile()
			 ]);
			 throw $e;
		  }
	}
}
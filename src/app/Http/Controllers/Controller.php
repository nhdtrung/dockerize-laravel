<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(
                [
                    'message' => $errors,
                ], \Illuminate\Http\JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}

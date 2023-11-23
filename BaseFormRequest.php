<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Request;

class BaseFormRequest extends FormRequest
{
    public static function convertRequest($from, $to = null)
    {

        $request = self::createFrom($from, $to);

        $app = app();
        $request
            ->setContainer($app)
            ->setRedirector($app->make(Redirector::class));

        $request->prepareForValidation();
        $request->getValidatorInstance();

        return $request;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cover;
use Illuminate\Validation\Rule;

class StoreCoverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->method() === 'POST') {
            return [
                'title' => ['required', 'string', 'max:255', 'unique:covers'],
            ];
        }
        $cover = Cover::find($request['id']);
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('covers')->ignore($cover->id)],
        ];
    }
}

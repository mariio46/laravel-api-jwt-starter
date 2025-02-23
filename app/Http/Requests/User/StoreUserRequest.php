<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                Password::defaults(),
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'name')->where(fn (Builder $query) => $query->where('name', '!=', 'superadmin')),
            ],
        ];
    }
}

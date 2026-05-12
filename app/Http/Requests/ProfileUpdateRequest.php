<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Fields sensitif (role_id, position_id)
            // SENGAJA tidak dimasukkan di sini — hanya Admin yang boleh mengubahnya
            'company_id' => ['nullable', 'integer', 'exists:company,id'],
            'department_id' => ['nullable', 'integer', 'exists:department,id'],
            'target_position_id' => ['nullable', 'integer', 'exists:position,id'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'foto_base64' => ['nullable', 'string'],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'should_delete_foto' => ['nullable', 'boolean'],
        ];
    }
}

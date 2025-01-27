<?php

namespace App\Actions\Fortify;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'],
            'apellido' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'], // Eliminar el carácter |
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);

        Cliente::create([
            'nombre' => $input['name'],
            'apellido' => $input['apellido'],
            'email' => $input['email'],
            'telefono' => $input['phone'],
            'id_user' => $user->id,
        ]);

        return $user;
    }
}

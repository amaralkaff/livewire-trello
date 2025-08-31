<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Validation\Rules\Password;

class UserValidationRules
{
    public static function name(): array
    {
        return ['required', 'string', 'max:255'];
    }
    
    public static function email($userId = null): array
    {
        $rules = ['required', 'string', 'lowercase', 'email', 'max:255'];
        
        if ($userId) {
            $rules[] = 'unique:' . User::class . ',email,' . $userId;
        } else {
            $rules[] = 'unique:' . User::class;
        }
        
        return $rules;
    }
    
    public static function password(): array
    {
        return ['required', 'string', 'confirmed', Password::defaults()];
    }
    
    public static function currentPassword(): array
    {
        return ['required', 'string', 'current_password'];
    }
}
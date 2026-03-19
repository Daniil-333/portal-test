<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator as ValidationContract;
use Illuminate\Support\Facades\Validator;
use App\Rules\RecaptchaRule;
use App\Http\Validators\Validator as ValidatorContract;

class RegisterValidator implements ValidatorContract
{
    public function run(array $data): ValidationContract
    {
        return Validator::make($data, $this->getRules(), $this->getMessages(), $this->getAttributes());
    }

    public function getRules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:64'],
            'email' => [
                'required',
                'string',
                'email',
                'max:64',
                'exists:white_list_users,email',
                'unique:users',
            ],
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
            'recaptcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    public function getMessages(): array
    {
        return [
            'user_name.required' => 'Поле “:attribute” обязателен к заполнению!',
            'email.required' => 'Поле “:attribute” обязателен к заполнению!',
            'email.email' => '“:attribute” не корректный!',
            'email.max' => '“:attribute” слишком велик!',
            'email.exist' => 'Вы не избранный!',
            'email.unique' => 'Этот :attribute уже зарегестрирован!',
            'password.required' => '“:attribute” обязателен к заполнению!',
            'password.min' => '“:attribute” должен быть более 8 символов!',
            'password.max' => '“:attribute” должен быть не более 16 символов!',
            'password.confirmed' => 'Пароли не совпадают!',
            'recaptcha_token.required' => 'А как же капча? Вдруг ты Бот?',
        ];
    }

    public function getAttributes(): array
    {
        return [
            'user_name' => 'Имя',
            'email' => 'Email адрес',
            'password' => 'Пароль',
            'recaptcha_token' => 'Капча',
        ];
    }
}

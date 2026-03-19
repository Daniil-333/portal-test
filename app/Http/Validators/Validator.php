<?php

namespace App\Http\Validators;

interface Validator
{
    public function getRules(): array;
    public function getMessages(): array;
    public function getAttributes(): array;
}

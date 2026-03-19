<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CategoryData extends Data
{
    public function __construct(
        public string $id,
        public string $title,
    ) {}

}

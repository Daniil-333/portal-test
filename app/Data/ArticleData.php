<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ArticleData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $slug,
        public int $read_time,
        public string $short_desc,
        public string $description,
        public string $image,
        public string $image_path,
        public string $created_at,
    ) {}
}

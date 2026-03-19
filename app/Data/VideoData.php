<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class VideoData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $slug,
        public string $short_desc,
        public string $description,
        public string $file_name,
        public string $file_path,
        public CategoryData $category,
        /** @var TagData[] */
        public array $tags,
    ) {}

}

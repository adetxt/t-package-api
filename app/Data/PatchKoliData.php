<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PatchKoliData extends Data
{
    public function __construct(
        public int $koli_length,
        public string $awb_url,
        public int $koli_chargeable_weight,
        public int $koli_width,
        public array|Optional $koli_surcharge,
        public int $koli_height,
        public string $koli_description,
        public ?string $koli_formula_id,
        public int $koli_volume,
        public int $koli_weight,
        #[Uuid()]
        public string $koli_id,
        public array $koli_custom_field,
        public string $koli_code
    ) {
    }
}

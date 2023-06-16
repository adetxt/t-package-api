<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ConnoteData extends Data
{
    public function __construct(
        #[Uuid()]
        public string $connote_id,
        public int $connote_number,
        public string $connote_service,
        public float $connote_service_price,
        public float $connote_amount,
        public string $connote_code,
        public ?string $connote_booking_code,
        public int $connote_order,
        public string $connote_state,
        public int $connote_state_id,
        public string $zone_code_from,
        public string $zone_code_to,
        public ?string $surcharge_amount,
        #[Uuid()]
        public string $transaction_id,
        public int $actual_weight,
        public int $volume_weight,
        public int $chargeable_weight,
        public int $organization_id,
        public string $location_id,
        public string $connote_total_package,
        public string $connote_surcharge_amount,
        public string $connote_sla_day,
        public string $location_name,
        public string $location_type,
        public string $source_tariff_db,
        public string $id_source_tariff,
        public ?string $pod,
        public array|Optional $history
    ) {
    }
}

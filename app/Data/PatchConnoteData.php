<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PatchConnoteData extends Data
{
    public function __construct(
        public int|Optional $connote_number,
        public string|Optional $connote_service,
        public float|Optional $connote_service_price,
        public float|Optional $connote_amount,
        public string|Optional $connote_code,
        public string|null|Optional $connote_booking_code,
        public int|Optional $connote_order,
        public string|Optional $connote_state,
        public int|Optional $connote_state_id,
        public string|Optional $zone_code_from,
        public string|Optional $zone_code_to,
        public string|null|Optional $surcharge_amount,
        public int|Optional $actual_weight,
        public int|Optional $volume_weight,
        public int|Optional $chargeable_weight,
        public int|Optional $organization_id,
        public string|Optional $location_id,
        public string|Optional $connote_total_package,
        public string|Optional $connote_surcharge_amount,
        public string|Optional $connote_sla_day,
        public string|Optional $location_name,
        public string|Optional $location_type,
        public string|Optional $source_tariff_db,
        public string|Optional $id_source_tariff,
        public string|null|Optional $pod,
        public array|Optional $history
    ) {
    }
}

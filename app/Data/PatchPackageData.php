<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class PatchPackageData extends Data
{
    public function __construct(
        public string|Optional $customer_name,
        public string|Optional $customer_code,
        public string|Optional $transaction_amount,
        public string|Optional $transaction_discount,
        public string|null|Optional $transaction_additional_field,
        public string|Optional $transaction_payment_type,
        public string|Optional $transaction_state,
        public string|Optional $transaction_code,
        #[Min(1)]
        public int|Optional $transaction_order,
        public string|Optional $location_id,
        public int|Optional $organization_id,
        public string|Optional $transaction_payment_type_name,
        public float|Optional $transaction_cash_amount,
        public float|Optional $transaction_cash_change,
        public array|Optional $customer_attribute,
        public PatchConnoteData|Optional $connote,
        public array|Optional $origin_data,
        public array|Optional $destination_data,
        #[DataCollectionOf(PatchKoliData::class)]
        public DataCollection|Optional $koli_data,
        public array|Optional $custom_field,
        public array|Optional $currentLocation
    ) {
    }
}

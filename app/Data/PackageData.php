<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Same;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class PackageData extends Data
{
    public function __construct(
        #[Uuid(), Same('connote.transaction_id')]
        public string $transaction_id,
        public string $customer_name,
        public string $customer_code,
        public string $transaction_amount,
        public string $transaction_discount,
        public string|null|Optional $transaction_additional_field,
        public string $transaction_payment_type,
        public string $transaction_state,
        public string $transaction_code,
        #[Min(1)]
        public int $transaction_order,
        public string $location_id,
        public int $organization_id,
        public string $transaction_payment_type_name,
        public float $transaction_cash_amount,
        public float $transaction_cash_change,
        public array $customer_attribute,
        public ConnoteData $connote,
        #[Uuid(), Same('connote.connote_id')]
        public string $connote_id,
        public array $origin_data,
        public array $destination_data,
        #[DataCollectionOf(KoliData::class)]
        public DataCollection $koli_data,
        public array $custom_field,
        public array $currentLocation
    ) {
    }
}

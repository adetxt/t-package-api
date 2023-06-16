<?php

namespace App\Services;

use App\Data\PackageData;
use App\Data\PatchPackageData;
use App\Models\Connote;
use App\Models\Koli;
use App\Models\Transaction;

final class PackageService
{
    public function __construct(
        protected Transaction $transactionModel
    ) {
    }

    public function getAll(): array
    {
        $res = [];

        $trans = $this->transactionModel->with('connote', 'koliData')->get();

        foreach ($trans as $value) {
            $res[] = PackageData::from($value);
        }

        return $res;
    }

    public function getByTransactionID(string $transaction_id): PackageData
    {
        return PackageData::from(
            $this->transactionModel->with('connote', 'koliData')
                ->whereTransactionId($transaction_id)
                ->firstOrFail()
        );
    }

    public function store(PackageData $data): PackageData
    {
        Connote::create($data->connote->toArray());

        foreach ($data->koli_data as $value) {
            Koli::create($value->toArray());
        }

        /**
         * @var Transaction
         */
        $transaction = $this->transactionModel->create($data->toArray());

        $transaction->load('connote', 'koliData');

        return PackageData::from($transaction);
    }

    public function upsert(PackageData $data, string $transaction_id): PackageData
    {
        /**
         * @var Transaction
         */
        $trans = $this->transactionModel->whereTransactionId($transaction_id)->first();

        if (!$trans) {
            return $this->store($data);
        }

        $trans->update($data->toArray());

        $trans->connote->update($data->connote->toArray());

        foreach ($trans->koliData as $value) {
            $value->delete();
        }

        foreach ($data->koli_data as $value) {
            $trans->koliData()->create($value->toArray());
        }

        return PackageData::from($trans);
    }

    public function updatePartial(PatchPackageData $data, string $transaction_id): void
    {
        /**
         * @var Transaction
         */
        $trans = $this->transactionModel->whereTransactionId($transaction_id)->firstOrFail();

        $trans->update($data->toArray());

        if (!empty($data->connote)) {
            $trans->connote->update($data->connote->toArray());
        }

        if (!empty($data->koli_data)) {
            foreach ($trans->koliData as $value) {
                $value->delete();
            }

            foreach ($data->koli_data as $value) {
                $trans->koliData()->create($value->toArray());
            }
        }
    }

    public function delete(string $transaction_id): void
    {
        Transaction::whereTransactionId($transaction_id)->delete();
    }
}

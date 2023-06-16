<?php

namespace Tests\Unit;

use App\Data\PackageData;
use App\Models\Transaction;
use App\Services\PackageService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class PackageServiceTest extends TestCase
{
    public function test_get_package_by_transaction_id(): void
    {
        [$trans, $connote, $kolis] = $this->dataPackage();
        $trans['connote'] = $connote;
        $trans['koli_data'] = $kolis;

        $transactionId = 'd0090c40-539f-479a-8274-899b9970bddc';

        $mock = Mockery::mock(Transaction::class);
        $mock->shouldReceive('with')->with('connote', 'koliData')->andReturn($mock);
        $mock->shouldReceive('whereTransactionId')->with($transactionId)->andReturn($mock);
        $mock->shouldReceive('firstOrFail')->andReturn($trans);

        $a = (new PackageService($mock))->getByTransactionID($transactionId);

        $this->assertInstanceOf(PackageData::class, $a);
        $this->assertTrue(count($a->koli_data) > 0);
        $this->assertEquals($trans['connote_id'], $a->connote_id);
        $this->assertEquals($trans['transaction_id'], $transactionId);
    }

    public function test_store()
    {
        [$trans, $connote, $kolis] = $this->dataPackage();
        $trans['connote'] = $connote;
        $trans['koli_data'] = $kolis;

        $data = PackageData::from($trans);
        $transModel = new Transaction($trans);
        $transModel->connote = $connote;
        $transModel->koli_data = $kolis;

        /**
         * @var Transaction|MockInterface
         */
        $mock = Mockery::mock(Transaction::class);
        $mock2 = Mockery::mock($transModel);

        $mock->shouldReceive('create')->once()->with($data->toArray())->andReturn($mock2);
        $mock2->shouldReceive('load')->once()->with('connote', 'koliData');

        $a = (new PackageService($mock))->store($data);

        $this->assertInstanceOf(PackageData::class, $a);
        $this->assertEquals($trans['transaction_id'], $a->transaction_id);
        $this->assertEquals($trans['connote_id'], $a->connote->connote_id);
    }

    public function test_upsert_insert()
    {
        [$trans, $connote, $kolis] = $this->dataPackage();
        $trans['connote'] = $connote;
        $trans['koli_data'] = $kolis;

        $data = PackageData::from($trans);
        $transactionId = 'd0090c40-539f-479a-8274-899b9970bddc';
        $transModel = new Transaction($trans);

        /**
         * @var Transaction|MockInterface
         */
        $mock = Mockery::mock(Transaction::class);
        $mock->shouldReceive('whereTransactionId')->once()->with($transactionId)->andReturn($mock);
        $mock->shouldReceive('first')->once()->andReturn(null);

        $mock->shouldReceive('create')->once()->with($data->toArray())->andReturn($transModel);

        $a = (new PackageService($mock))->upsert($data, $transactionId);

        $this->assertInstanceOf(PackageData::class, $a);
        $this->assertEquals($trans['transaction_id'], $a->transaction_id);
    }

    public function test_upsert_update()
    {
        [$trans, $connote, $kolis] = $this->dataPackage();
        $trans['connote'] = $connote;
        $trans['koli_data'] = $kolis;

        $data = PackageData::from($trans);
        $transactionId = 'd0090c40-539f-479a-8274-899b9970bddc';
        $transModel = new Transaction($trans);
        $transModel->connote = $connote;
        $transModel->koli_data = $kolis;

        /**
         * @var Transaction|MockInterface
         */
        $mock = Mockery::mock(Transaction::class);
        $mock2 = Mockery::mock($transModel);

        $mock->shouldReceive('whereTransactionId')->once()->with($transactionId)->andReturn($mock);
        $mock->shouldReceive('first')->once()->andReturn($mock2);

        $mock2->shouldReceive('update')->once()->with($data->toArray());

        $a = (new PackageService($mock))->upsert($data, $transactionId);

        $this->assertInstanceOf(PackageData::class, $a);
        $this->assertEquals($trans['transaction_id'], $a->transaction_id);
    }

    public function dataPackage()
    {
        $connote = [
            'connote_id' => 'f70670b1-c3ef-4caf-bc4f-eefa702092ed',
            'connote_number' => 1,
            'connote_service' => 'ECO',
            'connote_service_price' => 70700,
            'connote_amount' => 70700,
            'connote_code' => 'AWB00100209082020',
            'connote_booking_code' => null,
            'connote_order' => 326931,
            'connote_state' => 'PAID',
            'connote_state_id' => 2,
            'zone_code_from' => 'CGKFT',
            'zone_code_to' => 'SMG',
            'surcharge_amount' => null,
            'transaction_id' => 'd0090c40-539f-479a-8274-899b9970bddc',
            'actual_weight' => 20,
            'volume_weight' => 0,
            'chargeable_weight' => 20,
            'organization_id' => 6,
            'location_id' => '5cecb20b6c49615b174c3e74',
            'connote_total_package' => '3',
            'connote_surcharge_amount' => '0',
            'connote_sla_day' => '4',
            'location_name' => 'Hub Jakarta Selatan',
            'location_type' => 'HUB',
            'source_tariff_db' => 'tariff_customers',
            'id_source_tariff' => '1576868',
            'pod' => null,
            'history' => [],
        ];

        $kolis = [
            [
                'koli_length' => 0,
                'awb_url' => 'https://tracking.mile.app/label/AWB00100209082020.1',
                'koli_chargeable_weight' => 9,
                'koli_width' => 0,
                'koli_surcharge' => [],
                'koli_height' => 0,
                'koli_description' => 'V WARP',
                'koli_formula_id' => null,
                'connote_id' => 'f70670b1-c3ef-4caf-bc4f-eefa702092ed',
                'koli_volume' => 0,
                'koli_weight' => 9,
                'koli_id' => 'e2cb6d86-0bb9-409b-a1f0-389ed4f2df2d',
                'koli_custom_field' => [
                    'awb_sicepat' => null,
                    'harga_barang' => null,
                ],
                'koli_code' => 'AWB00100209082020.1',
            ],
            [
                'koli_length' => 0,
                'awb_url' => 'https://tracking.mile.app/label/AWB00100209082020.2',
                'koli_chargeable_weight' => 9,
                'koli_width' => 0,
                'koli_surcharge' => [],
                'koli_height' => 0,
                'koli_description' => 'V WARP',
                'koli_formula_id' => null,
                'connote_id' => 'f70670b1-c3ef-4caf-bc4f-eefa702092ed',
                'koli_volume' => 0,
                'koli_weight' => 9,
                'koli_id' => '3600f10b-4144-4e58-a024-cc3178e7a709',
                'koli_custom_field' => [
                    'awb_sicepat' => null,
                    'harga_barang' => null,
                ],
                'koli_code' => 'AWB00100209082020.2',
            ],
            [
                'koli_length' => 0,
                'awb_url' => 'https://tracking.mile.app/label/AWB00100209082020.3',
                'koli_chargeable_weight' => 2,
                'koli_width' => 0,
                'koli_surcharge' => [],
                'koli_height' => 0,
                'koli_description' => 'LID HOT CUP',
                'koli_formula_id' => null,
                'connote_id' => 'f70670b1-c3ef-4caf-bc4f-eefa702092ed',
                'koli_volume' => 0,
                'koli_weight' => 2,
                'koli_id' => '2937bdbf-315e-4c5e-b139-fd39a3dfd15f',
                'koli_custom_field' => [
                    'awb_sicepat' => null,
                    'harga_barang' => null,
                ],
                'koli_code' => 'AWB00100209082020.3',
            ],
        ];

        $trans = [
            'transaction_id' => 'd0090c40-539f-479a-8274-899b9970bddc',
            'customer_name' => 'PT. AMARA PRIMATIGA',
            'customer_code' => '1678593',
            'transaction_amount' => '70700',
            'transaction_discount' => '0',
            'transaction_additional_field' => null,
            'transaction_payment_type' => '29',
            'transaction_state' => 'PAID',
            'transaction_code' => 'CGKFT20200715121',
            'transaction_order' => 121,
            'location_id' => '5cecb20b6c49615b174c3e74',
            'organization_id' => 6,
            'transaction_payment_type_name' => 'Invoice',
            'transaction_cash_amount' => 0,
            'transaction_cash_change' => 0,
            'customer_attribute' => [
                'Nama_Sales' => 'Radit Fitrawikarsa',
                'TOP' => '14 Hari',
                'Jenis_Pelanggan' => 'B2B',
            ],
            'connote' => $connote,
            'connote_id' => 'f70670b1-c3ef-4caf-bc4f-eefa702092ed',
            'origin_data' => [
                'customer_name' => 'PT. NARA OKA PRAKARSA',
                'customer_address' => 'JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420',
                'customer_email' => 'info@naraoka.co.id',
                'customer_phone' => '024-1234567',
                'customer_address_detail' => null,
                'customer_zip_code' => '12420',
                'zone_code' => 'CGKFT',
                'organization_id' => 6,
                'location_id' => '5cecb20b6c49615b174c3e74',
            ],
            'destination_data' => [
                'customer_name' => 'PT AMARIS HOTEL SIMPANG LIMA',
                'customer_address' => 'JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH',
                'customer_email' => null,
                'customer_phone' => '0248453499',
                'customer_address_detail' => 'KOTA SEMARANG SEMARANG TENGAH KARANGKIDUL',
                'customer_zip_code' => '50241',
                'zone_code' => 'SMG',
                'organization_id' => 6,
                'location_id' => '5cecb20b6c49615b174c3e74',
            ],
            'koli_data' => $kolis,
            'custom_field' => [
                'catatan_tambahan' => 'JANGAN DI BANTING / DI TINDIH',
            ],
            'currentLocation' => [
                'name' => 'Hub Jakarta Selatan',
                'code' => 'JKTS01',
                'type' => 'Agent',
            ],
        ];

        return [$trans, $connote, $kolis];
    }
}

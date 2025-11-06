<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed MobileConfig (Branch data)
        DB::table('dbo.mobileconfig')->insert([
            [
                'BranchCode' => '00A',
                'Name' => 'SUMMARY TTH',
                'Description' => 'Summary TTH',
                'Value' => 'Emas 0.5 Gr|Emas 1 Gr|Emas 5 Gr|Emas 100 Gr|Voucher 50rb|Voucher 100rb|Voucher 150rb'
            ]
        ]);

        // Seed Sample Customers
        DB::table('dbo.customer')->insert([
            [
                'CustID' => '00A01090002',
                'Name' => 'Mirza',
                'Address' => 'Tengku Iskandar 5',
                'BranchCode' => '00A',
                'PhoneNo' => '+6282527716304'
            ],
            [
                'CustID' => '00A01090018',
                'Name' => 'Bintang Mandiri',
                'Address' => 'Tengku Iskandari (Blang Bintang Lama)',
                'BranchCode' => '00A',
                'PhoneNo' => '+6281360084071'
            ],
            [
                'CustID' => '00A01090021',
                'Name' => 'Varia Muge Profil',
                'Address' => 'T. Iskandar, Lam Glumpang',
                'BranchCode' => '00A',
                'PhoneNo' => '+628126982982'
            ],
            [
                'CustID' => '00A01090026',
                'Name' => 'Puga Jaya',
                'Address' => 'Kebun Raya Sp.4 Pineung Lamgugop',
                'BranchCode' => '00A',
                'PhoneNo' => '+6282527273340'
            ],
            [
                'CustID' => '00A01090033',
                'Name' => 'Mandiri Baru',
                'Address' => 'T Iskandar 4 Lamglumpang',
                'BranchCode' => '00A',
                'PhoneNo' => '+6282367767579'
            ]
        ]);

        // Seed Sample TTH
        DB::table('dbo.customertth')->insert([
            [
                'TTHNo' => 'TTH-00A-2306-50137',
                'SalesID' => '00AC1A0103',
                'TTOTTPNo' => 'TTOL-00A-2306-90079',
                'CustID' => '00A01090002',
                'DocDate' => '2023-06-20 00:00:00',
                'Received' => 0,
                'ReceivedDate' => '0000-00-00 00:00:00',
                'FailedReason' => null
            ]
        ]);

        // Seed Sample TTH Details
        DB::table('dbo.customertthdetail')->insert([
            [
                'TTHNo' => 'TTH-00A-2306-50137',
                'TTOTTPNo' => 'TTOL-00A-2306-90079',
                'Jenis' => 'Emas 0.5 Gr',
                'Qty' => 2,
                'Unit' => 'Buah'
            ],
            [
                'TTHNo' => 'TTH-00A-2306-50137',
                'TTOTTPNo' => 'TTOL-00A-2306-90081',
                'Jenis' => 'Voucher 100rb',
                'Qty' => 1,
                'Unit' => 'Lembar'
            ],
            [
                'TTHNo' => 'TTH-00A-2306-50137',
                'TTOTTPNo' => 'TTOL-00A-2306-90082',
                'Jenis' => 'Voucher 50rb',
                'Qty' => 5,
                'Unit' => 'Lembar'
            ],
            [
                'TTHNo' => 'TTH-00A-2306-50137',
                'TTOTTPNo' => 'TTOL-00A-2306-90083',
                'Jenis' => 'Emas 1 Gr',
                'Qty' => 2,
                'Unit' => 'Buah'
            ]
        ]);
    }
}

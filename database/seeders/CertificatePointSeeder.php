<?php

namespace Database\Seeders;

use App\Models\Certificate\CertificatePoint;
use Illuminate\Database\Seeder;

class CertificatePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $points = [
            'A1',
            'A2',
            'B1',
            'B2',
            'C1',
            'C2',
        ];

        foreach($points as $item) {
            CertificatePoint::create([
                'name' => $item
            ]);
        }
    }
}

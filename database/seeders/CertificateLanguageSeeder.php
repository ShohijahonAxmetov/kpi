<?php

namespace Database\Seeders;

use App\Models\Certificate\CertificateLanguage;
use Illuminate\Database\Seeder;

class CertificateLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            'Ingliz tili', //'Английский язык',
            'Nemis tili', //'Немецкий язык',
            'Arab tili', //'Арабский язык',
            'Xitoy tili', //'Китайский язык',
            'Koreya tili', //'Корейский язык',
            'Turk tili', //'Турецкий язык',
            'Fransuz tili', //'Французский язык',
            'Yapon tili', //'Японский язык',
            'Ispan tili', //'Испанский язык'
        ];

        foreach($languages as $item) {
            CertificateLanguage::create([
                'name' => $item
            ]);
        }
    }
}

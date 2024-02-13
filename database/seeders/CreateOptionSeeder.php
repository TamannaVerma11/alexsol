<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class CreateOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create([
            'key' => 'support_address',
            'value' => 'Solørvegen 1022, 2260 Kirkenær',
        ]);
        Option::create([
            'key' => 'support_email',
            'value' => 'backoffice@nogd.no',
        ]);
        Option::create([
            'key' => 'support_phone',
            'value' => '62949000',
        ]);
    }
}

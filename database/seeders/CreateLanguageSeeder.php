<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class CreateLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'English',
            'language_code' => 'en',
            'active' => 1,
            'lang_default' => 1,
        ]);
        Language::create([
            'name' => 'Norwegian',
            'language_code' => 'nb',
            'active' => 1,
            'lang_default' => 1,
        ]);
        Language::create([
            'name' => 'Swedish',
            'language_code' => 'sv',
            'active' => 0,
        ]);
        Language::create([
            'name' => 'Danish',
            'language_code' => 'da',
            'active' => 0,
        ]);
        Language::create([
            'name' => 'German',
            'language_code' => 'de',
            'active' => 0,
        ]);
        Language::create([
            'name' => 'Spanish',
            'language_code' => 'es',
            'active' => 0,
        ]);
        Language::create([
            'name' => 'Hindi',
            'language_code' => 'hi',
            'active' => 0,
        ]);
    }
}

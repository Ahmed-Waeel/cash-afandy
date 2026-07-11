<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Redot\Jobs\SyncLanguageTokens;
use Redot\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = config('redot.locales');

        foreach ($languages as $language) {
            $this->seedLanguage($language);
        }
    }

    /**
     * Seed a language.
     */
    protected function seedLanguage(array $language): void
    {
        $language = Language::create([
            'code' => $language['code'],
            'name' => $language['name'] ?? strtoupper($language['code']),
            'is_rtl' => $language['is_rtl'] ?? false,
        ]);

        SyncLanguageTokens::dispatchSync($language);
    }
}

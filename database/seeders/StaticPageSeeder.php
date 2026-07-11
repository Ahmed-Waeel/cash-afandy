<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            'privacy-policy' => [
                'en' => 'Privacy Policy',
                'ar' => 'سياسة الخصوصية',
            ],
            'terms-and-conditions' => [
                'en' => 'Terms and Conditions',
                'ar' => 'الشروط والأحكام',
            ],
            'contact-us' => [
                'en' => 'Contact Us',
                'ar' => 'تواصل معنا',
            ],
            'faq' => [
                'en' => 'FAQ',
                'ar' => 'الأسئلة الشائعة',
            ],
        ];

        foreach ($pages as $slug => $title) {
            $content = [
                'ar' => fake()->paragraphs(3, true),
                'en' => fake()->paragraphs(3, true),
            ];

            StaticPage::updateOrCreate(
                ['slug' => $slug],
                ['title' => $title, 'content' => $content]
            );
        }
    }
}

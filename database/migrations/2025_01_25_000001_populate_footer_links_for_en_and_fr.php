<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $appUrl = config('app.url');

        $footerLinksData = [
            'en' => [
                'column_1' => [
                    [
                        'url'        => $appUrl.'/page/about-us',
                        'title'      => 'About Us',
                        'sort_order' => 1,
                    ], [
                        'url'        => $appUrl.'/contact-us',
                        'title'      => 'Contact Us',
                        'sort_order' => 2,
                    ], [
                        'url'        => $appUrl.'/page/customer-service',
                        'title'      => 'Customer Service',
                        'sort_order' => 3,
                    ], [
                        'url'        => $appUrl.'/page/whats-new',
                        'title'      => 'What\'s New',
                        'sort_order' => 4,
                    ], [
                        'url'        => $appUrl.'/page/terms-of-use',
                        'title'      => 'Terms of Use',
                        'sort_order' => 5,
                    ], [
                        'url'        => $appUrl.'/page/terms-conditions',
                        'title'      => 'Terms & Conditions',
                        'sort_order' => 6,
                    ],
                ],
                'column_2' => [
                    [
                        'url'        => $appUrl.'/page/privacy-policy',
                        'title'      => 'Privacy Policy',
                        'sort_order' => 1,
                    ], [
                        'url'        => $appUrl.'/page/payment-policy',
                        'title'      => 'Payment Policy',
                        'sort_order' => 2,
                    ], [
                        'url'        => $appUrl.'/page/shipping-policy',
                        'title'      => 'Shipping Policy',
                        'sort_order' => 3,
                    ], [
                        'url'        => $appUrl.'/page/refund-policy',
                        'title'      => 'Refund Policy',
                        'sort_order' => 4,
                    ], [
                        'url'        => $appUrl.'/page/return-policy',
                        'title'      => 'Return Policy',
                        'sort_order' => 5,
                    ],
                ],
            ],
            'fr' => [
                'column_1' => [
                    [
                        'url'        => $appUrl.'/page/about-us',
                        'title'      => 'À propos de nous',
                        'sort_order' => 1,
                    ], [
                        'url'        => $appUrl.'/contact-us',
                        'title'      => 'Contactez-nous',
                        'sort_order' => 2,
                    ], [
                        'url'        => $appUrl.'/page/customer-service',
                        'title'      => 'Service client',
                        'sort_order' => 3,
                    ], [
                        'url'        => $appUrl.'/page/whats-new',
                        'title'      => 'Quoi de neuf',
                        'sort_order' => 4,
                    ], [
                        'url'        => $appUrl.'/page/terms-of-use',
                        'title'      => 'Conditions d\'utilisation',
                        'sort_order' => 5,
                    ], [
                        'url'        => $appUrl.'/page/terms-conditions',
                        'title'      => 'Termes et conditions',
                        'sort_order' => 6,
                    ],
                ],
                'column_2' => [
                    [
                        'url'        => $appUrl.'/page/privacy-policy',
                        'title'      => 'Politique de confidentialité',
                        'sort_order' => 1,
                    ], [
                        'url'        => $appUrl.'/page/payment-policy',
                        'title'      => 'Politique de paiement',
                        'sort_order' => 2,
                    ], [
                        'url'        => $appUrl.'/page/shipping-policy',
                        'title'      => 'Politique d\'expédition',
                        'sort_order' => 3,
                    ], [
                        'url'        => $appUrl.'/page/refund-policy',
                        'title'      => 'Politique de remboursement',
                        'sort_order' => 4,
                    ], [
                        'url'        => $appUrl.'/page/return-policy',
                        'title'      => 'Politique de retour',
                        'sort_order' => 5,
                    ],
                ],
            ],
        ];

        foreach ($footerLinksData as $locale => $options) {
            DB::table('theme_customization_translations')->insert([
                'theme_customization_id' => 11,
                'locale'                 => $locale,
                'options'                => json_encode($options),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('theme_customization_translations')
            ->where('theme_customization_id', 11)
            ->whereIn('locale', ['en', 'fr'])
            ->delete();
    }
};

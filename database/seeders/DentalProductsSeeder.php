<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DentalProductsSeeder extends Seeder
{
    /**
     * Attribute Type Fields.
     *
     * @var array
     */
    public $attributeTypeFields = [
        'text'        => 'text_value',
        'textarea'    => 'text_value',
        'price'       => 'float_value',
        'boolean'     => 'boolean_value',
        'select'      => 'integer_value',
        'multiselect' => 'text_value',
        'datetime'    => 'datetime_value',
        'date'        => 'date_value',
        'file'        => 'text_value',
        'image'       => 'text_value',
        'checkbox'    => 'text_value',
    ];

    /**
     * Base path for dental product images.
     */
    const DENTAL_IMAGES_PATH = 'database/seeders/images/dental/';

    /**
     * Seed the dental products.
     *
     * @return void
     */
    public function run()
    {
        $this->createDentalCategory();
        $this->seedDentalProducts();
    }

    /**
     * Create dental categories structure.
     *
     * @return array
     */
    protected function createDentalCategory()
    {
        $now = Carbon::now();
        $categoryIds = [];

        // Create main dental category if it doesn't exist
        $mainCategoryExists = DB::table('categories')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', 'dental-products')
            ->exists();
        
        if (!$mainCategoryExists) {
            // Simple nested set: main category
            $mainCategoryId = DB::table('categories')->insertGetId([
                'position' => 1,
                'logo_path' => null,
                'status' => 1,
                'display_mode' => 'products_and_description',
                'parent_id' => null,
                'additional' => null,
                'banner_path' => null,
                '_lft' => 1,
                '_rgt' => 19,  // 9 subcategories * 2 + 1
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Insert translations for main category
            DB::table('category_translations')->insert([
                [
                    'name' => 'Dental Products',
                    'slug' => 'dental-products',
                    'description' => 'Professional dental equipment and supplies',
                    'meta_title' => 'Dental Products - Professional Equipment',
                    'meta_description' => 'Shop professional dental equipment, tools, and supplies',
                    'meta_keywords' => 'dental, equipment, tools, professional',
                    'category_id' => $mainCategoryId,
                    'locale' => 'en',
                ],
                [
                    'name' => 'Produits Dentaires',
                    'slug' => 'produits-dentaires',
                    'description' => 'Équipements et fournitures dentaires professionnels',
                    'meta_title' => 'Produits Dentaires - Équipement Professionnel',
                    'meta_description' => 'Achetez des équipements, outils et fournitures dentaires professionnels',
                    'meta_keywords' => 'dentaire, équipement, outils, professionnel',
                    'category_id' => $mainCategoryId,
                    'locale' => 'fr',
                ],
                [
                    'name' => 'منتجات طب الأسنان',
                    'slug' => 'dental-products-ar',
                    'description' => 'معدات ومستلزمات طب الأسنان الاحترافية',
                    'meta_title' => 'منتجات طب الأسنان - معدات احترافية',
                    'meta_description' => 'تسوق معدات وأدوات ومستلزمات طب الأسنان الاحترافية',
                    'meta_keywords' => 'طب الأسنان، معدات، أدوات، احترافي',
                    'category_id' => $mainCategoryId,
                    'locale' => 'ar',
                ],
            ]);

            $categoryIds['main'] = $mainCategoryId;
            $mainLft = 2;
        } else {
            $mainCategoryId = DB::table('categories')
                ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', 'dental-products')
                ->value('categories.id');
            
            $categoryIds['main'] = $mainCategoryId;
            $mainCategory = DB::table('categories')->where('id', $mainCategoryId)->first();
            
            if (!$mainCategory) {
                throw new \Exception('Main dental category exists in translations but not found in categories table');
            }
            
            $mainLft = $mainCategory->_lft;
        }

        // Current left value for subcategories
        $currentLft = $mainLft;

        // Define dental subcategories
        $dentalSubcategories = [
            'composite' => [
                'en' => [
                    'name' => 'Composite',
                    'slug' => 'dental-composite',
                    'description' => 'Composite resins and restoration materials',
                    'meta_title' => 'Dental Composite - Restoration Materials',
                    'meta_description' => 'Professional dental composite resins for restorations',
                    'meta_keywords' => 'composite resin, dental restoration, filling materials',
                ],
                'fr' => [
                    'name' => 'Composite',
                    'slug' => 'composite-dentaire',
                    'description' => 'Résines composites et matériaux de restauration',
                    'meta_title' => 'Composite Dentaire - Matériaux de Restauration',
                    'meta_description' => 'Résines composites dentaires professionnelles pour restaurations',
                    'meta_keywords' => 'résine composite, restauration dentaire, matériaux de remplissage',
                ],
                'ar' => [
                    'name' => 'المركبات',
                    'slug' => 'dental-composite-ar',
                    'description' => 'الراتنجات المركبة ومواد الترميم',
                    'meta_title' => 'المركبات - مواد الترميم',
                    'meta_description' => 'راتنجات مركبة احترافية لترميم الأسنان',
                    'meta_keywords' => 'راتنج مركب، ترميم الأسنان، مواد الحشو',
                ],
            ],
            'anesthesia' => [
                'en' => [
                    'name' => 'Anesthesia',
                    'slug' => 'dental-anesthesia',
                    'description' => 'Local anesthetics and injectable solutions',
                    'meta_title' => 'Dental Anesthesia - Local Anesthetics',
                    'meta_description' => 'Professional dental anesthetics and injectable solutions',
                    'meta_keywords' => 'local anesthetic, lidocaine, dental anesthesia, injectable',
                ],
                'fr' => [
                    'name' => 'Anesthésie',
                    'slug' => 'anesthesie-dentaire',
                    'description' => 'Anesthésiques locaux et solutions injectables',
                    'meta_title' => 'Anesthésie Dentaire - Anesthésiques Locaux',
                    'meta_description' => 'Anesthésiques dentaires professionnels et solutions injectables',
                    'meta_keywords' => 'anesthésique local, lidocaïne, anesthésie dentaire',
                ],
                'ar' => [
                    'name' => 'التخدير',
                    'slug' => 'dental-anesthesia-ar',
                    'description' => 'التخدير الموضعي والحلول القابلة للحقن',
                    'meta_title' => 'تخدير الأسنان - التخدير الموضعي',
                    'meta_description' => 'تخديرات احترافية للأسنان والحلول القابلة للحقن',
                    'meta_keywords' => 'تخدير موضعي، ليدوكايين، تخدير الأسنان',
                ],
            ],
            'cements' => [
                'en' => [
                    'name' => 'Cements',
                    'slug' => 'dental-cements',
                    'description' => 'Dental cements and adhesive materials',
                    'meta_title' => 'Dental Cements - Adhesive Materials',
                    'meta_description' => 'Professional dental cements and adhesive bonding materials',
                    'meta_keywords' => 'dental cement, glass ionomer, adhesive, bonding cement',
                ],
                'fr' => [
                    'name' => 'Ciments',
                    'slug' => 'ciments-dentaires',
                    'description' => 'Ciments dentaires et matériaux adhésifs',
                    'meta_title' => 'Ciments Dentaires - Matériaux Adhésifs',
                    'meta_description' => 'Ciments dentaires professionnels et matériaux adhésifs',
                    'meta_keywords' => 'ciment dentaire, ionomer de verre, adhésif, ciment de liaison',
                ],
                'ar' => [
                    'name' => 'الأسمنت',
                    'slug' => 'dental-cements-ar',
                    'description' => 'الأسمنت ومواد اللصق',
                    'meta_title' => 'الأسمنت - مواد اللصق',
                    'meta_description' => 'أسمنت احترافي للأسنان ومواد لصق',
                    'meta_keywords' => 'أسمنت الأسنان، إيونومر زجاجي، لاصق',
                ],
            ],
            'bonding' => [
                'en' => [
                    'name' => 'Bonding',
                    'slug' => 'dental-bonding',
                    'description' => 'Bonding agents and adhesive systems',
                    'meta_title' => 'Dental Bonding - Adhesive Systems',
                    'meta_description' => 'Professional dental bonding agents and adhesive systems',
                    'meta_keywords' => 'dental bonding, adhesive agent, bonding system, resin bonding',
                ],
                'fr' => [
                    'name' => 'Liaison',
                    'slug' => 'liaison-dentaire',
                    'description' => 'Agents de liaison et systèmes adhésifs',
                    'meta_title' => 'Liaison Dentaire - Systèmes Adhésifs',
                    'meta_description' => 'Agents de liaison et systèmes adhésifs dentaires professionnels',
                    'meta_keywords' => 'liaison dentaire, agent adhésif, système de liaison',
                ],
                'ar' => [
                    'name' => 'الربط',
                    'slug' => 'dental-bonding-ar',
                    'description' => 'عوامل الربط والأنظمة اللاصقة',
                    'meta_title' => 'ربط الأسنان - الأنظمة اللاصقة',
                    'meta_description' => 'عوامل ربط احترافية للأسنان والأنظمة اللاصقة',
                    'meta_keywords' => 'ربط الأسنان، عامل لاصق، نظام ربط',
                ],
            ],
            'alginate' => [
                'en' => [
                    'name' => 'Alginate',
                    'slug' => 'dental-alginate',
                    'description' => 'Alginate impression materials',
                    'meta_title' => 'Dental Alginate - Impression Materials',
                    'meta_description' => 'Professional dental alginate impression materials',
                    'meta_keywords' => 'alginate, impression material, dental impression, impression powder',
                ],
                'fr' => [
                    'name' => 'Alginate',
                    'slug' => 'alginate-dentaire',
                    'description' => 'Matériaux d\'empreinte en alginate',
                    'meta_title' => 'Alginate Dentaire - Matériaux d\'Empreinte',
                    'meta_description' => 'Matériaux d\'empreinte en alginate dentaire professionnel',
                    'meta_keywords' => 'alginate, matériau d\'empreinte, empreinte dentaire',
                ],
                'ar' => [
                    'name' => 'الجينات',
                    'slug' => 'dental-alginate-ar',
                    'description' => 'مواد طبع الجينات',
                    'meta_title' => 'طبع الجينات - مواد الطبع',
                    'meta_description' => 'مواد طبع احترافية للأسنان',
                    'meta_keywords' => 'الجينات، مادة الطبع، طبع الأسنان',
                ],
            ],
            'amalgam' => [
                'en' => [
                    'name' => 'Amalgam',
                    'slug' => 'dental-amalgam',
                    'description' => 'Amalgam and mercury-containing restorative materials',
                    'meta_title' => 'Dental Amalgam - Restorative Materials',
                    'meta_description' => 'Professional dental amalgam and restorative materials',
                    'meta_keywords' => 'amalgam, dental restoration, filling material, mercury amalgam',
                ],
                'fr' => [
                    'name' => 'Amalgame',
                    'slug' => 'amalgame-dentaire',
                    'description' => 'Amalgame et matériaux de restauration contenant du mercure',
                    'meta_title' => 'Amalgame Dentaire - Matériaux de Restauration',
                    'meta_description' => 'Amalgame dentaire professionnel et matériaux de restauration',
                    'meta_keywords' => 'amalgame, restauration dentaire, matériau de remplissage',
                ],
                'ar' => [
                    'name' => 'الملغم',
                    'slug' => 'dental-amalgam-ar',
                    'description' => 'الملغم ومواد الترميم التي تحتوي على الزئبق',
                    'meta_title' => 'ملغم الأسنان - مواد الترميم',
                    'meta_description' => 'ملغم احترافي للأسنان ومواد ترميم',
                    'meta_keywords' => 'ملغم، ترميم الأسنان، مادة حشو',
                ],
            ],
            'silicone' => [
                'en' => [
                    'name' => 'Silicone',
                    'slug' => 'dental-silicone',
                    'description' => 'Silicone products and dental instruments',
                    'meta_title' => 'Dental Silicone - Products & Instruments',
                    'meta_description' => 'Professional dental silicone products and instruments',
                    'meta_keywords' => 'silicone, dental products, silicone tools, endodontic',
                ],
                'fr' => [
                    'name' => 'Silicone',
                    'slug' => 'silicone-dentaire',
                    'description' => 'Produits en silicone et instruments dentaires',
                    'meta_title' => 'Silicone Dentaire - Produits et Instruments',
                    'meta_description' => 'Produits et instruments dentaires en silicone professionnel',
                    'meta_keywords' => 'silicone, produits dentaires, outils en silicone',
                ],
                'ar' => [
                    'name' => 'السيليكون',
                    'slug' => 'dental-silicone-ar',
                    'description' => 'منتجات وأدوات السيليكون',
                    'meta_title' => 'سيليكون الأسنان - المنتجات والأدوات',
                    'meta_description' => 'منتجات وأدوات احترافية للأسنان من السيليكون',
                    'meta_keywords' => 'سيليكون، منتجات الأسنان، أدوات السيليكون',
                ],
            ],
            'gutta_cones' => [
                'en' => [
                    'name' => 'Gutta/Paper Cones',
                    'slug' => 'dental-gutta-cones',
                    'description' => 'Endodontic gutta cones and absorbent paper',
                    'meta_title' => 'Gutta Cones - Endodontic Materials',
                    'meta_description' => 'Professional gutta cones and absorbent paper for endodontics',
                    'meta_keywords' => 'gutta cone, endodontic, absorbent paper, root canal',
                ],
                'fr' => [
                    'name' => 'Cônes Gutta/Papier',
                    'slug' => 'cones-gutta-dentaires',
                    'description' => 'Cônes gutta et papier absorbant pour endodontie',
                    'meta_title' => 'Cônes Gutta - Matériaux Endodontiques',
                    'meta_description' => 'Cônes gutta professionnels et papier absorbant pour endodontie',
                    'meta_keywords' => 'cône gutta, endodontie, papier absorbant, canal radiculaire',
                ],
                'ar' => [
                    'name' => 'مخاريط جوتا / ورقية',
                    'slug' => 'dental-gutta-cones-ar',
                    'description' => 'مخاريط جوتا والورق الماص لمعالجة اللب',
                    'meta_title' => 'مخاريط جوتا - مواد علاج اللب',
                    'meta_description' => 'مخاريط جوتا احترافية والورق الماص لعلاج اللب',
                    'meta_keywords' => 'مخروط جوتا، علاج اللب، ورق ماص، قناة الجذر',
                ],
            ],
            'miscellaneous' => [
                'en' => [
                    'name' => 'Miscellaneous',
                    'slug' => 'dental-miscellaneous',
                    'description' => 'Additional dental supplies and accessories',
                    'meta_title' => 'Miscellaneous - Dental Supplies',
                    'meta_description' => 'Professional dental supplies and miscellaneous accessories',
                    'meta_keywords' => 'dental supplies, accessories, dental products, tools',
                ],
                'fr' => [
                    'name' => 'Divers',
                    'slug' => 'divers-dentaires',
                    'description' => 'Fournitures et accessoires dentaires supplémentaires',
                    'meta_title' => 'Divers - Fournitures Dentaires',
                    'meta_description' => 'Fournitures et accessoires dentaires professionnels supplémentaires',
                    'meta_keywords' => 'fournitures dentaires, accessoires, produits dentaires',
                ],
                'ar' => [
                    'name' => 'متنوع',
                    'slug' => 'dental-miscellaneous-ar',
                    'description' => 'مستلزمات إضافية وملحقات الأسنان',
                    'meta_title' => 'متنوع - مستلزمات الأسنان',
                    'meta_description' => 'مستلزمات واكسسوارات احترافية للأسنان',
                    'meta_keywords' => 'مستلزمات الأسنان، ملحقات، منتجات الأسنان',
                ],
            ],
        ];

        // Create subcategories
        $position = 1;
        $currentLft = $mainLft + 1; // Start inside the main category
        
        foreach ($dentalSubcategories as $key => $categoryData) {
            // Check if subcategory already exists
            $subcategoryExists = DB::table('categories')
                ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $categoryData['en']['slug'])
                ->exists();

            if (!$subcategoryExists) {
                $subcategoryLft = $currentLft;
                $subcategoryRgt = $currentLft + 1;
                
                $subcategoryId = DB::table('categories')->insertGetId([
                    'position' => $position,
                    'logo_path' => null,
                    'status' => 1,
                    'display_mode' => 'products_and_description',
                    'parent_id' => $categoryIds['main'],
                    'additional' => null,
                    'banner_path' => null,
                    '_lft' => $subcategoryLft,
                    '_rgt' => $subcategoryRgt,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Insert translations for subcategory
                DB::table('category_translations')->insert([
                    [
                        'name' => $categoryData['en']['name'],
                        'slug' => $categoryData['en']['slug'],
                        'description' => $categoryData['en']['description'],
                        'meta_title' => $categoryData['en']['meta_title'],
                        'meta_description' => $categoryData['en']['meta_description'],
                        'meta_keywords' => $categoryData['en']['meta_keywords'],
                        'category_id' => $subcategoryId,
                        'locale' => 'en',
                    ],
                    [
                        'name' => $categoryData['fr']['name'],
                        'slug' => $categoryData['fr']['slug'],
                        'description' => $categoryData['fr']['description'],
                        'meta_title' => $categoryData['fr']['meta_title'],
                        'meta_description' => $categoryData['fr']['meta_description'],
                        'meta_keywords' => $categoryData['fr']['meta_keywords'],
                        'category_id' => $subcategoryId,
                        'locale' => 'fr',
                    ],
                    [
                        'name' => $categoryData['ar']['name'],
                        'slug' => $categoryData['ar']['slug'],
                        'description' => $categoryData['ar']['description'],
                        'meta_title' => $categoryData['ar']['meta_title'],
                        'meta_description' => $categoryData['ar']['meta_description'],
                        'meta_keywords' => $categoryData['ar']['meta_keywords'],
                        'category_id' => $subcategoryId,
                        'locale' => 'ar',
                    ],
                ]);

                $categoryIds[$key] = $subcategoryId;
                $currentLft += 2; // Move to next subcategory position
            } else {
                $categoryIds[$key] = DB::table('categories')
                    ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.slug', $categoryData['en']['slug'])
                    ->value('categories.id');
            }

            $position++;
        }

        return $categoryIds;
    }

    /**
     * Seed the dental products.
     *
     * @return void
     */
    protected function seedDentalProducts()
    {
        $now = Carbon::now();
        $currentDate = $now->format('Y-m-d H:i:s');
        
        // Create categories and get their IDs
        $categoryIds = $this->createDentalCategory();
        
        $dentalProducts = $this->getDentalProductsData($currentDate);
        
        // Insert products
        foreach ($dentalProducts as $productData) {
            $productId = DB::table('products')->insertGetId([
                'sku' => $productData['sku'],
                'type' => $productData['type'],
                'attribute_family_id' => 1,
                'parent_id' => null,
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ]);

            // Insert product flat data for all locales
            $locales = [
                'en' => [
                    'name' => $productData['name'],
                    'short_description' => $productData['short_description'],
                    'description' => $productData['description'],
                    'url_key' => $productData['url_key'],
                    'meta_title' => $productData['meta_title'],
                    'meta_keywords' => $productData['meta_keywords'],
                    'meta_description' => $productData['meta_description'],
                ],
                'FR' => [
                    'name' => $productData['name_fr'] ?? $productData['name'],
                    'short_description' => $productData['short_description_fr'] ?? $productData['short_description'],
                    'description' => $productData['description_fr'] ?? $productData['description'],
                    'url_key' => $productData['url_key_fr'] ?? $productData['url_key'],
                    'meta_title' => $productData['meta_title_fr'] ?? $productData['meta_title'],
                    'meta_keywords' => $productData['meta_keywords_fr'] ?? $productData['meta_keywords'],
                    'meta_description' => $productData['meta_description_fr'] ?? $productData['meta_description'],
                ],
                'ar' => [
                    'name' => $productData['name_ar'] ?? $productData['name'],
                    'short_description' => $productData['short_description_ar'] ?? $productData['short_description'],
                    'description' => $productData['description_ar'] ?? $productData['description'],
                    'url_key' => $productData['url_key_ar'] ?? $productData['url_key'] . '-ar',
                    'meta_title' => $productData['meta_title_ar'] ?? $productData['meta_title'],
                    'meta_keywords' => $productData['meta_keywords_ar'] ?? $productData['meta_keywords'],
                    'meta_description' => $productData['meta_description_ar'] ?? $productData['meta_description'],
                ],
            ];

            foreach ($locales as $locale => $translations) {
                DB::table('product_flat')->insert([
                    'sku' => $productData['sku'],
                    'type' => $productData['type'],
                    'product_number' => $productData['product_number'] ?? null,
                    'name' => $translations['name'],
                    'short_description' => $translations['short_description'],
                    'description' => $translations['description'],
                    'url_key' => $translations['url_key'],
                    'new' => 1,
                    'featured' => 1,
                    'status' => 1,
                    'meta_title' => $translations['meta_title'],
                    'meta_keywords' => $translations['meta_keywords'],
                    'meta_description' => $translations['meta_description'],
                    'price' => $productData['price'],
                    'special_price' => $productData['special_price'] ?? null,
                    'special_price_from' => $productData['special_price_from'] ?? null,
                    'special_price_to' => $productData['special_price_to'] ?? null,
                    'weight' => $productData['weight'],
                    'created_at' => $currentDate,
                    'updated_at' => $currentDate,
                    'locale' => $locale,
                    'channel' => 'default',
                    'attribute_family_id' => 1,
                    'product_id' => $productId,
                    'parent_id' => null,
                    'visible_individually' => 1,
                ]);
            }

            // Insert product attribute values
            $this->insertProductAttributeValues($productId, $productData, $currentDate);

            // Insert product channel mapping
            DB::table('product_channels')->insert([
                'product_id' => $productId,
                'channel_id' => 1,
            ]);

            // Insert product category mappings
            $productCategories = $productData['categories'] ?? ['main'];
            
            foreach ($productCategories as $categoryKey) {
                if (isset($categoryIds[$categoryKey])) {
                    DB::table('product_categories')->insert([
                        'product_id' => $productId,
                        'category_id' => $categoryIds[$categoryKey],
                    ]);
                }
            }

            // Insert product images
            if (isset($productData['images'])) {
                $this->insertProductImages($productId, $productData['images']);
            }

            // Insert product inventory
            DB::table('product_inventories')->insert([
                'qty' => $productData['qty'] ?? 100,
                'product_id' => $productId,
                'inventory_source_id' => 1,
                'vendor_id' => 0,
            ]);
        }
    }

    /**
     * Insert product attribute values.
     *
     * @param int $productId
     * @param array $productData
     * @param string $currentDate
     * @return void
     */
    protected function insertProductAttributeValues($productId, $productData, $currentDate)
    {
        $attributes = DB::table('attributes')->get();
        $attributeValues = [];
        
        // Define locales to insert
        $locales = ['en', 'FR', 'ar'];
        
        foreach ($productData as $attributeCode => $value) {
            // Skip non-attribute fields and categories
            if (in_array($attributeCode, ['sku', 'type', 'images', 'categories', 'attribute_family_id', 'parent_id', 'created_at', 'updated_at', 'qty'])) {
                continue;
            }
            
            // Skip locale-specific suffixed fields (they're handled separately)
            if (preg_match('/_(?:fr|ar)$/', $attributeCode)) {
                continue;
            }

            $attribute = $attributes->where('code', $attributeCode)->first();
            
            if (!$attribute) {
                continue;
            }

            $attributeTypeValues = array_fill_keys(array_values($this->attributeTypeFields), null);
            
            // If attribute is locale-specific, insert for all locales
            if ($attribute->value_per_locale) {
                foreach ($locales as $locale) {
                    // Get locale-specific value or default to English value
                    $localeValue = $value;
                    if ($locale !== 'en') {
                        $localeSuffix = strtolower($locale);
                        $localeKey = $attributeCode . '_' . $localeSuffix;
                        if (isset($productData[$localeKey])) {
                            $localeValue = $productData[$localeKey];
                        }
                    }
                    
                    $uniqueId = implode('|', array_filter([
                        $attribute->value_per_channel ? 'default' : null,
                        $locale,
                        $productId,
                        $attribute->id,
                    ]));

                    $attributeValues[] = array_merge($attributeTypeValues, [
                        'attribute_id' => $attribute->id,
                        'product_id' => $productId,
                        $this->attributeTypeFields[$attribute->type] => $localeValue,
                        'channel' => $attribute->value_per_channel ? 'default' : null,
                        'locale' => $locale,
                        'unique_id' => $uniqueId,
                        'json_value' => null,
                    ]);
                }
            } else {
                // Non-locale-specific attributes (insert once)
                $uniqueId = implode('|', array_filter([
                    $attribute->value_per_channel ? 'default' : null,
                    null,
                    $productId,
                    $attribute->id,
                ]));

                $attributeValues[] = array_merge($attributeTypeValues, [
                    'attribute_id' => $attribute->id,
                    'product_id' => $productId,
                    $this->attributeTypeFields[$attribute->type] => $value,
                    'channel' => $attribute->value_per_channel ? 'default' : null,
                    'locale' => null,
                    'unique_id' => $uniqueId,
                    'json_value' => null,
                ]);
            }
        }
        
        if (!empty($attributeValues)) {
            DB::table('product_attribute_values')->insert($attributeValues);
        }
    }

    /**
     * Insert product images.
     *
     * @param int $productId
     * @param array $images
     * @return void
     */
    protected function insertProductImages($productId, $images)
    {
        foreach ($images as $index => $imageName) {
            $imagePath = $this->copyDentalImage("product/$productId", $imageName);
            
            if ($imagePath) {
                DB::table('product_images')->insert([
                    'type' => 'image',
                    'path' => $imagePath,
                    'product_id' => $productId,
                    'position' => $index + 1,
                ]);
            }
        }
    }

    /**
     * Copy dental image to storage and return path.
     *
     * @param string $targetPath
     * @param string $fileName
     * @return string|null
     */
    protected function copyDentalImage($targetPath, $fileName)
    {
        $sourcePath = base_path(self::DENTAL_IMAGES_PATH . $fileName);
        
        // If specific image doesn't exist, create a placeholder
        if (!file_exists($sourcePath)) {
            // Create a simple placeholder image or use a default
            $this->createPlaceholderImage($sourcePath, $fileName);
        }
        
        if (file_exists($sourcePath)) {
            return Storage::putFile($targetPath, new File($sourcePath));
        }
        
        return null;
    }

    /**
     * Create placeholder image for missing dental product images.
     *
     * @param string $path
     * @param string $fileName
     * @return void
     */
    protected function createPlaceholderImage($path, $fileName)
    {
        $directory = dirname($path);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create a simple colored placeholder image
        $image = imagecreate(400, 400);
        $backgroundColor = imagecolorallocate($image, 240, 240, 240);
        $textColor = imagecolorallocate($image, 100, 100, 100);
        
        // Add text to the image
        $text = pathinfo($fileName, PATHINFO_FILENAME);
        $text = str_replace(['-', '_'], ' ', $text);
        $text = ucwords($text);
        
        imagestring($image, 5, 50, 190, $text, $textColor);
        
        // Save as PNG
        imagepng($image, $path);
        imagedestroy($image);
    }

    /**
     * Get dental products data.
     *
     * @param string $currentDate
     * @return array
     */
    protected function getDentalProductsData($currentDate)
    {
        return [
            // Composite Products (17 items)
            ['sku' => 'COMP-001', 'type' => 'simple', 'name' => '3M Z250', 'short_description' => 'Professional composite resin', 'description' => 'High-quality composite resin for dental restorations', 'url_key' => '3m-z250', 'meta_title' => '3M Z250 Composite', 'meta_keywords' => 'composite, resin, dental', 'meta_description' => 'Professional composite resin', 'price' => 3650.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-002', 'type' => 'simple', 'name' => 'Charisma Diamond KULZER', 'short_description' => 'Premium composite resin', 'description' => 'Charisma Diamond composite with enhanced durability', 'url_key' => 'charisma-diamond-kulzer', 'meta_title' => 'Charisma Diamond KULZER', 'meta_keywords' => 'composite, KULZER', 'meta_description' => 'Charisma Diamond composite resin', 'price' => 5200.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-003', 'type' => 'simple', 'name' => 'Charisma Smart KULZER', 'short_description' => 'Smart composite system', 'description' => 'Charisma Smart composite for modern restorations', 'url_key' => 'charisma-smart-kulzer', 'meta_title' => 'Charisma Smart KULZER', 'meta_keywords' => 'composite, smart', 'meta_description' => 'Charisma Smart composite resin', 'price' => 2200.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-004', 'type' => 'simple', 'name' => 'Coffret Charisma Smart', 'short_description' => 'Complete Charisma kit', 'description' => 'Full Charisma Smart composite restoration kit', 'url_key' => 'coffret-charisma-smart', 'meta_title' => 'Coffret Charisma Smart', 'meta_keywords' => 'kit, composite', 'meta_description' => 'Complete Charisma Smart kit', 'price' => 17500.00, 'weight' => 2.0, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-005', 'type' => 'simple', 'name' => 'Coffret Dix Universal', 'short_description' => 'Universal composite kit', 'description' => 'Dix Universal composite restoration system', 'url_key' => 'coffret-dix-universal', 'meta_title' => 'Coffret Dix Universal', 'meta_keywords' => 'kit, universal', 'meta_description' => 'Dix Universal composite kit', 'price' => 9500.00, 'weight' => 2.0, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-006', 'type' => 'simple', 'name' => 'Coffret Ivoclar', 'short_description' => 'Ivoclar composite kit', 'description' => 'Professional Ivoclar composite restoration kit', 'url_key' => 'coffret-ivoclar', 'meta_title' => 'Coffret Ivoclar', 'meta_keywords' => 'kit, Ivoclar', 'meta_description' => 'Ivoclar composite kit', 'price' => 21000.00, 'weight' => 2.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-007', 'type' => 'simple', 'name' => 'Composite Diamond A3', 'short_description' => 'Diamond composite A3 shade', 'description' => 'Diamond composite in A3 shade for natural teeth', 'url_key' => 'composite-diamond-a3', 'meta_title' => 'Composite Diamond A3', 'meta_keywords' => 'composite, A3', 'meta_description' => 'Diamond composite A3 shade', 'price' => 4900.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-008', 'type' => 'simple', 'name' => 'Dynamic Plus', 'short_description' => 'Dynamic composite system', 'description' => 'Dynamic Plus composite for efficient restorations', 'url_key' => 'dynamic-plus', 'meta_title' => 'Dynamic Plus Composite', 'meta_keywords' => 'composite, dynamic', 'meta_description' => 'Dynamic Plus composite', 'price' => 2600.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-009', 'type' => 'simple', 'name' => 'Flow Denu', 'short_description' => 'Flowable composite', 'description' => 'Flow Denu flowable composite for precise application', 'url_key' => 'flow-denu', 'meta_title' => 'Flow Denu', 'meta_keywords' => 'composite, flow', 'meta_description' => 'Flow Denu flowable composite', 'price' => 1100.00, 'weight' => 0.3, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-010', 'type' => 'simple', 'name' => 'Flow i DENTAL kit', 'short_description' => 'Flow i complete kit', 'description' => 'Complete Flow i DENTAL composite kit', 'url_key' => 'flow-i-dental-kit', 'meta_title' => 'Flow i DENTAL Kit', 'meta_keywords' => 'kit, flow', 'meta_description' => 'Flow i DENTAL complete kit', 'price' => 6200.00, 'weight' => 1.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-011', 'type' => 'simple', 'name' => 'Flow RUBY', 'short_description' => 'Ruby flow composite', 'description' => 'Flow RUBY flowable composite resin', 'url_key' => 'flow-ruby', 'meta_title' => 'Flow RUBY', 'meta_keywords' => 'composite, ruby', 'meta_description' => 'Flow RUBY composite', 'price' => 900.00, 'weight' => 0.3, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-012', 'type' => 'simple', 'name' => 'MEGA FIL', 'short_description' => 'Mega bulk fill composite', 'description' => 'MEGA FIL bulk fill composite for large restorations', 'url_key' => 'mega-fil', 'meta_title' => 'MEGA FIL', 'meta_keywords' => 'composite, bulk fill', 'meta_description' => 'MEGA FIL bulk fill composite', 'price' => 2500.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-013', 'type' => 'simple', 'name' => 'Tetric N Ceram IVOCLAR', 'short_description' => 'Tetric N Ceram composite', 'description' => 'Professional Tetric N Ceram composite resin', 'url_key' => 'tetric-n-ceram-ivoclar', 'meta_title' => 'Tetric N Ceram IVOCLAR', 'meta_keywords' => 'composite, Ivoclar', 'meta_description' => 'Tetric N Ceram composite', 'price' => 2950.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-014', 'type' => 'simple', 'name' => 'Tetric N Ceram IVOCLAR bulk', 'short_description' => 'Tetric bulk fill version', 'description' => 'Tetric N Ceram bulk fill composite', 'url_key' => 'tetric-n-ceram-bulk', 'meta_title' => 'Tetric N Ceram Bulk', 'meta_keywords' => 'composite, bulk fill', 'meta_description' => 'Tetric N Ceram bulk fill', 'price' => 3200.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-015', 'type' => 'simple', 'name' => 'Zenchroma PDG universal', 'short_description' => 'Zenchroma universal composite', 'description' => 'Zenchroma PDG universal composite resin', 'url_key' => 'zenchroma-pdg-universal', 'meta_title' => 'Zenchroma PDG Universal', 'meta_keywords' => 'composite, universal', 'meta_description' => 'Zenchroma PDG universal composite', 'price' => 5300.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-016', 'type' => 'simple', 'name' => 'Zirconfill', 'short_description' => 'Zirconfill composite', 'description' => 'Zirconfill composite for aesthetic restorations', 'url_key' => 'zirconfill', 'meta_title' => 'Zirconfill', 'meta_keywords' => 'composite, zircon', 'meta_description' => 'Zirconfill composite', 'price' => 2900.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],
            ['sku' => 'COMP-017', 'type' => 'simple', 'name' => 'Zomaxfill', 'short_description' => 'Zomaxfill composite', 'description' => 'Zomaxfill composite resin for restorations', 'url_key' => 'zomaxfill', 'meta_title' => 'Zomaxfill', 'meta_keywords' => 'composite', 'meta_description' => 'Zomaxfill composite', 'price' => 1500.00, 'weight' => 0.5, 'categories' => ['main', 'composite']],

            // Anesthesia Products (4 items)
            ['sku' => 'ANES-001', 'type' => 'simple', 'name' => 'LIDOCAINE spray', 'short_description' => 'Lidocaine topical spray', 'description' => 'Professional lidocaine topical anesthetic spray', 'url_key' => 'lidocaine-spray', 'meta_title' => 'LIDOCAINE Spray', 'meta_keywords' => 'anesthetic, lidocaine, spray', 'meta_description' => 'Lidocaine topical spray', 'price' => 2200.00, 'weight' => 0.2, 'categories' => ['main', 'anesthesia']],
            ['sku' => 'ANES-002', 'type' => 'simple', 'name' => 'Medicaine 2%', 'short_description' => 'Medicaine 2% injectable', 'description' => 'Medicaine local anesthetic 2% solution', 'url_key' => 'medicaine-2-percent', 'meta_title' => 'Medicaine 2%', 'meta_keywords' => 'anesthetic, local', 'meta_description' => 'Medicaine 2% anesthetic', 'price' => 3000.00, 'weight' => 0.3, 'categories' => ['main', 'anesthesia']],
            ['sku' => 'ANES-003', 'type' => 'simple', 'name' => 'Medicaine 3%', 'short_description' => 'Medicaine 3% injectable', 'description' => 'Medicaine local anesthetic 3% solution', 'url_key' => 'medicaine-3-percent', 'meta_title' => 'Medicaine 3%', 'meta_keywords' => 'anesthetic, local', 'meta_description' => 'Medicaine 3% anesthetic', 'price' => 3200.00, 'weight' => 0.3, 'categories' => ['main', 'anesthesia']],
            ['sku' => 'ANES-004', 'type' => 'simple', 'name' => 'Septodont', 'short_description' => 'Septodont anesthetic', 'description' => 'Professional Septodont local anesthetic', 'url_key' => 'septodont', 'meta_title' => 'Septodont', 'meta_keywords' => 'anesthetic, Septodont', 'meta_description' => 'Septodont anesthetic', 'price' => 3700.00, 'weight' => 0.3, 'categories' => ['main', 'anesthesia']],

            // Cements Products (4 items)
            ['sku' => 'CIME-001', 'type' => 'simple', 'name' => 'Extracem PDG', 'short_description' => 'Extracem dental cement', 'description' => 'Professional Extracem PDG dental cement', 'url_key' => 'extracem-pdg', 'meta_title' => 'Extracem PDG', 'meta_keywords' => 'cement, dental', 'meta_description' => 'Extracem PDG dental cement', 'price' => 7800.00, 'weight' => 0.8, 'categories' => ['main', 'cements']],
            ['sku' => 'CIME-002', 'type' => 'simple', 'name' => 'Fuji 1 GC', 'short_description' => 'Fuji 1 glass ionomer', 'description' => 'GC Fuji 1 glass ionomer cement', 'url_key' => 'fuji-1-gc', 'meta_title' => 'Fuji 1 GC', 'meta_keywords' => 'cement, glass ionomer', 'meta_description' => 'Fuji 1 GC glass ionomer', 'price' => 175000.00, 'weight' => 1.0, 'categories' => ['main', 'cements']],
            ['sku' => 'CIME-003', 'type' => 'simple', 'name' => 'Fuji 1 plus GC', 'short_description' => 'Fuji 1 plus glass ionomer', 'description' => 'GC Fuji 1 plus advanced glass ionomer cement', 'url_key' => 'fuji-1-plus-gc', 'meta_title' => 'Fuji 1 Plus GC', 'meta_keywords' => 'cement, glass ionomer', 'meta_description' => 'Fuji 1 Plus GC glass ionomer', 'price' => 205000.00, 'weight' => 1.0, 'categories' => ['main', 'cements']],
            ['sku' => 'CIME-004', 'type' => 'simple', 'name' => 'Ciment verre ionomer I-Fill', 'short_description' => 'I-Fill glass ionomer cement', 'description' => 'I-Fill glass ionomer dental cement', 'url_key' => 'ciment-verre-ionomer-i-fill', 'meta_title' => 'I-Fill Glass Ionomer', 'meta_keywords' => 'cement, glass ionomer', 'meta_description' => 'I-Fill glass ionomer cement', 'price' => 5250.00, 'weight' => 0.6, 'categories' => ['main', 'cements']],

            // Bonding Products (2 items)
            ['sku' => 'BOND-001', 'type' => 'simple', 'name' => 'Bonding megafil', 'short_description' => 'Megafil bonding agent', 'description' => 'Professional megafil bonding adhesive system', 'url_key' => 'bonding-megafil', 'meta_title' => 'Bonding Megafil', 'meta_keywords' => 'bonding, adhesive', 'meta_description' => 'Bonding megafil adhesive', 'price' => 2850.00, 'weight' => 0.4, 'categories' => ['main', 'bonding']],
            ['sku' => 'BOND-002', 'type' => 'simple', 'name' => 'C bond bonding ceram', 'short_description' => 'C bond ceramic bonding', 'description' => 'C bond ceramic adhesive bonding system', 'url_key' => 'c-bond-bonding-ceram', 'meta_title' => 'C Bond Bonding Ceram', 'meta_keywords' => 'bonding, ceramic', 'meta_description' => 'C bond bonding ceramic', 'price' => 1850.00, 'weight' => 0.4, 'categories' => ['main', 'bonding']],

            // Alginate Products (2 items)
            ['sku' => 'ALGI-001', 'type' => 'simple', 'name' => 'Alginat millenium LASCOD', 'short_description' => 'Millennium alginate powder', 'description' => 'LASCOD Millennium alginate impression powder', 'url_key' => 'alginat-millenium-lascod', 'meta_title' => 'Alginat Millenium LASCOD', 'meta_keywords' => 'alginate, impression', 'meta_description' => 'Alginat Millenium LASCOD', 'price' => 1250.00, 'weight' => 0.5, 'categories' => ['main', 'alginate']],
            ['sku' => 'ALGI-002', 'type' => 'simple', 'name' => 'Alginat tropical LASCOD', 'short_description' => 'Tropical alginate powder', 'description' => 'LASCOD Tropical alginate impression powder', 'url_key' => 'alginat-tropical-lascod', 'meta_title' => 'Alginat Tropical LASCOD', 'meta_keywords' => 'alginate, impression', 'meta_description' => 'Alginat Tropical LASCOD', 'price' => 1000.00, 'weight' => 0.5, 'categories' => ['main', 'alginate']],

            // Amalgam Products (5 items)
            ['sku' => 'AMAL-001', 'type' => 'simple', 'name' => 'Double dose ARCCO', 'short_description' => 'ARCCO amalgam double dose', 'description' => 'ARCCO dental amalgam double dose capsules', 'url_key' => 'double-dose-arcco', 'meta_title' => 'Double Dose ARCCO', 'meta_keywords' => 'amalgam, restorative', 'meta_description' => 'ARCCO amalgam double dose', 'price' => 10500.00, 'weight' => 0.8, 'categories' => ['main', 'amalgam']],
            ['sku' => 'AMAL-002', 'type' => 'simple', 'name' => 'Simple dose ARCCO', 'short_description' => 'ARCCO amalgam single dose', 'description' => 'ARCCO dental amalgam single dose capsules', 'url_key' => 'simple-dose-arcco', 'meta_title' => 'Simple Dose ARCCO', 'meta_keywords' => 'amalgam, restorative', 'meta_description' => 'ARCCO amalgam single dose', 'price' => 7800.00, 'weight' => 0.6, 'categories' => ['main', 'amalgam']],
            ['sku' => 'AMAL-003', 'type' => 'simple', 'name' => 'Double dose RUBY CAP', 'short_description' => 'RUBY CAP amalgam double dose', 'description' => 'RUBY CAP dental amalgam double dose capsules', 'url_key' => 'double-dose-ruby-cap', 'meta_title' => 'Double Dose RUBY CAP', 'meta_keywords' => 'amalgam, restorative', 'meta_description' => 'RUBY CAP amalgam double dose', 'price' => 9500.00, 'weight' => 0.8, 'categories' => ['main', 'amalgam']],
            ['sku' => 'AMAL-004', 'type' => 'simple', 'name' => 'Simple dose RUBY CAP', 'short_description' => 'RUBY CAP amalgam single dose', 'description' => 'RUBY CAP dental amalgam single dose capsules', 'url_key' => 'simple-dose-ruby-cap', 'meta_title' => 'Simple Dose RUBY CAP', 'meta_keywords' => 'amalgam, restorative', 'meta_description' => 'RUBY CAP amalgam single dose', 'price' => 7400.00, 'weight' => 0.6, 'categories' => ['main', 'amalgam']],
            ['sku' => 'AMAL-005', 'type' => 'simple', 'name' => 'Double dose ARDENT', 'short_description' => 'ARDENT amalgam double dose', 'description' => 'ARDENT dental amalgam double dose capsules', 'url_key' => 'double-dose-ardent', 'meta_title' => 'Double Dose ARDENT', 'meta_keywords' => 'amalgam, restorative', 'meta_description' => 'ARDENT amalgam double dose', 'price' => 8500.00, 'weight' => 0.8, 'categories' => ['main', 'amalgam']],

            // Silicone Products (7 items)
            ['sku' => 'SILI-001', 'type' => 'simple', 'name' => 'Boite fraise pour désinfection', 'short_description' => 'Burr sterilization box', 'description' => 'Silicone burr sterilization and disinfection box', 'url_key' => 'boite-fraise-desinfection', 'meta_title' => 'Boite Fraise Désinfection', 'meta_keywords' => 'silicone, sterilization', 'meta_description' => 'Burr sterilization box', 'price' => 1500.00, 'weight' => 0.3, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-002', 'type' => 'simple', 'name' => 'ENDOBOX', 'short_description' => 'Endodontic tool box', 'description' => 'ENDOBOX silicone endodontic tool container', 'url_key' => 'endobox', 'meta_title' => 'ENDOBOX', 'meta_keywords' => 'silicone, endodontic', 'meta_description' => 'ENDOBOX endodontic tool box', 'price' => 3500.00, 'weight' => 0.5, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-003', 'type' => 'simple', 'name' => 'ENDOMATE', 'short_description' => 'Professional endodontic system', 'description' => 'ENDOMATE professional endodontic system', 'url_key' => 'endomate', 'meta_title' => 'ENDOMATE', 'meta_keywords' => 'silicone, endodontic', 'meta_description' => 'ENDOMATE endodontic system', 'price' => 31500.00, 'weight' => 3.0, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-004', 'type' => 'simple', 'name' => 'Fraisier bleu', 'short_description' => 'Blue bur holder', 'description' => 'Blue silicone bur holder and storage', 'url_key' => 'fraisier-bleu', 'meta_title' => 'Fraisier Bleu', 'meta_keywords' => 'silicone, bur holder', 'meta_description' => 'Blue bur holder silicone', 'price' => 1250.00, 'weight' => 0.3, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-005', 'type' => 'simple', 'name' => 'Fraisier PM', 'short_description' => 'PM bur holder', 'description' => 'PM silicone bur holder and organizer', 'url_key' => 'fraisier-pm', 'meta_title' => 'Fraisier PM', 'meta_keywords' => 'silicone, bur holder', 'meta_description' => 'PM bur holder silicone', 'price' => 900.00, 'weight' => 0.3, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-006', 'type' => 'simple', 'name' => 'Gutta cutter', 'short_description' => 'Gutta point cutter', 'description' => 'Silicone gutta point cutter tool', 'url_key' => 'gutta-cutter', 'meta_title' => 'Gutta Cutter', 'meta_keywords' => 'silicone, endodontic tool', 'meta_description' => 'Gutta point cutter', 'price' => 5500.00, 'weight' => 0.5, 'categories' => ['main', 'silicone']],
            ['sku' => 'SILI-007', 'type' => 'simple', 'name' => 'Housse fauteuil', 'short_description' => 'Chair cover sleeve', 'description' => 'Silicone dental chair cover sleeve', 'url_key' => 'housse-fauteuil', 'meta_title' => 'Housse Fauteuil', 'meta_keywords' => 'silicone, chair cover', 'meta_description' => 'Dental chair silicone cover', 'price' => 4800.00, 'weight' => 0.4, 'categories' => ['main', 'silicone']],

            // Gutta/Paper Cones Products (8 items)
            ['sku' => 'GUPA-001', 'type' => 'simple', 'name' => 'Gutta 04/20 SANI', 'short_description' => 'Gutta cone 04/20', 'description' => 'SANI gutta cone size 04/20 for endodontics', 'url_key' => 'gutta-04-20-sani', 'meta_title' => 'Gutta 04/20 SANI', 'meta_keywords' => 'gutta, endodontic', 'meta_description' => 'Gutta cone 04/20 SANI', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-002', 'type' => 'simple', 'name' => 'Gutta 04/25 SANI', 'short_description' => 'Gutta cone 04/25', 'description' => 'SANI gutta cone size 04/25 for endodontics', 'url_key' => 'gutta-04-25-sani', 'meta_title' => 'Gutta 04/25 SANI', 'meta_keywords' => 'gutta, endodontic', 'meta_description' => 'Gutta cone 04/25 SANI', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-003', 'type' => 'simple', 'name' => 'Gutta 06/20 SANI', 'short_description' => 'Gutta cone 06/20', 'description' => 'SANI gutta cone size 06/20 for endodontics', 'url_key' => 'gutta-06-20-sani', 'meta_title' => 'Gutta 06/20 SANI', 'meta_keywords' => 'gutta, endodontic', 'meta_description' => 'Gutta cone 06/20 SANI', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-004', 'type' => 'simple', 'name' => 'Gutta 06/25 SANI', 'short_description' => 'Gutta cone 06/25', 'description' => 'SANI gutta cone size 06/25 for endodontics', 'url_key' => 'gutta-06-25-sani', 'meta_title' => 'Gutta 06/25 SANI', 'meta_keywords' => 'gutta, endodontic', 'meta_description' => 'Gutta cone 06/25 SANI', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-005', 'type' => 'simple', 'name' => 'Papier absorbent 04/20 SANI', 'short_description' => 'Absorbent paper 04/20', 'description' => 'SANI absorbent paper points size 04/20', 'url_key' => 'papier-absorbent-04-20-sani', 'meta_title' => 'Papier Absorbent 04/20', 'meta_keywords' => 'paper, absorbent, endodontic', 'meta_description' => 'Absorbent paper points 04/20', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-006', 'type' => 'simple', 'name' => 'Papier absorbent 04/25 SANI', 'short_description' => 'Absorbent paper 04/25', 'description' => 'SANI absorbent paper points size 04/25', 'url_key' => 'papier-absorbent-04-25-sani', 'meta_title' => 'Papier Absorbent 04/25', 'meta_keywords' => 'paper, absorbent, endodontic', 'meta_description' => 'Absorbent paper points 04/25', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-007', 'type' => 'simple', 'name' => 'Papier absorbent 06/20 SANI', 'short_description' => 'Absorbent paper 06/20', 'description' => 'SANI absorbent paper points size 06/20', 'url_key' => 'papier-absorbent-06-20-sani', 'meta_title' => 'Papier Absorbent 06/20', 'meta_keywords' => 'paper, absorbent, endodontic', 'meta_description' => 'Absorbent paper points 06/20', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],
            ['sku' => 'GUPA-008', 'type' => 'simple', 'name' => 'Papier absorbent 06/25 SANI', 'short_description' => 'Absorbent paper 06/25', 'description' => 'SANI absorbent paper points size 06/25', 'url_key' => 'papier-absorbent-06-25-sani', 'meta_title' => 'Papier Absorbent 06/25', 'meta_keywords' => 'paper, absorbent, endodontic', 'meta_description' => 'Absorbent paper points 06/25', 'price' => 850.00, 'weight' => 0.2, 'categories' => ['main', 'gutta_cones']],

            // Miscellaneous Products (5 items)
            ['sku' => 'MISC-001', 'type' => 'simple', 'name' => 'Endo plus PDG', 'short_description' => 'Endodontic system PDG', 'description' => 'Endo plus PDG endodontic treatment system', 'url_key' => 'endo-plus-pdg', 'meta_title' => 'Endo Plus PDG', 'meta_keywords' => 'endodontic, system', 'meta_description' => 'Endo plus PDG system', 'price' => 5800.00, 'weight' => 0.8, 'categories' => ['main', 'miscellaneous']],
            ['sku' => 'MISC-002', 'type' => 'simple', 'name' => 'Ligature ODF en couleur', 'short_description' => 'Colored ODF ligature', 'description' => 'Colored ODF orthodontic ligature ties', 'url_key' => 'ligature-odf-couleur', 'meta_title' => 'Ligature ODF Couleur', 'meta_keywords' => 'ligature, orthodontic', 'meta_description' => 'Colored ODF ligature ties', 'price' => 900.00, 'weight' => 0.1, 'categories' => ['main', 'miscellaneous']],
            ['sku' => 'MISC-003', 'type' => 'simple', 'name' => 'Lubrifiant', 'short_description' => 'Dental lubricant', 'description' => 'Professional dental lubricant for instruments', 'url_key' => 'lubrifiant', 'meta_title' => 'Lubrifiant', 'meta_keywords' => 'lubricant, dental', 'meta_description' => 'Dental lubricant', 'price' => 2200.00, 'weight' => 0.3, 'categories' => ['main', 'miscellaneous']],
            ['sku' => 'MISC-004', 'type' => 'simple', 'name' => 'Porte empreinte COTISEN', 'short_description' => 'Impression tray COTISEN', 'description' => 'COTISEN dental impression tray', 'url_key' => 'porte-empreinte-cotisen', 'meta_title' => 'Porte Empreinte COTISEN', 'meta_keywords' => 'impression tray, dental', 'meta_description' => 'COTISEN impression tray', 'price' => 750.00, 'weight' => 0.2, 'categories' => ['main', 'miscellaneous']],
            ['sku' => 'MISC-005', 'type' => 'simple', 'name' => 'Tube molaire 10 bouches', 'short_description' => 'Molar tubes 10 pcs', 'description' => 'Molar tube pack of 10 for orthodontics', 'url_key' => 'tube-molaire-10-bouches', 'meta_title' => 'Tube Molaire 10', 'meta_keywords' => 'molar tube, orthodontic', 'meta_description' => 'Molar tubes pack of 10', 'price' => 2800.00, 'weight' => 0.4, 'categories' => ['main', 'miscellaneous']],
        ];
    }
}
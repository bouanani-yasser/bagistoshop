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

        // Get the next available _lft value from root category
        $rootCategory = DB::table('categories')->where('id', 1)->first();
        $nextLft = $rootCategory->_rgt;

        // Create main dental category if it doesn't exist
        $mainCategoryExists = DB::table('categories')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', 'dental-products')
            ->exists();
        
        if (!$mainCategoryExists) {
            // Calculate nested set values for main category and its 6 subcategories
            //  Main: lft=nextLft, rgt=nextLft+13 (6 subcategories * 2 + 1)
            $mainLft = $nextLft;
            $mainRgt = $nextLft + 13;

            $mainCategoryId = DB::table('categories')->insertGetId([
                'position' => 1,
                'logo_path' => null,
                'status' => 1,
                'display_mode' => 'products_and_description',
                'parent_id' => 1,
                'additional' => null,
                'banner_path' => null,
                '_lft' => $mainLft,
                '_rgt' => $mainRgt,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Update root category's _rgt
            DB::table('categories')->where('id', 1)->update(['_rgt' => $mainRgt + 1]);

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
        } else {
            $categoryIds['main'] = DB::table('categories')
                ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', 'dental-products')
                ->value('categories.id');
                
            $mainCategory = DB::table('categories')->where('id', $categoryIds['main'])->first();
            $mainLft = $mainCategory->_lft;
        }

        // Define dental subcategories
        $dentalSubcategories = [
            'instruments' => [
                'en' => [
                    'name' => 'Instruments',
                    'slug' => 'dental-instruments',
                    'description' => 'Professional dental instruments and hand tools',
                    'meta_title' => 'Dental Instruments - Professional Tools',
                    'meta_description' => 'High-quality dental instruments for professional use',
                    'meta_keywords' => 'dental instruments, hand tools, probes, scalers',
                ],
                'fr' => [
                    'name' => 'Instruments',
                    'slug' => 'instruments-dentaires',
                    'description' => 'Instruments dentaires professionnels et outils manuels',
                    'meta_title' => 'Instruments Dentaires - Outils Professionnels',
                    'meta_description' => 'Instruments dentaires de haute qualité pour usage professionnel',
                    'meta_keywords' => 'instruments dentaires, outils manuels, sondes, détartreurs',
                ],
                'ar' => [
                    'name' => 'أدوات',
                    'slug' => 'dental-instruments-ar',
                    'description' => 'أدوات الأسنان الاحترافية والأدوات اليدوية',
                    'meta_title' => 'أدوات طب الأسنان - أدوات احترافية',
                    'meta_description' => 'أدوات طب الأسنان عالية الجودة للاستخدام المهني',
                    'meta_keywords' => 'أدوات الأسنان، أدوات يدوية، مسابر، كاشطات',
                ],
            ],
            'consumables' => [
                'en' => [
                    'name' => 'Consumables',
                    'slug' => 'dental-consumables',
                    'description' => 'Dental consumables and disposable supplies',
                    'meta_title' => 'Dental Consumables - Disposable Supplies',
                    'meta_description' => 'Quality dental consumables and disposable products',
                    'meta_keywords' => 'dental consumables, disposables, supplies, materials',
                ],
                'fr' => [
                    'name' => 'Consommables',
                    'slug' => 'consommables-dentaires',
                    'description' => 'Consommables dentaires et fournitures jetables',
                    'meta_title' => 'Consommables Dentaires - Fournitures Jetables',
                    'meta_description' => 'Consommables dentaires de qualité et produits jetables',
                    'meta_keywords' => 'consommables dentaires, jetables, fournitures, matériaux',
                ],
                'ar' => [
                    'name' => 'المستهلكات',
                    'slug' => 'dental-consumables-ar',
                    'description' => 'مستهلكات طب الأسنان والمستلزمات التي تستخدم لمرة واحدة',
                    'meta_title' => 'مستهلكات طب الأسنان - مستلزمات يمكن التخلص منها',
                    'meta_description' => 'مستهلكات طب الأسنان عالية الجودة والمنتجات التي تستخدم لمرة واحدة',
                    'meta_keywords' => 'مستهلكات الأسنان، مستلزمات، مواد',
                ],
            ],
            'imaging' => [
                'en' => [
                    'name' => 'Imaging',
                    'slug' => 'dental-imaging',
                    'description' => 'Dental imaging equipment and radiography systems',
                    'meta_title' => 'Dental Imaging - X-Ray Equipment',
                    'meta_description' => 'Professional dental imaging and radiography equipment',
                    'meta_keywords' => 'dental imaging, x-ray, radiography, digital imaging',
                ],
                'fr' => [
                    'name' => 'Imagerie',
                    'slug' => 'imagerie-dentaire',
                    'description' => 'Équipements d\'imagerie dentaire et systèmes de radiographie',
                    'meta_title' => 'Imagerie Dentaire - Équipement Radiographique',
                    'meta_description' => 'Équipements professionnels d\'imagerie et de radiographie dentaire',
                    'meta_keywords' => 'imagerie dentaire, rayons x, radiographie, imagerie numérique',
                ],
                'ar' => [
                    'name' => 'التصوير',
                    'slug' => 'dental-imaging-ar',
                    'description' => 'معدات التصوير وأنظمة الأشعة السينية لطب الأسنان',
                    'meta_title' => 'تصوير الأسنان - معدات الأشعة السينية',
                    'meta_description' => 'معدات التصوير والأشعة الاحترافية لطب الأسنان',
                    'meta_keywords' => 'تصوير الأسنان، أشعة سينية، تصوير رقمي',
                ],
            ],
            'hygiene' => [
                'en' => [
                    'name' => 'Hygiene',
                    'slug' => 'dental-hygiene',
                    'description' => 'Dental hygiene and sterilization equipment',
                    'meta_title' => 'Dental Hygiene - Sterilization Equipment',
                    'meta_description' => 'Professional dental hygiene and sterilization solutions',
                    'meta_keywords' => 'dental hygiene, sterilization, autoclave, disinfection',
                ],
                'fr' => [
                    'name' => 'Hygiène',
                    'slug' => 'hygiene-dentaire',
                    'description' => 'Équipements d\'hygiène et de stérilisation dentaire',
                    'meta_title' => 'Hygiène Dentaire - Équipement de Stérilisation',
                    'meta_description' => 'Solutions professionnelles d\'hygiène et de stérilisation dentaire',
                    'meta_keywords' => 'hygiène dentaire, stérilisation, autoclave, désinfection',
                ],
                'ar' => [
                    'name' => 'النظافة',
                    'slug' => 'dental-hygiene-ar',
                    'description' => 'معدات النظافة والتعقيم لطب الأسنان',
                    'meta_title' => 'نظافة الأسنان - معدات التعقيم',
                    'meta_description' => 'حلول احترافية للنظافة والتعقيم في طب الأسنان',
                    'meta_keywords' => 'نظافة الأسنان، تعقيم، أوتوكلاف، تطهير',
                ],
            ],
            'prosthetics' => [
                'en' => [
                    'name' => 'Prosthetics',
                    'slug' => 'dental-prosthetics',
                    'description' => 'Dental prosthetics and restoration materials',
                    'meta_title' => 'Dental Prosthetics - Restoration Materials',
                    'meta_description' => 'Professional dental prosthetics and restoration solutions',
                    'meta_keywords' => 'dental prosthetics, restoration, crowns, bridges',
                ],
                'fr' => [
                    'name' => 'Prothèses',
                    'slug' => 'protheses-dentaires',
                    'description' => 'Prothèses dentaires et matériaux de restauration',
                    'meta_title' => 'Prothèses Dentaires - Matériaux de Restauration',
                    'meta_description' => 'Solutions professionnelles de prothèses et restauration dentaire',
                    'meta_keywords' => 'prothèses dentaires, restauration, couronnes, bridges',
                ],
                'ar' => [
                    'name' => 'الأطراف الصناعية',
                    'slug' => 'dental-prosthetics-ar',
                    'description' => 'الأطراف الصناعية ومواد الترميم لطب الأسنان',
                    'meta_title' => 'أطراف الأسنان الصناعية - مواد الترميم',
                    'meta_description' => 'حلول احترافية للأطراف الصناعية وترميم الأسنان',
                    'meta_keywords' => 'أطراف الأسنان الصناعية، ترميم، تيجان، جسور',
                ],
            ],
            'orthodontics' => [
                'en' => [
                    'name' => 'Orthodontics',
                    'slug' => 'dental-orthodontics',
                    'description' => 'Orthodontic equipment and supplies',
                    'meta_title' => 'Orthodontics - Professional Equipment',
                    'meta_description' => 'Professional orthodontic equipment and treatment supplies',
                    'meta_keywords' => 'orthodontics, braces, aligners, orthodontic tools',
                ],
                'fr' => [
                    'name' => 'Orthodontie',
                    'slug' => 'orthodontie-dentaire',
                    'description' => 'Équipements et fournitures orthodontiques',
                    'meta_title' => 'Orthodontie - Équipement Professionnel',
                    'meta_description' => 'Équipements orthodontiques professionnels et fournitures de traitement',
                    'meta_keywords' => 'orthodontie, appareils dentaires, aligneurs, outils orthodontiques',
                ],
                'ar' => [
                    'name' => 'تقويم الأسنان',
                    'slug' => 'dental-orthodontics-ar',
                    'description' => 'معدات ومستلزمات تقويم الأسنان',
                    'meta_title' => 'تقويم الأسنان - معدات احترافية',
                    'meta_description' => 'معدات تقويم الأسنان الاحترافية ومستلزمات العلاج',
                    'meta_keywords' => 'تقويم الأسنان، تقويمات، مصففات، أدوات تقويم',
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
            [
                'sku' => 'DENTAL-001',
                'type' => 'simple',
                'product_number' => 'DN-DRILL-001',
                'name' => 'Professional Dental Drill',
                'short_description' => 'High-speed dental drill for professional use',
                'description' => 'Professional high-speed dental drill with variable speed control, ergonomic design, and precision engineering. Suitable for all dental procedures requiring drilling and shaping.',
                'url_key' => 'professional-dental-drill',
                'meta_title' => 'Professional Dental Drill - High Speed',
                'meta_keywords' => 'dental drill, high speed, professional, dentist equipment',
                'meta_description' => 'Professional dental drill with high speed and precision control',
                'price' => 450.00,
                'weight' => 0.8,
                'categories' => ['main', 'instruments'],
                'images' => ['dental-drill.jpg', 'dental-drill-2.jpg'],
            ],
            [
                'sku' => 'DENTAL-002',
                'type' => 'simple',
                'product_number' => 'DN-XRAY-002',
                'name' => 'Dental X-Ray Machine',
                'short_description' => 'Digital dental X-ray imaging system',
                'description' => 'State-of-the-art digital dental X-ray machine with high-resolution imaging, low radiation exposure, and instant image processing. Perfect for diagnostic imaging in dental practices.',
                'url_key' => 'dental-xray-machine',
                'meta_title' => 'Digital Dental X-Ray Machine',
                'meta_keywords' => 'dental x-ray, digital imaging, radiography, dental equipment',
                'meta_description' => 'Professional digital dental X-ray machine for diagnostic imaging',
                'price' => 15000.00,
                'special_price' => 12500.00,
                'special_price_from' => $currentDate,
                'special_price_to' => Carbon::parse($currentDate)->addDays(30)->format('Y-m-d H:i:s'),
                'weight' => 25.0,
                'categories' => ['main', 'imaging'],
                'images' => ['xray-machine.jpg'],
            ],
            [
                'sku' => 'DENTAL-003',
                'type' => 'simple',
                'product_number' => 'DN-CHAIR-003',
                'name' => 'Dental Examination Chair',
                'short_description' => 'Comfortable patient examination chair',
                'description' => 'Fully adjustable dental examination chair with memory foam padding, LED lighting system, and hydraulic positioning. Provides maximum comfort for patients during dental procedures.',
                'url_key' => 'dental-examination-chair',
                'meta_title' => 'Dental Examination Chair - Professional',
                'meta_keywords' => 'dental chair, examination, patient comfort, dental furniture',
                'meta_description' => 'Professional dental examination chair with adjustable positioning',
                'price' => 3200.00,
                'weight' => 85.0,
                'categories' => ['main', 'instruments'],
                'images' => ['dental-chair.jpg', 'dental-chair-side.jpg'],
            ],
            [
                'sku' => 'DENTAL-004',
                'type' => 'simple',
                'product_number' => 'DN-SUCT-004',
                'name' => 'Dental Suction Unit',
                'short_description' => 'High-powered dental suction system',
                'description' => 'Professional dental suction unit with powerful motor, quiet operation, and easy maintenance. Essential for maintaining a clean working environment during dental procedures.',
                'url_key' => 'dental-suction-unit',
                'meta_title' => 'Dental Suction Unit - High Power',
                'meta_keywords' => 'dental suction, vacuum, dental equipment, hygiene',
                'meta_description' => 'Professional dental suction unit for clean procedures',
                'price' => 1800.00,
                'weight' => 15.0,
                'categories' => ['main', 'hygiene'],
                'images' => ['suction-unit.jpg'],
            ],
            [
                'sku' => 'DENTAL-005',
                'type' => 'simple',
                'product_number' => 'DN-AUTO-005',
                'name' => 'Dental Autoclave Sterilizer',
                'short_description' => 'Medical-grade sterilization equipment',
                'description' => 'Advanced autoclave sterilizer for dental instruments with automatic controls, safety features, and validation systems. Ensures complete sterilization of all dental tools.',
                'url_key' => 'dental-autoclave-sterilizer',
                'meta_title' => 'Dental Autoclave Sterilizer - Medical Grade',
                'meta_keywords' => 'autoclave, sterilizer, dental hygiene, medical equipment',
                'meta_description' => 'Medical-grade autoclave sterilizer for dental practices',
                'price' => 2500.00,
                'weight' => 30.0,
                'categories' => ['main', 'hygiene'],
                'images' => ['autoclave.jpg', 'autoclave-interior.jpg'],
            ],
            [
                'sku' => 'DENTAL-006',
                'type' => 'simple',
                'product_number' => 'DN-INST-006',
                'name' => 'Dental Hand Instruments Set',
                'short_description' => 'Complete set of dental hand tools',
                'description' => 'Comprehensive set of professional dental hand instruments including probes, mirrors, excavators, and scalers. Made from high-grade stainless steel with ergonomic handles.',
                'url_key' => 'dental-hand-instruments-set',
                'meta_title' => 'Dental Hand Instruments Set - Professional',
                'meta_keywords' => 'dental instruments, hand tools, dental kit, stainless steel',
                'meta_description' => 'Professional dental hand instruments set with ergonomic design',
                'price' => 280.00,
                'weight' => 1.2,
                'categories' => ['main', 'instruments'],
                'images' => ['hand-instruments.jpg', 'instruments-detail.jpg'],
            ],
            [
                'sku' => 'DENTAL-007',
                'type' => 'simple',
                'product_number' => 'DN-LED-007',
                'name' => 'LED Dental Operating Light',
                'short_description' => 'Bright LED surgical lighting system',
                'description' => 'Professional LED dental operating light with adjustable intensity, shadow-free illumination, and color temperature control. Provides optimal lighting for precise dental work.',
                'url_key' => 'led-dental-operating-light',
                'meta_title' => 'LED Dental Operating Light - Professional',
                'meta_keywords' => 'dental light, LED, surgical lighting, dental equipment',
                'meta_description' => 'Professional LED dental operating light for precise procedures',
                'price' => 1200.00,
                'weight' => 8.0,
                'categories' => ['main', 'instruments'],
                'images' => ['dental-light.jpg'],
            ],
            [
                'sku' => 'DENTAL-008',
                'type' => 'simple',
                'product_number' => 'DN-COMP-008',
                'name' => 'Dental Compressor Unit',
                'short_description' => 'Oil-free dental air compressor',
                'description' => 'Reliable oil-free dental air compressor with quiet operation, automatic moisture removal, and consistent air pressure delivery. Essential for powering dental instruments.',
                'url_key' => 'dental-compressor-unit',
                'meta_title' => 'Dental Air Compressor - Oil Free',
                'meta_keywords' => 'dental compressor, air supply, oil-free, dental equipment',
                'meta_description' => 'Oil-free dental air compressor for reliable operation',
                'price' => 2200.00,
                'weight' => 45.0,
                'categories' => ['main', 'hygiene'],
                'images' => ['compressor.jpg', 'compressor-controls.jpg'],
            ],
            [
                'sku' => 'DENTAL-009',
                'type' => 'simple',
                'product_number' => 'DN-GLOV-009',
                'name' => 'Disposable Dental Gloves',
                'short_description' => 'Latex-free examination gloves',
                'description' => 'High-quality latex-free disposable gloves for dental examinations and procedures. Powder-free design with excellent tactile sensitivity and puncture resistance.',
                'url_key' => 'disposable-dental-gloves',
                'meta_title' => 'Disposable Dental Gloves - Latex Free',
                'meta_keywords' => 'dental gloves, disposable, latex-free, examination',
                'meta_description' => 'Latex-free disposable dental gloves for professional use',
                'price' => 45.00,
                'weight' => 0.5,
                'categories' => ['main', 'consumables'],
                'images' => ['dental-gloves.jpg'],
            ],
            [
                'sku' => 'DENTAL-010',
                'type' => 'simple',
                'product_number' => 'DN-CRWN-010',
                'name' => 'Dental Crown Kit',
                'short_description' => 'Complete crown restoration system',
                'description' => 'Professional dental crown restoration kit including crowns, cement, and installation tools. Perfect for restorative dentistry and cosmetic procedures.',
                'url_key' => 'dental-crown-kit',
                'meta_title' => 'Dental Crown Kit - Restoration System',
                'meta_keywords' => 'dental crown, restoration, prosthetics, cosmetic dentistry',
                'meta_description' => 'Complete dental crown restoration kit for professional use',
                'price' => 890.00,
                'special_price' => 750.00,
                'special_price_from' => $currentDate,
                'special_price_to' => Carbon::parse($currentDate)->addDays(15)->format('Y-m-d H:i:s'),
                'weight' => 2.0,
                'categories' => ['main', 'prosthetics'],
                'images' => ['crown-kit.jpg', 'crown-samples.jpg'],
            ],
            [
                'sku' => 'DENTAL-011',
                'type' => 'simple',
                'product_number' => 'DN-BRKT-011',
                'name' => 'Orthodontic Bracket Set',
                'short_description' => 'Metal orthodontic brackets',
                'description' => 'Professional orthodontic bracket set made from high-grade stainless steel. Includes various sizes for comprehensive orthodontic treatment plans.',
                'url_key' => 'orthodontic-bracket-set',
                'meta_title' => 'Orthodontic Bracket Set - Metal Brackets',
                'meta_keywords' => 'orthodontic brackets, braces, orthodontics, teeth alignment',
                'meta_description' => 'Professional orthodontic bracket set for teeth alignment treatment',
                'price' => 320.00,
                'weight' => 1.5,
                'categories' => ['main', 'orthodontics'],
                'images' => ['bracket-set.jpg', 'brackets-detail.jpg'],
            ],
            [
                'sku' => 'DENTAL-012',
                'type' => 'simple',
                'product_number' => 'DN-CAM-012',
                'name' => 'Digital Intraoral Camera',
                'short_description' => 'High-definition intraoral imaging',
                'description' => 'Advanced digital intraoral camera with HD imaging, LED illumination, and wireless connectivity. Perfect for patient consultation and treatment documentation.',
                'url_key' => 'digital-intraoral-camera',
                'meta_title' => 'Digital Intraoral Camera - HD Imaging',
                'meta_keywords' => 'intraoral camera, digital imaging, dental photography',
                'meta_description' => 'Professional digital intraoral camera with HD imaging capabilities',
                'price' => 1850.00,
                'weight' => 0.6,
                'categories' => ['main', 'imaging'],
                'images' => ['intraoral-camera.jpg'],
            ],
        ];
    }
}
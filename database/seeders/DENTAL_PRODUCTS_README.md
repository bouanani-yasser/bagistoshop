# Dental Products Seeder

This seeder adds a comprehensive collection of dental products to your Bagisto store with dummy images and organized categories.

## Features

### **Dental Categories Structure**

- **Main Category**: Dental Products / Produits Dentaires
    - **Instruments** / **Instruments** - Professional dental instruments and hand tools
    - **Consumables** / **Consommables** - Dental consumables and disposable supplies
    - **Imaging** / **Imagerie** - Dental imaging equipment and radiography systems
    - **Hygiene** / **Hygiène** - Dental hygiene and sterilization equipment
    - **Prosthetics** / **Prothèses** - Dental prosthetics and restoration materials
    - **Orthodontics** / **Orthodontie** - Orthodontic equipment and supplies

### **12 Professional Dental Products** including:

- Professional Dental Drill
- Dental X-Ray Machine
- Dental Examination Chair
- Dental Suction Unit
- Dental Autoclave Sterilizer
- Dental Hand Instruments Set
- LED Dental Operating Light
- Dental Compressor Unit
- Disposable Dental Gloves
- Dental Crown Kit
- Orthodontic Bracket Set
- Digital Intraoral Camera

- **Multilingual Support**: Categories available in English and French
- **Product Images**: Each product comes with placeholder images automatically generated
- **Complete Product Data**: Includes descriptions, SEO meta data, pricing, and weights
- **Special Offers**: Some products include special pricing
- **Category Assignment**: Products are properly categorized into appropriate subcategories

## Installation

### Option 1: Run with all seeders

```bash
php artisan db:seed
```

### Option 2: Run only dental products seeder

```bash
php artisan db:seed --class=DentalProductsSeeder
```

### Option 3: Use the custom command

```bash
php artisan seed:dental-products
```

## Product Details

| SKU        | Product                     | Category     | Price      | Special Price |
| ---------- | --------------------------- | ------------ | ---------- | ------------- |
| DENTAL-001 | Professional Dental Drill   | Instruments  | $450.00    | -             |
| DENTAL-002 | Dental X-Ray Machine        | Imaging      | $15,000.00 | $12,500.00    |
| DENTAL-003 | Dental Examination Chair    | Instruments  | $3,200.00  | -             |
| DENTAL-004 | Dental Suction Unit         | Hygiene      | $1,800.00  | -             |
| DENTAL-005 | Dental Autoclave Sterilizer | Hygiene      | $2,500.00  | -             |
| DENTAL-006 | Dental Hand Instruments Set | Instruments  | $280.00    | -             |
| DENTAL-007 | LED Dental Operating Light  | Instruments  | $1,200.00  | -             |
| DENTAL-008 | Dental Compressor Unit      | Hygiene      | $2,200.00  | -             |
| DENTAL-009 | Disposable Dental Gloves    | Consumables  | $45.00     | -             |
| DENTAL-010 | Dental Crown Kit            | Prosthetics  | $890.00    | $750.00       |
| DENTAL-011 | Orthodontic Bracket Set     | Orthodontics | $320.00    | -             |
| DENTAL-012 | Digital Intraoral Camera    | Imaging      | $1,850.00  | -             |

## Image Generation

The seeder includes an automatic image generation system that creates placeholder images for all products. If specific product images are not found, colorful placeholder images will be automatically generated.

## File Structure

```
database/
├── seeders/
│   ├── DentalProductsSeeder.php
│   └── images/
│       ├── generate_dental_images.php
│       └── dental/
│           ├── dental-drill.jpg
│           ├── xray-machine.jpg
│           ├── dental-chair.jpg
│           └── ... (other product images)
app/
└── Console/
    └── Commands/
        └── SeedDentalProducts.php
```

## Customization

You can customize the dental products by modifying the `getDentalProductsData()` method in `DentalProductsSeeder.php`. Each product entry supports:

- SKU and product type
- Name, descriptions, and meta data
- Pricing (regular and special)
- Weight specifications
- Multiple product images
- URL key for SEO

## Requirements

- Bagisto e-commerce platform
- PHP GD extension (for image generation)
- Standard Laravel seeding functionality

## Notes

- The seeder will create a "Dental Products" category under the root category
- All products are marked as new and featured
- Products are assigned to the default channel
- Images are stored in Laravel's storage system
- The seeder is safe to run multiple times (it doesn't duplicate data)

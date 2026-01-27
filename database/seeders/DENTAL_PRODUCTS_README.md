# Dental Products Seeder

This seeder adds a comprehensive collection of dental products to your Bagisto store with dummy images and organized categories.

## Features

### **Dental Categories Structure**

- **Main Category**: Dental Products / Produits Dentaires
    - **Composite** / **Composite** - Composite resins and restoration materials
    - **Anesthesia** / **Anesthésie** - Local anesthetics and injectables
    - **Cements** / **Ciments** - Dental cements and adhesive materials
    - **Bonding** / **Liaison** - Bonding agents and adhesive systems
    - **Alginate** / **Alginate** - Alginate impression materials
    - **Amalgam** / **Amalgame** - Amalgam and mercury-containing restorative materials
    - **Silicone** / **Silicone** - Silicone products and instruments
    - **Gutta/Paper Cones** / **Gutta/Cônes Papier** - Endodontic treatment materials
    - **Miscellaneous** / **Divers** - Additional dental supplies and accessories

### **75+ Professional Dental Products** including:

**Composites**: 3M Z250, Charisma Diamond KULZER, Charisma Smart KULZER, Tetric N Ceram IVOCLAR, Zirconfill, and more

**Anesthetics**: LIDOCAINE spray, Medicaine, Septodont

**Cements**: Extracem PDG, Fuji 1 GC, I-Fill Glass Ionomer

**Bonding**: Bonding megafil, C bond bonding ceram

**Alginates**: Alginat millenium LASCOD, Alginat tropical LASCOD

**Amalgams**: ARCCO, RUBY CAP, ARDENT (simple and double doses)

**Silicone Products**: ENDOBOX, ENDOMATE, Gutta cutters, Fraisier tools

**Endodontic Materials**: Gutta cones (various sizes), Absorbent paper

**Miscellaneous**: Endo plus PDG, Ligature, Lubricant, Impression trays, Molar tubes

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

| SKU      | Product Name                   | Category          | Price      |
| -------- | ------------------------------ | ----------------- | ---------- |
| COMP-001 | 3M Z250                        | Composite         | 3,650 DA   |
| COMP-002 | Charisma Diamond KULZER        | Composite         | 5,200 DA   |
| COMP-003 | Charisma Smart KULZER          | Composite         | 2,200 DA   |
| COMP-004 | Coffret Charisma Smart         | Composite         | 17,500 DA  |
| COMP-005 | Coffret Dix Universal          | Composite         | 9,500 DA   |
| COMP-006 | Coffret Ivoclar                | Composite         | 21,000 DA  |
| COMP-007 | Composite Diamond A3           | Composite         | 4,900 DA   |
| COMP-008 | Dynamic Plus                   | Composite         | 2,600 DA   |
| COMP-009 | Flow Denu                      | Composite         | 1,100 DA   |
| COMP-010 | Flow i DENTAL kit              | Composite         | 6,200 DA   |
| COMP-011 | Flow RUBY                      | Composite         | 900 DA     |
| COMP-012 | MEGA FIL                       | Composite         | 2,500 DA   |
| COMP-013 | Tetric N Ceram IVOCLAR         | Composite         | 2,950 DA   |
| COMP-014 | Tetric N Ceram IVOCLAR bulk    | Composite         | 3,200 DA   |
| COMP-015 | Zenchroma PDG universal        | Composite         | 5,300 DA   |
| COMP-016 | Zirconfill                     | Composite         | 2,900 DA   |
| COMP-017 | Zomaxfill                      | Composite         | 1,500 DA   |
| ANES-001 | LIDOCAINE spray                | Anesthesia        | 2,200 DA   |
| ANES-002 | Medicaine 2%                   | Anesthesia        | 3,000 DA   |
| ANES-003 | Medicaine 3%                   | Anesthesia        | 3,200 DA   |
| ANES-004 | Septodont                      | Anesthesia        | 3,700 DA   |
| CIME-001 | Extracem PDG                   | Cements           | 7,800 DA   |
| CIME-002 | Fuji 1 GC                      | Cements           | 175,000 DA |
| CIME-003 | Fuji 1 plus GC                 | Cements           | 205,000 DA |
| CIME-004 | Ciment verre ionomer I-Fill    | Cements           | 5,250 DA   |
| BOND-001 | Bonding megafil                | Bonding           | 2,850 DA   |
| BOND-002 | C bond bonding ceram           | Bonding           | 1,850 DA   |
| ALGI-001 | Alginat millenium LASCOD       | Alginate          | 1,250 DA   |
| ALGI-002 | Alginat tropical LASCOD        | Alginate          | 1,000 DA   |
| AMAL-001 | Double dose ARCCO              | Amalgam           | 10,500 DA  |
| AMAL-002 | Simple dose ARCCO              | Amalgam           | 7,800 DA   |
| AMAL-003 | Double dose RUBY CAP           | Amalgam           | 9,500 DA   |
| AMAL-004 | Simple dose RUBY CAP           | Amalgam           | 7,400 DA   |
| AMAL-005 | Double dose ARDENT             | Amalgam           | 8,500 DA   |
| SILI-001 | Boite fraise pour désinfection | Silicone          | 1,500 DA   |
| SILI-002 | ENDOBOX                        | Silicone          | 3,500 DA   |
| SILI-003 | ENDOMATE                       | Silicone          | 31,500 DA  |
| SILI-004 | Fraisier bleu                  | Silicone          | 1,250 DA   |
| SILI-005 | Fraisier PM                    | Silicone          | 900 DA     |
| SILI-006 | Gutta cutter                   | Silicone          | 5,500 DA   |
| SILI-007 | Housse fauteuil                | Silicone          | 4,800 DA   |
| GUPA-001 | Gutta 04/20 SANI               | Gutta/Paper Cones | 850 DA     |
| GUPA-002 | Gutta 04/25 SANI               | Gutta/Paper Cones | 850 DA     |
| GUPA-003 | Gutta 06/20 SANI               | Gutta/Paper Cones | 850 DA     |
| GUPA-004 | Gutta 06/25 SANI               | Gutta/Paper Cones | 850 DA     |
| GUPA-005 | Papier absorbent 04/20 SANI    | Gutta/Paper Cones | 850 DA     |
| GUPA-006 | Papier absorbent 04/25 SANI    | Gutta/Paper Cones | 850 DA     |
| GUPA-007 | Papier absorbent 06/20 SANI    | Gutta/Paper Cones | 850 DA     |
| GUPA-008 | Papier absorbent 06/25 SANI    | Gutta/Paper Cones | 850 DA     |
| MISC-001 | Endo plus PDG                  | Miscellaneous     | 5,800 DA   |
| MISC-002 | Ligature ODF en couleur        | Miscellaneous     | 900 DA     |
| MISC-003 | Lubrifiant                     | Miscellaneous     | 2,200 DA   |
| MISC-004 | Porte empreinte COTISEN        | Miscellaneous     | 750 DA     |
| MISC-005 | Tube molaire 10 bouches        | Miscellaneous     | 2,800 DA   |

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

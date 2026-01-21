<?php

namespace App\Console\Commands;

use Database\Seeders\DentalProductsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedDentalProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:dental-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with dental products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Seeding dental products...');
        
        try {
            Artisan::call('db:seed', ['--class' => DentalProductsSeeder::class]);
            $this->info('Dental products seeded successfully!');
        } catch (\Exception $e) {
            $this->error('Error seeding dental products: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
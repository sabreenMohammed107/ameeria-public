<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(InvoiceTypeSeeder::class);
         $this->call(SettingsSeeder::class);
    }
}

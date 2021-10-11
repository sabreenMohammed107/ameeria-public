<?php

use App\Models\InvoiceType;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function run()
        {
            $types = [
                ['name' => 'طبع', 'notes' => 'لا يوجد لها سعر فى الاصناف'],
                ['name' => 'نشر', 'notes' => 'لايوجد لها سعر فى الاصناف'],
                ['name' => 'مطبوعات موحده', 'notes' => ''],
                ['name' => 'حسابية', 'notes' => ''],
                ['name' => 'ذات قيمه', 'notes' => ''],
            ];
            foreach($types as $type){
                InvoiceType::create($type);
            }
    }
}

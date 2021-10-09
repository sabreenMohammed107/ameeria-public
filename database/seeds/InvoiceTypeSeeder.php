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
                ['id' => 1, 'name' => 'طبع', 'notes' => 'لا يوجد لها سعر فى الاصناف'],
                ['id' => 2, 'name' => 'نشر', 'notes' => 'لايوجد لها سعر فى الاصناف'],
                ['id' => 3, 'name' => 'مطبوعات موحده', 'notes' => ''],
                ['id' => 4, 'name' => 'حسابية', 'notes' => ''],
                ['id' => 5, 'name' => 'ذات قيمه', 'notes' => ''],
                        ];
                        foreach($types as $type){
                            InvoiceType::create($type);
                        }

}
}

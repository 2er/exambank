<?php

use Illuminate\Database\Seeder;
use App\Models\Examination;

class ExaminationsTableSeeder extends Seeder
{
    public function run()
    {
        $examinations = factory(Examination::class)->times(50)->make()->each(function ($examination, $index) {
            if ($index == 0) {
                // $examination->field = 'value';
            }
        });

        Examination::insert($examinations->toArray());
    }

}


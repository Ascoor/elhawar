<?php

use Illuminate\Database\Seeder;

class EmployeesAssessmentSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees_assessment_settings')->insert([
            [
                'name' => 'assessment',
                'ass_val' => 10,
            ],

        ]);
    }
}

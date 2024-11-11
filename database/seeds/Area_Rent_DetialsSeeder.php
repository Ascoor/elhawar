<?php

use Illuminate\Database\Seeder;
use App\AreaRent;
use App\EmployeeDetails;

use Illuminate\Support\Arr;

class Area_Rent_DetialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('area_rent_details_id')->truncate();

// Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d');
        for ($i = 1; $i <= 30; $i++) {


            
            // $total_price =$total_hour * $price;
            $guardian=Arr::random(['yes', 'no']);
             \DB::table('area_rent_details')->insert([
                'id'=>$i,
                'area_name'=> Arr::random(['Fair Athena Hall', 'The Studious Nest Hall', 'Peace Estate Hall','Academic Rise Hall','The College Spot Hall','The Study Hamlet Hall','Freedom Hall']),
                'area_capacity'=> rand(100, 1000),
                'description'=>Arr::random(['', 'cancelederferferfree']),
                'guardian'=>$guardian,
                'price'=>rand(1000, 5000),
                // hourly price 
                //price = price * hour 
                'currency'=>rand(1, 3),
                'created_at' => now(),
            ]);
            if($guardian=='yes'){
                \DB::table('area_rent_details')->insert([
                'employee_details_id'=>EmployeeDetails::all()->random()->id,
                ]);
            }
        }
    
    }
}

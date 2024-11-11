<?php

use Illuminate\Database\Seeder;
use App\AreaRent;

use Illuminate\Support\Arr;
class Rented_AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rented_area')->truncate();

    //     $startDate = Carbon::now();
    //    $endDate   = Carbon::now()->subDays(7);

// Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d');
        for ($i = 1; $i <= 30; $i++) {

            $price= AreaRent::where('id','area_rent_details_id')->get('price');
            $currency =AreaRent::where('id','area_rent_details_id')->get('currency');

            $start_time=rand(0, 24);         
            $end_time=rand(0, 24);
            $total_hour= ($start_time - $end_time ) / $currency;
            $total_hour=str_replace('-','',$total_hour);
            $total_price =$total_hour * $price;
            // 2023-07-13 13:53:37
            
            // $randomTimestamp = mt_rand(1262055681,1262055681);
            // $randomDate = new DateTime();
            // $randomDate->setTimestamp($randomTimestamp);

            $int= mt_rand(1262055681,1262055681);
            $randomDate = date("d-m-Y H:i:s",$int);


            \DB::table('rented_area')->insert([
                'id'=>$i,
                'total_price'=> AreaRent::where('id','area_rent_details_id')->get('price'),
                'start_time'=>$start_time,
                'end_time'=>$end_time,
                // 'date'=> Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('d-m-Y'),
                // 'date'=> ( rand(1, 12) . "-" . rand(1, 28) . "/" . rand(2022,2023))->format('d-m-Y H:i:s'),
                'occasion_date'=> $randomDate,

                'area_rent_details_id'=>AreaRent::all()->random()->id,
                 // 'date_of_birth'=> rand(1, 12) . "/" . rand(1, 28) . "/" . rand(1933, 1998),
                'status'=>Arr::random(['generated', 'canceled', 'started']),
           

           
              
               

           
           
                'created_at' => now(),
            ]);
        }
    
    }
}

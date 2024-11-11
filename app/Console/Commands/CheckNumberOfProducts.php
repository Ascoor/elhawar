<?php

namespace App\Console\Commands;

use App\AttendanceSetting;
use App\Company;
use App\Events\AttendanceReminderEvent;
use App\Holiday;
use App\Notifications\ItemDecreased;
use App\Scopes\CompanyScope;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckNumberOfProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-number-of-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send attendance reminder to the employee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
         })->get();
     $products = DB::table('product_inventories')
         ->join('products', 'products.id', '=', 'product_inventories.product')
          ->get();
      foreach ($products as $product){
          if ($product->item_in_stock < 4){
              Notification::send($admins, new ItemDecreased($product));
          }
      }
    }
}
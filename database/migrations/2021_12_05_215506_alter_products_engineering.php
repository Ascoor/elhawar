<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\EngineeringProduct;

class AlterProductsEngineering extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('engineering_products', function (Blueprint $table) {

            $table->text('description')->nullable();
        });
        $products = EngineeringProduct::all();
        if ($products->count() > 0){
            foreach ($products as $product){
                $arr = [];
                if ($product->tax_id){
                    $arr[] = (string)$product->tax_id;
                }
                $product->taxes = $arr ? json_encode($arr) : null;
                $product->save();
            }
        }

        Schema::table('engineering_products', function (Blueprint $table) {
            $table->dropForeign('engineering_products_tax_id_foreign');
            $table->dropColumn('tax_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('engineering_products', function (Blueprint $table) {
            $table->dropColumn('taxes');
            $table->dropColumn('description');
        });
    }
}

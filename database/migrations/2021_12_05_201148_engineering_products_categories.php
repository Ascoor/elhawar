<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EngineeringProductsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineering_product_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('category_name');
            $table->timestamps();
        });
        Schema::create('engineering_product_sub_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('engineering_product_category')->onDelete('cascade')->onUpdate('cascade');
            $table->string('category_name');
            $table->timestamps();
        });

        Schema::table('engineering_products', function (Blueprint $table) {
            $table->boolean('allow_purchase')->default(0)->after('taxes');
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->foreign('category_id')->references('id')->on('engineering_product_category')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('sub_category_id')->nullable()->default(null);
            $table->foreign('sub_category_id')->references('id')->on('engineering_product_sub_category')->onDelete('cascade')->onUpdate('cascade');
        });
        $companies = \App\Company::all();

        foreach($companies as $company){
            $package         = \App\Package::findOrFail($company->package_id);
            $moduleInPackage = (array) json_decode($package->module_in_package);

            if (in_array('products', $moduleInPackage)) {
                $moduleSetting = new ModuleSetting();
                $moduleSetting->company_id = $company->id;
                $moduleSetting->module_name = 'products';
                $moduleSetting->status = 'active';
                $moduleSetting->type = 'client';
                $moduleSetting->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engineering_products_category');
        Schema::dropIfExists('engineering_product_sub_category');

        Schema::table('engineering_products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn('category_id');
            $table->dropColumn('sub_category_id');
            $table->dropForeign(['allow_purchase']);
        });
    }
}
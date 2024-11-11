<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // Schema::create('companies', function (Blueprint $table) {
        //     // $table->id();
        //     // $table->timestamps();
        //     // DROP TABLE IF EXISTS `companies`;
        //     // CREATE TABLE IF NOT EXISTS `companies` (
        //         $table->id();
        //         $table->string('company_name');
        //         $table->string('company_email');
        //         $table->string('company_phone');
        //         $table->string('logo');
        //         $table->string('login_background');
        //         $table->text('address');
        //         $table->string('website');

        //         $table->enum('package_type', ['annual', 'monthly'])->default('monthly');

        //         // currency_id
        //         $table->integer('currency_id')->unsigned()->nullable();
        //         $table->foreign('currency_id')->references('id')->on('companies_currency_id_foreign');
        //         // ->onDelete('SET NULL')->onUpdate('cascade');


        //         //`package_id`
        //         $table->integer('package_id')->unsigned()->nullable();
        //         $table->foreign('package_id')->references('id')->on('companies_package_id_foreign');


        //         $table->string('timezone')->defult('Africa/Cairo');
        //         $table->string('date_format')->defult('d-m-Y');
        //         $table->string('date_picker_format')->nullable();
        //         $table->string('moment_format')->nullable();
        //         $table->string('time_format')->defult('h:i A');
        //         $table->integer('week_start')->defult('1');
        //         $table->integer('locale')->defult('en');
        //         $table->decimal('latitude')->nullable();
        //         $table->decimal('longitude')->nullable();
                
        //         $table->enum('leaves_start_from', ['joining_date', 'year_start'])->default('joining_date');
        //         $table->enum('active_theme', ['default','custom'])->default('default');
        //         $table->enum('status', ['active','inactive','license_expired'])->default('active');
        //         $table->enum('task_self', ['yes','no'])->default('yes');

        //         //`last_updated_by`
        //         $table->integer('last_updated_by')->unsigned()->nullable();
        //         $table->foreign('last_updated_by')->references('id')->on('organisation_settings_last_updated_by_foreign');
    
              
        //         $table->string('stripe_id')->nullable();
        //         $table->string('card_brand')->nullable();
        //         $table->string('card_last_four')->nullable();
        //         $table->timestamp('trial_ends_at')->nullable();
        //         $table->date('licence_expire_on');
        //         $table->tinyint('rounded_theme')->defult('1');
        //         $table->datetime('last_login')->nullable();
                
        //          //`default_task_status`
        //          $table->integer('default_task_status')->unsigned()->nullable();
        //          $table->foreign('default_task_status')->references('id')->on('companies_default_task_status_foreign');

        //          $table->tinyint('show_update_popup')->defult('1');
        //          $table->tinyint('dashboard_clock')->defult('1');
        //          $table->tinyint('lead_form_google_captcha')->defult('0');
                 
        //          $table->tinyint('rtl')->defult('0');

             
           
              
        //     //   KEY `organisation_settings_last_updated_by_foreign` (`last_updated_by`),
        //     //   KEY `companies_package_id_foreign` (`package_id`),
        //     //   KEY `companies_default_task_status_foreign` (`default_task_status`),
        //     //   KEY `companies_currency_id_foreign` (`currency_id`)
        //     // ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
            
            


        // });


}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('companies');
    }
}

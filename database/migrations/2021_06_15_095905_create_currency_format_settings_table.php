<?php

// Import the classes that are needed for the migration
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\CurrencyFormatSetting;

// Define the migration class that creates the currency_format_settings table
class CreateCurrencyFormatSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the table using the Schema facade
        Schema::create('currency_format_settings', function (Blueprint $table) {
            // Add an auto-incrementing id column as the primary key
            $table->id();
            // Add a company_id column that references the id column of the companies table
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            // Add a currency_position column that can have one of four values: left, right, left_with_space, or right_with_space
            $table->enum('currency_position', ['left', 'right', 'left_with_space', 'right_with_space'])->default('left');
            // Add a no_of_decimal column that stores the number of decimal places for the currency format
            $table->integer('no_of_decimal')->unsigned();
            // Add a thousand_separator column that stores the character used to separate thousands in the currency format
            $table->string('thousand_separator')->nullable();
            // Add a decimal_separator column that stores the character used to separate decimals in the currency format
            $table->string('decimal_separator')->nullable();
        });

        // Create a new instance of the CurrencyFormatSetting model
        $currencyFormatSetting = new CurrencyFormatSetting();
        // Set the default values for the currency format settings
        $currencyFormatSetting->currency_position = 'left';
        $currencyFormatSetting->no_of_decimal = '2';
        $currencyFormatSetting->thousand_separator = ',';
        $currencyFormatSetting->decimal_separator = '.';
        // Save the model to the database
        $currencyFormatSetting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table using the Schema facade
        Schema::dropIfExists('currency_format_settings');
    }
}

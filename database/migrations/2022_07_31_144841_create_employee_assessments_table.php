<?php

// Import the classes that are needed for the migration
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Define the migration class that creates the employee_assessments table
class CreateEmployeeAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the table using the Schema facade
        Schema::create('employee_assessments', function (Blueprint $table) {
            // Add an auto-incrementing id column as the primary key
            $table->increments('id');
            // Add a user_id column that references the id column of the users table
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            // Add a name column that stores the name of the assessment
            $table->string('name');
            // Add an employee_name column that stores the name of the employee being assessed
            $table->string('employee_name');
            // Add a status column that can have one of three values: pending, approved, or refused
            $table->enum('status', ['pending', 'approved', 'refused'])->default('pending');
            // Add an opinion1 column that stores the first opinion of the assessment
            $table->string('opinion1')->nullable();
            // Add an opinion2 column that stores the second opinion of the assessment
            $table->string('opinion2')->nullable();
            // Add an opinion3 column that stores the third opinion of the assessment
            $table->string('opinion3')->nullable();
            // Add a date column that stores the date of the assessment
            $table->string('date')->nullable();
            // Add an assessment_percentage column that stores the percentage of the assessment
            $table->integer('assessment_percentage')->default('0');
            // Add an extra_json column that stores any extra data in JSON format
            $table->text('extra_json')->nullable();
            // Add timestamps columns to track the creation and update dates of the records
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table using the Schema facade
        Schema::dropIfExists('employee_assessments');
    }
}

<?php

use App\GlobalSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `packages` CHANGE `default` `default` ENUM('yes','no','trial') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'no'");

        Schema::create('package_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->integer('no_of_days')->nullable()->default(30);
            $table->string('modules', 1000)->nullable()->default(null);
            $table->timestamps();
        });

        $packageSetting = new \App\PackageSetting();
        $packageSetting->status = 'inactive';
        $packageSetting->no_of_days = 30;
        $packageSetting->modules = '{"1":"clients","2":"employees","3":"projects","4":"attendance","5":"tasks","6":"estimates","7":"invoices","8":"payments","9":"timelogs","10":"tickets","11":"events","12":"messages","13":"notices","14":"leaves","15":"leads","16":"holidays","17":"products","18":"expenses","19":"contracts","20":"reports", "21":"members","22":"sportAcademies","23":"sportTeams","24":"players","25":"championships","26":"trips","27":"purchases","28":"inventories","29":"libraries","30":"archives","31":"legalAffairs","32":"PublicRelationsDepartment"}';
        $packageSetting->save();

        $global = GlobalSetting::with('currency')->first();

        $packages = new \App\Package();
        $packages->name                    = 'Trial';
        // $packages->currency_id             = $currency->id;

        if ($global) {
            $packages->currency_id = $global->currency_id;
        }

        $packages->description             = 'Its a trial package';
        $packages->annual_price            = 0;
        $packages->monthly_price           = 0;
        $packages->max_employees           = 20;
        $packages->stripe_annual_plan_id   = 'trial_plan';
        $packages->stripe_monthly_plan_id  = 'trial_plan';
        $packages->default                 = 'trial';
        $packages->module_in_package = '{"1":"clients","2":"employees","3":"projects","4":"attendance","5":"tasks","6":"estimates","7":"invoices","8":"payments","9":"timelogs","10":"tickets","11":"events","12":"messages","13":"notices","14":"leaves","15":"leads","16":"holidays","17":"products","18":"expenses","19":"contracts","20":"reports" , "21":"members","22":"sportAcademies","23":"sportTeams","24":"players","25":"championships","26":"trips","27":"purchases","28":"inventories","29":"libraries","30":"archives","31":"legalAffairs"}';
        $packages->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_settings');

    }
}

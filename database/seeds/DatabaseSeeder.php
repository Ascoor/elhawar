<?php

use Database\Seeders\RequestTypeSeeder;
use Database\Seeders\TeamsSeeder;

use Modules\Accounting\Database\Seeders\AccountingRolesTableSeeder;
use Modules\Accounting\Database\Seeders\BankAccountTypesSeeder;
use Modules\Accounting\Database\Seeders\CredibtorsCodesSeeder;
use Modules\Accounting\Database\Seeders\InsuranceTypesTableSeeder;
use Modules\Accounting\Database\Seeders\LettersOfGuaranteeTypesTableSeeder;
use Modules\Accounting\Database\Seeders\SettingsTableSeeder;
use Modules\Payroll\Database\Seeders\PayrollDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {

        // Set Seeding to true check if data is seeding.
        // This is required to stop notification in installation
        config(['app.seeding' => true]);

        $this->call(GlobalCurrencySeeder::class);
        $this->call(GlobalSettingTableSeeder::class);
        $this->call(PackageTableSeeder::class);

        $this->call(EmailSettingSeeder::class);

        $this->call(FrontSeeder::class);
        $this->call(FrontFeatureSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MemberCategorySeeder::class);
        $this->call(MemberRelationsSeeder::class);
        $this->call(MemberStatusSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(PlayerGroupSeeder::class);
        $this->call(SportAcademySeeder::class);
        $this->call(MemberRoleSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(SportsSeeder::class);
        $this->call(RequestTypeSeeder::class);
        $this->call(ResourceTypeSeeder::class);
        $this->call(TeamsSeeder::class);
        $this->call(MembershipRenewSettingSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ExcludedCategorySeeder::class);
        $this->call(EmployeesAssessmentSettingTableSeeder::class);


        //rola added these
        $this->call(AccountingRolesTableSeeder::class);
        $this->call(BankAccountTypesSeeder::class);
        $this->call(CredibtorsCodesSeeder::class);
        $this->call(InsuranceTypesTableSeeder::class);
        $this->call(LettersOfGuaranteeTypesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);

        
$this->call(PayrollDatabaseSeeder::class);


        config(['app.seeding' => false]);
    }

}

<?php

use App\Designation;
use App\Role;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        \DB::table('companies')->delete();
        \DB::table('users')->delete();
        \DB::table('role_user')->delete();
        \DB::table('teams')->delete();
        \DB::table('designations')->delete();

        \DB::statement('ALTER TABLE teams AUTO_INCREMENT = 1');
        \DB::statement('ALTER TABLE designations AUTO_INCREMENT = 1');
        \DB::statement('ALTER TABLE companies AUTO_INCREMENT = 1');
        \DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');

        $this->createSuperAdmin();

        $company = \App\Company::create([
            'company_name' => 'Elhawar Sports Club',
            'company_email' => 'admin@codagetech.com',
            'company_phone' => '01016542830',
            'address' => '14 50st Zone 13, Maadi, Cairo, Egypt',
            'website' => 'https://codagetech.com',
            'timezone' => 'Africa/Cairo',
            'date_picker_format' => 'dd-mm-yyyy',
        ]);

        $adminRole = Role::where('company_id', $company->id)->where('name', 'admin')->first();
        $employeeRole = Role::where('company_id', $company->id)->where('name', 'employee')->first();
        $clientRole = Role::where('company_id', $company->id)->where('name', 'client')->first();


        $this->createAdmin($company, $adminRole, $employeeRole);
        $this->createEmployee($company, $employeeRole);
        $this->createClient($company, $clientRole);

        if (!App::environment('local')) {
            $this->companiesDataSeeder($company);
        }
    }

    private function companiesDataSeeder($company)
    {
        $faker = \Faker\Factory::create();
        $companies = factory(\App\Company::class)->times(5)->create();
        $companies->prepend($company);

        $companies->each(function ($company) use ($faker) {

            $designations = $this->createDesignation($company);

            $departments = $this->createDepartment($company);

            $adminRole = Role::where('company_id', $company->id)->where('name', 'admin')->first();
            $employeeRole = Role::where('company_id', $company->id)->where('name', 'employee')->first();
            $clientRole = Role::where('company_id', $company->id)->where('name', 'client')->first();

            $accountTypes = [$adminRole->name, $employeeRole->name, $clientRole->name];

            foreach ($accountTypes as $accountType) {

                factory(User::class)->times(3)->make()->each(
                    function ($user) use ($company, $designations, $departments, $faker, $accountType, $adminRole, $employeeRole, $clientRole) {
                        $user->company_id = $company->id;
                        $user->save();

                        if ($accountType == 'admin') {
                            $user->roles()->attach([$adminRole->id, $employeeRole->id]);
                        }
                        if ($accountType == 'employee') {
                            $user->roles()->attach([$employeeRole->id]);
                        }

                        if ($accountType == 'client') {
                            $user->roles()->attach([$clientRole->id]);
                            $this->createClientDetails($company, $user, $faker);
                        } else {
                            $user->employeeDetail()->create([
                                'employee_id' => 'EMP00' . $user->id,
                                'company_id' => $company->id,
                                'address' => $faker->address,
                                'hourly_rate' => rand(10, 50),
                                'slack_username' => $faker->unique()->userName,
                                'joining_date' => $faker->dateTimeThisYear($max = 'now', $timezone = null)->format('Y-m-d'),
                                'department_id' => $departments->get($faker->numberBetween(0, $departments->count() - 1))->id,
                                'designation_id' => $designations->get($faker->numberBetween(0, $designations->count() - 1))->id,
                            ]);
                        }
                    }
                );
            }

            // Leads
            $leads = factory(\App\Lead::class)->times(10)->create([
                'company_id' => $company->id
            ]);
        });
    }

    private function createSuperAdmin()
    {
        $user = new User();
        $user->name = 'Super Admin';
        $user->email = 'superadmin@codagetech.com';
        $user->password = Hash::make('mc@erp');
        $user->super_admin = '1';
        $user->save();
    }

    private function createAdmin($company, $adminRole, $employeeRole)
    {
        $users = factory(User::class)->times(1)->create([
            'name' => 'Admin',
            'email' => 'admin@codagetech.com',
            'company_id' => $company->id,
            'status' => 'active'
        ]);

        $users[0]->employeeDetail()->create([
            'employee_id' => 'EMP00' . $users[0]->id,
            'company_id' => $company->id,
            'address' => 'address',
            'hourly_rate' => rand(10, 50),
            'joining_date' => Carbon::now()->format('Y-m-d')
        ]);

        $users[0]->roles()->attach([$adminRole->id, $employeeRole->id]);
    }

    private function createEmployee($company, $employeeRole)
    {
        $users = factory(User::class)->times(1)->create([
            'name' => 'Employee',
            'email' => 'employee@codagetech.com',
            'company_id' => $company->id,
            'status' => 'active'
        ]);
        $users[0]->employeeDetail()->create([
            'employee_id' => 'EMP00' . $users[0]->id,
            'company_id' => $company->id,
            'address' => 'address',
            'hourly_rate' => rand(10, 50),
            'joining_date' => Carbon::now()->format('Y-m-d')
        ]);
        $users[0]->roles()->attach([$employeeRole->id]);
    }

    private function createClient($company, $clientRole)
    {
        $faker = \Faker\Factory::create();
        $users = factory(User::class)->times(1)->create([
            'name' => 'Client',
            'email' => 'client@codagetech.com',
            'company_id' => $company->id,
            'status' => 'active'
        ]);
        $users[0]->roles()->attach([$clientRole->id]);
        $this->createClientDetails($company, $users[0], $faker);
    }

    private function createClientDetails($company, $user, $faker)
    {
        $client = new \App\ClientDetails();
        $client->user_id = $user->id;
        $client->company_id = $company->id;
        $client->name = $faker->name;
        $client->email = $faker->email;
        $client->company_name = $faker->company;
        $client->address = $faker->address;
        $client->website = $faker->domainName;
        $client->save();
    }

    private function createDepartment($company)
    {
        $departments = [
            'مجلـس االدارة',
            'الـمـديــر التنفيــذي',
            'سكرتارية المدير التنفيذي',
            'ادارة العلاقات العامة',
            'الادارة المالية',
            'ادارة شئون العاملين',
            'الادارة القانونية',
            'ادارة شئون العضوية',
            'ادارة المشتريات',
            'اداره المخازن',
            'ادارة النشاط الرياضي',
            'الادارة الهندسية',
            'ادارة المكتبة والنشاط الثقافي ',
            'ادارة الرحلات',
            'دارة الاسعاف',
            'ادارة الامن',
            'ادارة الخدمات المعاونة',
            'االدارة الفنية',
            'الادارة الفنية لحمام السباحة',
            'ادارة الحدائق والمكافح'
        ];

        foreach ($departments as $department) {
            Team::create([
                'team_name' => $department,
                'company_id' => $company->id,
            ]);
        }
        return Team::get();
    }

    private function createDesignation($company)
    {

        $designations = [
            'رئيس  مجلس الادارة',
            'نائب رئيس مجلس الادارة',
            'امين صندوق',
            'مدير عام النادي',
            'عضو مجلس فوق السن',
            'عضو مجلس تحت السن', 
            'مدير ادارة السكرتارية',
            'موظف سكرتارية',
            'مدير ادارة العلاقات العامة',
            'موظف عالقات عامة', 
            'مراقب الحسابات',
            'المدير المالي',
            'مدير الحسابات',
            'مراجع الحسابات',
            'موظف الحسابات',
            'مدير ادارة شئون العاملين',
            'موظف شئون العاملين',
            'مدير الادارة القانونية',
            'موظف الادارة القانونية',
            'مدير الادارة شئون العضوية',
            'مراجع الادارة',
            'موظف الادارة',
            'مدير ادارة المشتريات',
            'موظف ادارة المشتريات', 
            'مدير ادارة المخازن',
            'موظف ادارة المخازن',
            'مدير النشاط الرياضي',
            'نائب مدير ادارة النشاط الرياضي',
            'مدير اداري نشاط رياضي',
            'اداري نشاط رياضي',
            'مدير حمام السباحة',
            'اداري حمام السباحة', 
            'مدير الادارة الهندسية',
            'مهندس الادارة الهندسية',
            'مدير الادارة',
            'نائب مدير الادارة',
            'موظف',
            'شرف الادارة',
            'موظف الادارة',
            'مدير ادارة الامن',
            'نائب مدير ادارة الامن',
            'مشرف عام الامن',
            'فرد امن',
            'مدير الخدمات المعاونة',
            'مشرف عام الخدمات المعاونة',
            'فرد خدمات معاونة',
            'مشرف الادارة الفنية',
            'فني الادارة الفنية',
            'مدير الادارة الفنية لحمام السباحة',
            'فني الادارة لحمام السباحة',
            'مدير ادارة الحدائق والمكافحة',
            'مهندس زراعي',
            'عامل زراعي'
        ];

        foreach ($designations as $designation) {
            Designation::create([
                'name' => $designation,
                'company_id' => $company->id,
            ]);
        }
        return Designation::get();
    }
}

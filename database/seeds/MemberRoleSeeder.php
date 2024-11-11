<?php

use Illuminate\Database\Seeder;

class MemberRoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'member',
                'display_name' => 'Member',
                'company_id' => '1',
                'description' => '',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'BoardMember',
                'display_name' => 'BoardMember',
                'company_id'=>'1',
                'description'=>'',

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        $memberModules = ['members', 'tickets', 'invoices', 'estimates', 'events', 'messages' , 'attendance' , 'notices' , 'payments' , 'leaves' , 'reports'];
        foreach($memberModules as $moduleSetting){
            $modulesMember = new \App\ModuleSetting();
            $modulesMember->module_name = $moduleSetting;
            $modulesMember->type = 'member';
            $modulesMember->company_id=1;
            $modulesMember->save();
        }
    }

}
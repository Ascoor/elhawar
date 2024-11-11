<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class AddModuleIdColumnPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('module_id')->unsigned()->after('description');
            $table->foreign('module_id')->references('id')->on('modules')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Permission::insert([


            ['name' => 'add_clients', 'display_name' => 'Add Clients', 'module_id' => 1],
            ['name' => 'view_clients', 'display_name' => 'View Clients', 'module_id' => 1],
            ['name' => 'edit_clients', 'display_name' => 'Edit Clients', 'module_id' => 1],
            ['name' => 'delete_clients', 'display_name' => 'Delete Clients', 'module_id' => 1],

            ['name' => 'add_employees', 'display_name' => 'Add Employees', 'module_id' => 2],
            ['name' => 'view_employees', 'display_name' => 'View Employees', 'module_id' => 2],
            ['name' => 'edit_employees', 'display_name' => 'Edit Employees', 'module_id' => 2],
            ['name' => 'delete_employees', 'display_name' => 'Delete Employees', 'module_id' => 2],

            ['name' => 'add_projects', 'display_name' => 'Add Project', 'module_id' => 3],
            ['name' => 'view_projects', 'display_name' => 'View Project', 'module_id' => 3],
            ['name' => 'edit_projects', 'display_name' => 'Edit Project', 'module_id' => 3],
            ['name' => 'delete_projects', 'display_name' => 'Delete Project', 'module_id' => 3],

            ['name' => 'add_attendance', 'display_name' => 'Add Attendance', 'module_id' => 4],
            ['name' => 'view_attendance', 'display_name' => 'View Attendance', 'module_id' => 4],

            ['name' => 'add_tasks', 'display_name' => 'Add Tasks', 'module_id' => 5],
            ['name' => 'view_tasks', 'display_name' => 'View Tasks', 'module_id' => 5],
            ['name' => 'edit_tasks', 'display_name' => 'Edit Tasks', 'module_id' => 5],
            ['name' => 'delete_tasks', 'display_name' => 'Delete Tasks', 'module_id' => 5],

            ['name' => 'add_estimates', 'display_name' => 'Add Estimates', 'module_id' => 6],
            ['name' => 'view_estimates', 'display_name' => 'View Estimates', 'module_id' => 6],
            ['name' => 'edit_estimates', 'display_name' => 'Edit Estimates', 'module_id' => 6],
            ['name' => 'delete_estimates', 'display_name' => 'Delete Estimates', 'module_id' => 6],

            ['name' => 'add_invoices', 'display_name' => 'Add Invoices', 'module_id' => 7],
            ['name' => 'view_invoices', 'display_name' => 'View Invoices', 'module_id' => 7],
            ['name' => 'edit_invoices', 'display_name' => 'Edit Invoices', 'module_id' => 7],
            ['name' => 'delete_invoices', 'display_name' => 'Delete Invoices', 'module_id' => 7],

            ['name' => 'add_payments', 'display_name' => 'Add Payments', 'module_id' => 8],
            ['name' => 'view_payments', 'display_name' => 'View Payments', 'module_id' => 8],
            ['name' => 'edit_payments', 'display_name' => 'Edit Payments', 'module_id' => 8],
            ['name' => 'delete_payments', 'display_name' => 'Delete Payments', 'module_id' => 8],

            ['name' => 'add_timelogs', 'display_name' => 'Add Timelogs', 'module_id' => 9],
            ['name' => 'view_timelogs', 'display_name' => 'View Timelogs', 'module_id' => 9],
            ['name' => 'edit_timelogs', 'display_name' => 'Edit Timelogs', 'module_id' => 9],
            ['name' => 'delete_timelogs', 'display_name' => 'Delete Timelogs', 'module_id' => 9],

            ['name' => 'add_tickets', 'display_name' => 'Add Tickets', 'module_id' => 10],
            ['name' => 'view_tickets', 'display_name' => 'View Tickets', 'module_id' => 10],
            ['name' => 'edit_tickets', 'display_name' => 'Edit Tickets', 'module_id' => 10],
            ['name' => 'delete_tickets', 'display_name' => 'Delete Tickets', 'module_id' => 10],

            ['name' => 'add_events', 'display_name' => 'Add Events', 'module_id' => 11],
            ['name' => 'view_events', 'display_name' => 'View Events', 'module_id' => 11],
            ['name' => 'edit_events', 'display_name' => 'Edit Events', 'module_id' => 11],
            ['name' => 'delete_events', 'display_name' => 'Delete Events', 'module_id' => 11],

            ['name' => 'add_notice', 'display_name' => 'Add Notice', 'module_id' => 12],
            ['name' => 'view_notice', 'display_name' => 'View Notice', 'module_id' => 12],
            ['name' => 'edit_notice', 'display_name' => 'Edit Notice', 'module_id' => 12],
            ['name' => 'delete_notice', 'display_name' => 'Delete Notice', 'module_id' => 12],

            ['name' => 'add_members', 'display_name' => 'Add Members', 'module_id' => 14],
            ['name' => 'view_members', 'display_name' => 'View Members', 'module_id' => 14],
            ['name' => 'edit_members', 'display_name' => 'Edit Members', 'module_id' => 14],
            ['name' => 'delete_members', 'display_name' => 'Delete Members', 'module_id' => 14],

            ['name' => 'add_sportAcademies', 'display_name' => 'Add Sport Academies', 'module_id' => 15],
            ['name' => 'view_sportAcademies', 'display_name' => 'View Sport Academies', 'module_id' => 15],
            ['name' => 'edit_sportAcademies', 'display_name' => 'Edit Sport Academies', 'module_id' => 15],
            ['name' => 'delete_sportAcademies', 'display_name' => 'Delete Sport Academies', 'module_id' => 15],

            ['name' => 'add_sportTeams', 'display_name' => 'Add Sport Teams', 'module_id' => 16],
            ['name' => 'view_sportTeams', 'display_name' => 'View Sport Teams', 'module_id' => 16],
            ['name' => 'edit_sportTeams', 'display_name' => 'Edit Sport Teams', 'module_id' => 16],
            ['name' => 'delete_sportTeams', 'display_name' => 'Delete Sport Teams', 'module_id' => 16],

            ['name' => 'add_players', 'display_name' => 'Add Players', 'module_id' => 17],
            ['name' => 'view_players', 'display_name' => 'View Players', 'module_id' => 17],
            ['name' => 'edit_players', 'display_name' => 'Edit Players', 'module_id' => 17],
            ['name' => 'delete_players', 'display_name' => 'Delete Players', 'module_id' => 17],

            ['name' => 'add_championships', 'display_name' => 'Add Championships', 'module_id' => 18],
            ['name' => 'view_championships', 'display_name' => 'View Championships', 'module_id' => 18],
            ['name' => 'edit_championships', 'display_name' => 'Edit Championships', 'module_id' => 18],
            ['name' => 'delete_championships', 'display_name' => 'Delete Championships', 'module_id' => 18],

            ['name' => 'add_trips', 'display_name' => 'Add Trips', 'module_id' => 19],
            ['name' => 'view_trips', 'display_name' => 'View Trips', 'module_id' => 19],
            ['name' => 'edit_trips', 'display_name' => 'Edit Trips', 'module_id' => 19],
            ['name' => 'delete_trips', 'display_name' => 'Delete Trips', 'module_id' => 19],

            ['name' => 'add_purchases', 'display_name' => 'Add Purchases', 'module_id' => 20],
            ['name' => 'view_purchases', 'display_name' => 'View Purchases', 'module_id' => 20],
            ['name' => 'edit_purchases', 'display_name' => 'Edit Purchases', 'module_id' => 20],
            ['name' => 'delete_purchases', 'display_name' => 'Delete Purchases', 'module_id' => 20],

            ['name' => 'add_inventories', 'display_name' => 'Add Inventories', 'module_id' => 21],
            ['name' => 'view_inventories', 'display_name' => 'View Inventories', 'module_id' => 21],
            ['name' => 'edit_inventories', 'display_name' => 'Edit Inventories', 'module_id' => 21],
            ['name' => 'delete_inventories', 'display_name' => 'Delete Inventories', 'module_id' => 21],

            ['name' => 'add_libraries', 'display_name' => 'Add Libraries', 'module_id' => 22],
            ['name' => 'view_libraries', 'display_name' => 'View Libraries', 'module_id' => 22],
            ['name' => 'edit_libraries', 'display_name' => 'Edit Libraries', 'module_id' => 22],
            ['name' => 'delete_libraries', 'display_name' => 'Delete Libraries', 'module_id' => 22],

            ['name' => 'add_archives', 'display_name' => 'Add Archives', 'module_id' => 23],
            ['name' => 'view_archives', 'display_name' => 'View Archives', 'module_id' => 23],
            ['name' => 'edit_archives', 'display_name' => 'Edit Archives', 'module_id' => 23],
            ['name' => 'delete_archives', 'display_name' => 'Delete Archives', 'module_id' => 23],

            ['name' => 'add_legalAffairs', 'display_name' => 'Add Legal Affairs', 'module_id' => 24],
            ['name' => 'view_legalAffairs', 'display_name' => 'View Legal Affairs', 'module_id' => 24],
            ['name' => 'edit_legalAffairs', 'display_name' => 'Edit Legal Affairs', 'module_id' => 24],
            ['name' => 'delete_legalAffairs', 'display_name' => 'Delete Legal Affairs', 'module_id' => 24],

            ['name' => 'add_leave', 'display_name' => 'Add Leave', 'module_id' => 25],
            ['name' => 'view_leave', 'display_name' => 'View Leave', 'module_id' => 25],
            ['name' => 'edit_leave', 'display_name' => 'Edit Leave', 'module_id' => 25],
            ['name' => 'delete_leave', 'display_name' => 'Delete Leave', 'module_id' => 25],

            ['name' => 'add_lead', 'display_name' => 'Add Lead', 'module_id' => 26],
            ['name' => 'view_lead', 'display_name' => 'View Lead', 'module_id' => 26],
            ['name' => 'edit_lead', 'display_name' => 'Edit Lead', 'module_id' => 26],
            ['name' => 'delete_lead', 'display_name' => 'Delete Lead', 'module_id' => 26],

            ['name' => 'add_holiday', 'display_name' => 'Add Holiday', 'module_id' => 27],
            ['name' => 'view_holiday', 'display_name' => 'View Holiday', 'module_id' => 27],
            ['name' => 'edit_holiday', 'display_name' => 'Edit Holiday', 'module_id' => 27],
            ['name' => 'delete_holiday', 'display_name' => 'Delete Holiday', 'module_id' => 27],

            ['name' => 'add_product', 'display_name' => 'Add Product', 'module_id' => 28],
            ['name' => 'view_product', 'display_name' => 'View Product', 'module_id' => 28],
            ['name' => 'edit_product', 'display_name' => 'Edit Product', 'module_id' => 28],
            ['name' => 'delete_product', 'display_name' => 'Delete Product', 'module_id' => 28],

            ['name' => 'add_expenses', 'display_name' => 'Add Expenses', 'module_id' => 29],
            ['name' => 'view_expenses', 'display_name' => 'View Expenses', 'module_id' => 29],
            ['name' => 'edit_expenses', 'display_name' => 'Edit Expenses', 'module_id' => 29],
            ['name' => 'delete_expenses', 'display_name' => 'Delete Expenses', 'module_id' => 29],

            ['name' => 'add_contract', 'display_name' => 'Add Contract', 'module_id' => 30],
            ['name' => 'view_contract', 'display_name' => 'View Contract', 'module_id' => 30],
            ['name' => 'edit_contract', 'display_name' => 'Edit Contract', 'module_id' => 30],
            ['name' => 'delete_contract', 'display_name' => 'Delete Contract', 'module_id' => 30],

            ['name' => 'add_accounting', 'display_name' => 'Add Accounting', 'module_id' => 31],
            ['name' => 'view_accounting', 'display_name' => 'View Accounting', 'module_id' => 31],
            ['name' => 'edit_accounting', 'display_name' => 'Edit Accounting', 'module_id' => 31],
            ['name' => 'delete_accounting', 'display_name' => 'Delete Accounting', 'module_id' => 31],




        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropColumn(['module_id']);
        });

        \Illuminate\Support\Facades\DB::table('permissions')->delete();
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1;');

    }
}

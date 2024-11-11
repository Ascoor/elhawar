<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TicketGroup;

class CreateTicketGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
            $table->timestamps();
        });

        $group = new TicketGroup();
        $group->group_name = 'مجلـس االدارة';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'الـمـديــر التنفيــذي';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'سكرتـارية المدير التنفيذي';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة العلاقات العامة';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'الادارة المالية';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة شئون العاملين';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'الادارة القانونية';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة شئون العضوية';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة المشتريات';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'اداره المخازن';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة النشاط الرياضي';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'الادارة الهندسية';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة المكتبة والنشاط الثقافي ';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة الرحلات';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'دارة الاسعاف';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة الامن';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة الخدمات المعاونة';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'االدارة الفنية';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'الادارة الفنية لحمام السباحة';
        $group->save();
        $group = new TicketGroup();
        $group->group_name = 'ادارة الحدائق والمكافح';
        $group->save();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_groups');
    }
}

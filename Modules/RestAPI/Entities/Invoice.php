<?php

namespace Modules\RestAPI\Entities;

use App\memberDetails;
use App\User;

class Invoice extends \App\Invoice
{
    // region Properties

    protected $table = 'invoices';

    protected $default = [
        'id',
        'invoice_number',
        'total',
        'status',
        'issue_date',
    ];


    protected $guarded = [
        'id',
    ];

    protected $filterable = [
        'id',
        'status',
        'invoice_number'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function visibleTo(\App\User $user)
    {
        if ($user->hasRole('admin') || ($user->hasRole('employee') || $user->cans('view_invoices')) || $user->hasRole('member') ) {
            return true;
        }
        return $this->client_id == $user->id;
    }

    public function scopeVisibility($query)
    {
        if (api_user()) {
            $user = api_user();

            if ($user->hasRole('admin')) {
                return $query;
            }elseif ($user->hasRole('member')){
                $member=memberDetails::where('user_id',$user->id)->first();
                $familyMembers=$member->family();
                $familyMembersIds=array();
                $i=0;
                foreach ($familyMembers as $familyMember){
                    $familyMembersIds[$i]=$familyMember->user_id;
                    $i++;
                }
                $query->whereIn('client_id' ,$familyMembersIds )->get();
            } else {
                // If employee or client show projects assigned
                $query->leftJoin('projects', 'invoices.project_id', '=', 'projects.id')
                    ->join('project_members', 'project_members.project_id', '=', 'projects.id')
                    ->where(function ($query) use ($user) {
                        $query->where('project_members.user_id', $user->id)
                              ->orWhere('invoices.client_id', $user->id);
                    });

                return $query;
            }
        }
        return $query;
    }
}

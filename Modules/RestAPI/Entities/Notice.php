<?php

namespace Modules\RestAPI\Entities;

class Notice extends \App\Notice
{
    // region Properties

    protected $table = 'notices';

    protected $hidden = [
        'updated_at'
    ];

    protected $default = [
        'id',
        'heading',
        'description',
        'attachment',
        'department_id',
    ];

    protected $filterable = [
        'id',
        'heading',
        'description',
        'attachment',
        'department_id',
    ];

    public function visibleTo(\App\User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        } elseif ($user->hasRole('client')) {
            return $this->to === 'client';
        } elseif ($user->hasRole('employee')) {
            return $this->to === 'employee';
        } elseif ($user->hasRole('member')) {
            return $this->to === 'member';
        }elseif($user==null){
            return $this->to === 'member';
        }

        return true;
    }

    public function scopeVisibility($query)
    {
        if (api_user()) {
            $user = api_user();

            if ($user->hasRole('admin')) {
                return $query;
            } elseif ($user->hasRole('client')) {
                $query->where('notices.to', 'client');
            }elseif ($user->hasRole('member')) {
                $query->where('notices.to', 'member');
            } elseif ($user->hasRole('employee')) {
                $query->where('notices.to', 'employee')
                    ->where('notices.department_id', $user->employee_details->department_id)
                    ->orWhereNull('notices.department_id');
            }elseif($user==null){
                $query->where('notices.to', 'member');
            }
        }
    }
}

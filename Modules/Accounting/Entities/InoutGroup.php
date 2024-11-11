<?php

namespace Modules\Accounting\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InoutGroup extends Model
{
    private const TYPES=['in','out'];
    private const TYPES_ENUM=['IN','OUT'];


    protected $fillable =[
        'title',
        'description',
        'type',
    ];

    public $appends = [
        'filesCount',
        'date',
        'excerpt',
     ];

    
    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }

    public function getExcerptAttribute()
    {
        return Str::words($this->description, 10,'...');

    }

    public function getDateAttribute()
    {
        return date('Y-m-d', strtotime($this->created_at));
    }


    public static function getRoutingTypeValidator()
    {
        return implode('|',InoutGroup::TYPES);
    }

    public static function getTypeEnum($type)
    {
        if(!in_array($type,InoutGroup::TYPES))
        {
            throw new Exception('Non Valid Type');
            die();
        }
        else
        {
            return InoutGroup::TYPES_ENUM[array_search($type,InoutGroup::TYPES)];
        }
    }

    public function files()
    {
        return $this->hasMany(InoutFile::class,'inout_group_id');
    } 
}

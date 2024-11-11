<?php

namespace Modules\Accounting\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;


class InoutFile extends Model
{
    //Allowed MIMES and default size in MBs
    const DEFAULT_ALLOWED_SIZE =10;
    const ALLOWED_MIMES=['doc','docx','pdf','xls','xlsx','png','jpg','jpeg','jiff','gif'];
    const STORAGE_PATH='inoutFiles';
    
    protected $fillable =[
        'original_name',
        'inout_group_id'
    ];

    /////////////-------------------///////////////////////////


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->name_on_disk=$model->randomizeOndiskPath();
        });

        static::updating(function ($model)
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.noteditable'));
        });

    }



    /////////////-------------------///////////////////////////

    public function group()
    {
        return $this->belongsTo(InoutGroup::class,'inout_group_id');
    }


    /////////////-------------------///////////////////////////
    
    /**
     * randomizeOndiskPath function
     * returns a Randomized unique path string for the file.
     * @return Mixed Randomized unique path string for the file.
     */
    private function randomizeOndiskPath()
    {
        $mime=substr(strtolower($this->original_name),strrpos($this->original_name,'.')+1);
        return $mime.'_'.date('YmdHis').'_'.rand(10,100).'.'.$mime;
    }

    /**
     * mimeValidator function
     * returns CS-list of allowed mimes
     * @return Mixed CS-list of allowed mimes
     */
    public static function mimeValidator()
    {
        return implode(',',InoutFile::ALLOWED_MIMES);
    }

    /**
     * htmlValidator function
     * returns CS-list of allowed mimes
     * @return Mixed CS-list of allowed mimes
     */
    public static function htmlValidator()
    {
        return '.'.implode(', .',InoutFile::ALLOWED_MIMES);
    }

    /**
     * sizeValidator function
     * returns Maximum allowed File size in Killobytes to be used in validators 
     * @return int Maximum allowed File size in Killobytes
     */
    public static function sizeValidator()
    {
        return InoutFile::DEFAULT_ALLOWED_SIZE * 1024;
    }
}

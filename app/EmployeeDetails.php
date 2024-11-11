<?php

namespace App;

use App\Observers\EmployeeDetailObserver;
use App\Scopes\CompanyScope;
use App\Traits\CustomFieldsTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media; // تأكد من استخدام الـ namespace الصحيح
use App\RentedArea;

class EmployeeDetails extends BaseModel implements HasMedia
{
    use HasMediaTrait, CustomFieldsTrait;

    protected $table = 'employee_details';
    protected $dates = ['joining_date', 'last_date'];

    protected static function boot()
    {
        parent::boot();
        static::observe(EmployeeDetailObserver::class);
        static::addGlobalScope(new CompanyScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Team::class, 'department_id');
    }

    public function sportsTeams()
    {
        return $this->belongsToMany(sportsTeams::class, 'teams_coaches', 'coach_id', 'team_id');
    }

    public function rentArea()
    {
        return $this->hasMany(AreaRent::class, 'employee_details_id', 'id');
    }

    // تعديل التوقيع ليتوافق مع الـ namespace الصحيح
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getDocumentAttribute()
    {
        $files = $this->getMedia('document');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }
}

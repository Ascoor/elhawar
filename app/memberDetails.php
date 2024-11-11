<?php

namespace App;

use App\Observers\ClientDetailObserver;
use App\Scopes\CompanyScope;
use App\Traits\CustomFieldsTrait;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Trebol\Entrust\Traits\EntrustUserTrait;


class memberDetails extends Model
{
    use Notifiable;
    use CustomFieldsTrait;

    protected $table = 'member_details';
    protected $fillable = [
        'id', 'national_id', 'name', 'user_id', 'category_id', 'relation_id', 'gender', 'phone', 'date_of_birth', 'email', 'address', 'email_notifications',
        'member_id' , 'family_id','country_id','city' , 'state','postal_code','status_id' ,'religion','profession','age','note','note_2',
        'face_book','twitter','player','team_id','renewal_status','nationality_id','mem_HomePhone','mem_WorkPhone',
        'note_4','note_3','memCard_MemberName','remarks','mem_GraduationDesc',

    ];
    // 'board_decision_number',

//    protected $default = [
//        'id',
//        'comrole_userpany_name',
//        'address',
//        'website',
//        'note',
//        'skype',
//        'facebook',
//        'twitter',
//        'linkedin',
//        'gst_number'
//    ];

    protected $appends = ['image_url'];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::observe(ClientDetailObserver::class);
//
//        static::addGlobalScope(new CompanyScope);
//    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset_url('avatar/' . $this->image) : asset('img/default-profile-3.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active', CompanyScope::class]);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function memberCategory()
    {
        return $this->belongsTo(memberCategory::class, 'category_id' , 'id');
    }
    public function memberRelation()
    {
        return $this->belongsTo(memberRelations::class, 'relation_id' , 'id');
    }
    public function memberStatus()
    {
        return $this->belongsTo(memberStatus::class, 'status_id' , 'id');
    }
    public function relatedMembers()
    {
        return $this->hasMany(memberDetails::class , 'family_id');
    }
    public function family(){
        $family=memberDetails::where('family_id' , $this->family_id)->get();
        return $family;
    }
    public function sportsTeams()
    {
        return $this->belongsTo(sportsTeams::class, 'team_id');
    }


}

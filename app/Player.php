<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';
    protected $fillable = [
        'id',
        'player_id',
        'union_id',
        'name',
        'national_id',
        'sports_id',
        'academy_id',
        'team_id',
        'gender',
        'date_of_birth',
        'age',
        'city',
        'country_id',
        'kind',
        'status_player',
        'date_status',
        'club_name',
        'champions_award',
        'address',
        'mobile',
        'guardian_mobile',
        'belt',
        'level',
        'stars',
        'weight',
        'height',
        'note',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['image_url'];
    
        public function getImageUrlAttribute()
        {
            return ($this->image) ? asset_url('avatar/' . $this->image) : asset('img/default-profile-3.png');
        }
    
        public function country()
        {
            return $this->hasOne(Country::class, 'id', 'country_id');
        }
    
        public function memberRelation()
    {
        return $this->belongsTo(memberRelations::class, 'relation_id' , 'id');
    }
       
        public function family(){
            $player=Player::where('player_id' , $this->player_id)->get();
            return $player;
        }
        public function sports()
        {
            return $this->belongsTo(sports::class, 'sports_id');
        }

        public function sportsAcademy()
        {
            return $this->belongsTo(SportAcademy::class, 'team_id');
        }

    
}

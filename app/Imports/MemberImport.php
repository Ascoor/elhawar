<?php

namespace App\Imports;

use App\memberDetails;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MemberImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new memberDetails([
            'name' => $row['name'],
            'email' => $row['email'],
            //            'user_id'=>$row['user_id'],
            'member_id' => $row['member_id'],
            'family_id' => $row['family_id'],
            'gender' => $row['gender'],
            'country_id' => $row['country_id'],
            'email_notifications' => $row['email_notifications'],

            'date_of_birth' => $row['date_of_birth'],
            'phone' => $row['phone'],
            'city' => $row['city'],
            'state' => $row['state'],
            'postal_code' => $row['postal_code'],
            'category_id' => $row['category_id'],
            'relation_id' => $row['relation_id'],
            'status_id' => $row['status_id'],
            'religion' => $row['religion'],
            'profession' => $row['profession'],
            'age' => $row['age'],
            'national_id' => $row['national_id'],
            'address' => $row['address'],
            'note' => $row['note'],
            // 'facebook' => $row['facebook'],
            // 'twitter' => $row['twitter'],
            'player' => $row['player'],
            'team_id' => $row['team_id'],
            'renewal_status' => $row['renewal_status'],
            'nationality_id' => $row['nationality_id'],

        ]);
    }
}
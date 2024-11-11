<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array '' => $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new User([
            'id' => $row['Id'],
            'name' => $row['Name'],
            'family_id' => $row['Family Id'],
            'category' => $row['Category'],
            'relation' => $row['Relation'],
            'city' => $row['City'],
            'state' => $row['State'],
            'address' => $row['Address'],
            'profession' => $row['Profession'],
            'status' => $row['Status'],
            'excluded_categories' => $row['Excluded Categories'],
            'email' => $row['Email'],
            'phone' => $row['Phone'],
            'created_at' => $row['Created At'],
            'decision_number' => $row['App Decision Number'],
            'national_id' => $row['National Id'],
            'age' => $row['Age'],
            'religion' => $row['Religion'],
            'country_id' => $row['Country Id'],
            'renewal_status' => $row['Renewal Status'],
            'postal_code' => $row['Postal Code'] ?? '00000',
            'face_book' => $row['Facebook'],
            'twitter' => $row['Twitter'],
            'excluded_categories_id' => $row['Excluded Categories Id'],
            'date_of_subscription' => $row['Date Of Subscription'],
            'mem_HomePhone' => $row['Home Phone'],
            'mem_WorkPhone' => $row['Work Phone'],
            'memCard_MemberName' => $row['Member Card Name'],
            'mem_GraduationDesc' => $row['Member Graduation Description'],
            'remarks' => $row['Remarks'],
            'note_2' => $row['Note 2'],
            'note_3' => $row['Note 3'],
            'note_4' => $row['Note 4']
        ]);

        /*return new User([
        'name' => $row['name'],
        'email' => $row['email'],
        'password' => Hash::make($row['password']),
        'locale' => $row['locale'],
        'gender' => $row['gender'],
        'country_id' => $row['country_id'],
        'email_notifications' => $row['email_notifications'],
        'mobile' => $row['phone'],

    ]);*/
    }
}
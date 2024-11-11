<?php

use Illuminate\Database\Seeder;

class FrontFeatureSeeder extends Seeder
{

    public function run()
    {

        // Team Management Section
        $feature = new \App\Feature();
        $feature->title = 'Sports Facilities';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">We hire the best ever coaches to deliver the best for our members.</span>';
        $feature->icon = 'fas fa-desktop';
        $feature->type = 'task';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Professional Coaches';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Keep a track of all your kids\' progress in a simple way.</span>';
        $feature->icon = 'fas fa-users';
        $feature->type = 'task';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Playgrounds';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Feel like home and let you your kids play safely.</span>';
        $feature->icon = 'fas fa-list';
        $feature->type = 'task';
        $feature->save();

        // Bills Section
        $feature = new \App\Feature();
        $feature->title = 'Track Records';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;"> Stay on top of the track record of your kids progress.</span>';
        $feature->icon = 'fas fa-calculator';
        $feature->type = 'bills';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Membership Renewal';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Simple and professional invoices can be downloaded in form of PDF.</span>';
        $feature->icon = 'far fa-file-alt';
        $feature->type = 'bills';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Sports Subscription';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Track payments done by you in the payment section.</span>';
        $feature->icon = 'fas fa-money-bill-alt';
        $feature->type = 'bills';
        $feature->save();

        // Teamates Section
        $feature = new \App\Feature();
        $feature->title = 'Events and Trips';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">When someone is facing a problem, they can raise a ticket for their problems. Admin can assign the tickets to respective department agents.</span>';
        $feature->icon = 'fas fa-ticket-alt';
        $feature->type = 'team';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Track Attendance';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Employees can apply for the multiple leaves from their panel. Admin can approve or reject the leave applications.</span>';
        $feature->icon = 'fas fa-ban';
        $feature->type = 'team';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Championships';
        $feature->description = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;">Attendance module allows employees to clock-in and clock-out, right from their dashboard. Admin can track the attendance of the team.</span>';
        $feature->icon = 'far fa-check-circle';
        $feature->type = 'team';
        $feature->save();


        // Application Section

        $feature = new \App\Feature();
        $feature->title = 'OneSignal';
        $feature->type = 'apps';
        $feature->save();


        $feature = new \App\Feature();
        $feature->title = 'Slack';
        $feature->type = 'apps';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Fawry Pay';
        $feature->type = 'apps';
        $feature->save();

        // Front Client
        $client = new \App\FrontClients();
        $client->title = 'Client 1';
        $client->save();

        $client = new \App\FrontClients();
        $client->title = 'Client 2';
        $client->save();

        $client = new \App\FrontClients();
        $client->title = 'Client 3';
        $client->save();

        $client = new \App\FrontClients();
        $client->title = 'Client 4';
        $client->save();

        // Testimonial
        $client = new \App\Testimonials();
        $client->name    = 'Saad Mohamed';
        $client->comment = 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.
                            Aenean amet socada commodo sit.';
        $client->rating = 5;
        $client->save();

        $client = new \App\Testimonials();
        $client->name    = 'Ahmed Ali';
        $client->comment = 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.
                            Aenean amet socada commodo sit.';
        $client->rating = 4;
        $client->save();

        $client = new \App\Testimonials();
        $client->name    = 'Nada Ahmed';
        $client->comment = 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.
                            Aenean amet socada commodo sit.';
        $client->rating = 3;
        $client->save();

        $client = new \App\Testimonials();
        $client->name    = 'Ghada Momtaz';
        $client->comment = 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.
                            Aenean amet socada commodo sit.';
        $client->rating = 4;
        $client->save();

        $client = new \App\Testimonials();
        $client->name    = 'Rasha Akram';
        $client->comment = 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.
                            Aenean amet socada commodo sit.';
        $client->rating = 2;
        $client->save();

        //Front FAQ
        $client = new \App\FrontFaq();
        $client->question    = 'How I can register?';
        $client->answer = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px;">Yes, definitely. We would be happy to demonstrate you CODAGETECH through a web conference at your convenience. Please submit a query on our contact us page or drop a mail to our mail id info@codagetech.com.</span>';
        $client->save();

        $client = new \App\FrontFaq();
        $client->question    = 'How can i update app?';
        $client->answer = '<span style="color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px;">Yes, definitely. We would be happy to demonstrate you CODAGETECH through a web conference at your convenience. Please submit a query on our contact us page or drop a mail to our mail id info@codagetech.com.</span>';
        $client->save();



        $frontDetail = \App\TrFrontDetail::first();
        $features = \App\Feature::all();

        $allTaskFeature = $features->filter(function ($value, $key) {
            return $value->type == 'task';
        });

        $allBillsFeature = $features->filter(function ($value, $key) {
            return $value->type == 'bills';
        });

        $allTeamatesFeature = $features->filter(function ($value, $key) {
            return $value->type == 'team';
        });

        if($frontDetail)
        {
            $frontFeature = new \App\FrontFeature();
            $frontFeature->title = $frontDetail->task_management_title;
            $frontFeature->description = $frontDetail->task_management_detail;
            $frontFeature->language_setting_id = $frontDetail->language_setting_id;
            $frontFeature->save();

            foreach($allTaskFeature as $taskFeature){
                $taskFeature->front_feature_id = $frontFeature->id;
                $taskFeature->save();;
            }

            $frontFeature = new \App\FrontFeature();
            $frontFeature->title = $frontDetail->manage_bills_title;
            $frontFeature->description = $frontDetail->manage_bills_detail;
            $frontFeature->language_setting_id = $frontDetail->language_setting_id;
            $frontFeature->save();

            foreach($allBillsFeature as $billFeature){
                $billFeature->front_feature_id = $frontFeature->id;
                $billFeature->save();
            }

            $frontFeature = new \App\FrontFeature();
            $frontFeature->title = $frontDetail->teamates_title;
            $frontFeature->description = $frontDetail->teamates_detail;
            $frontFeature->language_setting_id = $frontDetail->language_setting_id;
            $frontFeature->save();

            foreach($allTeamatesFeature as $teamatesFeature){
                $teamatesFeature->front_feature_id = $frontFeature->id;
                $teamatesFeature->save();
            }
        }
    }
}

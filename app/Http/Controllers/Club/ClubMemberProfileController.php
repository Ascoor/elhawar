<?php

namespace App\Http\Controllers\Club;

use App\ClientDetails;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\User\UpdateProfile;
use App\memberDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClubMemberProfileController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = "app.menu.profileSettings";
        $this->pageIcon = 'icon-user';
    }
    public function index()
    {
        $this->userDetail = auth()->user();
        $this->membertDetail = memberDetails::where('user_id', '=', $this->userDetail->id)->first();
        return view('club.profile.edit', $this->data);
    }
    public function update(UpdateProfile $request, $id)
    {
        config(['filesystems.default' => 'local']);

        $user = User::withoutGlobalScope('active')->findOrFail($id);

        if ($request->password != '') {
            $user->password = Hash::make($request->input('password'));
        }
        $user->email = $request->email;
        $newName = null;

        if ($request->hasFile('image')) {
            Files::deleteFile($user->image, 'avatar');
            $newName = Files::upload($request->image, 'avatar', 300);
            $user->image = $newName;
        }
        $user->email_notifications = $request->email_notifications;

        $user->name = $request->name;
        $user->mobile = $request->mobile;

        $user->save();

        $validate = Validator::make(['address' => $request->address], [
            'address' => 'required'
        ]);

        if ($validate->fails()) {
            return Reply::formErrors($validate);
        }

        $member = memberDetails::where('user_id', $user->id)->first();



        $member->address = $request->address;
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->mobile;


        $member->save();
        session()->forget('user');

        return Reply::redirect(route('club.profile.index'), __("messages.profileUpdated"));
    }

    public function changeLanguage(Request $request)
    {
        $setting = User::findOrFail($this->user->id);
        $setting->locale = $request->input('lang');
        $setting->save();
        session()->forget('user');
        return Reply::success('Language changed successfully.');
    }
}
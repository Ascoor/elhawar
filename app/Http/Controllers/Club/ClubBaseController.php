<?php

namespace App\Http\Controllers\Club;

use App\ClientDetails;
use App\Company;
use App\GdprSetting;
use App\GlobalSetting;
use App\Http\Controllers\Controller;
use App\InvoiceSetting;
use App\LanguageSetting;
use App\MessageSetting;
use App\Notification;
use App\ProjectActivity;
use App\Scopes\CompanyScope;
use App\StickyNote;
use App\ThemeSetting;
use App\Traits\FileSystemSettingTrait;
use App\User;
use App\UserActivity;
use App\UserChat;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
class ClubBaseController extends Controller
{

    use FileSystemSettingTrait;
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        // Inject currently logged in user object into every view of user dashboard

        $this->clientTheme = ThemeSetting::where('panel', 'client')->first();
        $this->languageSettings = LanguageSetting::where('status', 'enabled')->get();

        $this->middleware(function ($request, $next) {

            $this->global = $this->company = company_setting();
            $this->invoiceSetting = invoice_setting();
            $this->superadmin = global_settings();

            $this->pushSetting = push_setting();
            $this->companyName = $this->global->company_name;

            $this->adminTheme = admin_theme();
            $this->languageSettings = language_setting();

            App::setLocale($this->global->locale);
            Carbon::setLocale($this->global->locale);
            setlocale(LC_TIME, $this->global->locale . '_' . strtoupper($this->global->locale));
            $this->setFileSystemConfigs();


            $this->isClient = User::withoutGlobalScope(CompanyScope::class)
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.id', 'users.name', 'users.email', 'users.created_at')
                ->where('roles.name', 'client')
                ->where('role_user.user_id', user()->id)
                ->where('users.company_id', user()->company_id)
                ->first();

            $this->user = user();
            $this->unreadNotificationCount = count($this->user->unreadNotifications);

            // For GDPR
            try {
                $this->gdpr = GdprSetting::first();

                if (!$this->gdpr) {
                    $gdpr = new GdprSetting();
                    $gdpr->company_id = Auth::user()->company_id;
                    $gdpr->save();

                    $this->gdpr = $gdpr;
                }
            } catch (\Exception $e) {
            }

            $company = $this->global;
            $expireOn = $company->licence_expire_on;
            $currentDate = Carbon::now();

            $packageSettingData = package_setting();
            $this->packageSetting = ($packageSettingData->status == 'active') ? $packageSettingData : null;

            if ((!is_null($expireOn) && $expireOn->lessThan($currentDate))) {

                $this->checkLicense($company);
            }

            $this->modules = $this->user->modules;
//            $this->unreadInvoiceCount = Notification::where('notifiable_id', $this->user->id)
//                ->where('type', 'App\Notifications\NewInvoice')
//                ->whereNull('read_at')
//                ->count();
//            $this->unreadCreditNoteCount = Notification::where('notifiable_id', $this->user->id)
//                ->where('type', 'App\Notifications\NewCreditNote')
//                ->whereNull('read_at')
//                ->count();
            $this->unreadMessageCount = UserChat::where('to', $this->user->id)->where('message_seen', 'no')->count();
            $this->unreadTicketCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewTicket')
                ->whereNull('read_at')
                ->count();

            $this->unreadExpenseCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewExpenseAdmin')
                ->whereNull('read_at')
                ->count();

            $this->stickyNotes = StickyNote::where('user_id', $this->user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
            $this->rtl = $this->global->rtl;
            $this->worksuitePlugins = worksuite_plugins();

            if (config('filesystems.default') == 's3') {
                $this->url = "https://" . config('filesystems.disks.s3.bucket') . ".s3.amazonaws.com/";
            }

            $this->company_details = ClientDetails::withoutGlobalScope(CompanyScope::class)
                ->select('id', 'user_id', 'company_id')
                ->with('company:id,company_name')
                ->where('user_id', Auth::user()->id)
                ->get();

            $this->isAdmin = User::withoutGlobalScope(CompanyScope::class)
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.id', 'users.name', 'users.email', 'users.created_at')
                ->where('roles.name', 'admin')
                ->where('role_user.user_id', user()->id)
                ->where('users.company_id', user()->company_id)
                ->first();

            $this->global = Company::withoutGlobalScope('active')->where('id', company()->id)->first();
            $this->companyName = $this->global->company_name;
            $this->clientTheme = ThemeSetting::where('panel', 'client')->first();
            $this->messageSetting = MessageSetting::first();
            $this->languageSettings = LanguageSetting::where('status', 'enabled')->get();
            App::setLocale($this->global->locale);
            Carbon::setLocale($this->global->locale);
            $this->setFileSystemConfigs();
            $this->superadmin = GlobalSetting::with('currency')->first();
            $this->user = auth()->user();
            $this->modules = $this->user->modules;
            $this->invoiceSetting = InvoiceSetting::first();
            // For GDPR
            try {
                $this->gdpr = GdprSetting::first();

                if (!$this->gdpr) {
                    $gdpr = new GdprSetting();
                    $gdpr->company_id = company()->id;
                    $gdpr->save();

                    $this->gdpr = $gdpr;
                }
            } catch (\Exception $e) {
            }

            $this->unreadNotificationCount = count($this->user->unreadNotifications);
            $this->rtl = $this->global->rtl;

            $this->unreadProjectCount = Notification::where('notifiable_id', $this->user->id)
                ->where(function ($query) {
                    $query->where('type', 'App\Notifications\TimerStarted');
                    $query->orWhere('type', 'App\Notifications\NewProjectMember');
                })
                ->whereNull('read_at')
                ->count();
            $this->unreadInvoiceCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewInvoice')
                ->whereNull('read_at')
                ->count();
            $this->unreadPaymentCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewPayment')
                ->whereNull('read_at')
                ->count();
            $this->unreadEstimateCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewEstimate')
                ->whereNull('read_at')
                ->count();

            $this->unreadCreditNoteCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewCreditNote')
                ->whereNull('read_at')
                ->count();

            $this->stickyNotes = StickyNote::where('user_id', $this->user->id)->orderBy('updated_at', 'desc')->get();

            $this->unreadMessageCount = UserChat::where('to', $this->user->id)->where('message_seen', 'no')->count();

            App::setLocale($this->user->locale);
            Carbon::setLocale($this->user->locale);
            setlocale(LC_TIME, $this->user->locale . '_' . strtoupper($this->user->locale));

            if (config('filesystems.default') == 's3') {
                $this->url = "https://" . config('filesystems.disks.s3.bucket') . ".s3.amazonaws.com/";
            }

            $this->worksuitePlugins = worksuite_plugins();

            return $next($request);
        });
    }

    public function logProjectActivity($projectId, $text)
    {
        $activity = new ProjectActivity();
        $activity->project_id = $projectId;
        $activity->activity = $text;
        $activity->save();
    }

    public function logUserActivity($userId, $text)
    {
        $activity = new UserActivity();
        $activity->user_id = $userId;
        $activity->activity = $text;
        $activity->save();
    }
}
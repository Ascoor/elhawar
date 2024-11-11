<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\DataTables\Admin\FamilyDatatTable;
use App\DataTables\Admin\CasesDataTable;
use App\DataTables\Admin\RenewMembershipDataTable;
use App\DataTables\Admin\MemberDataTable;
use App\DataTables\Admin\MembersInvoicesDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\DataTables\Admin\SportSessionDataTable;
use App\DataTables\Admin\ViewMemberDataTable;
use App\ExcludedCategory;
use App\Http\Requests\Admin\member\StoreMembertRequest;
use App\Http\Requests\Admin\member\UpdateMemberRequest;
use App\Http\Requests\Invoices\StoreRecurringInvoice;
use App\Imports\MemberImport;
use App\Imports\UsersImport;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\memberDetails;
use App\Country;
use App\DataTables\Admin\ClientsDataTable;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Http\Requests\Gdpr\SaveConsentUserDataRequest;
use App\Invoice;
use App\Lead;
use App\Helper\Files;
use App\memberRelations;
use App\MembershipRenewSetting;
use App\memberStatus;
use App\Notifications\NewUser;
use App\Payment;
use App\Penalties;
use App\Product;
use App\PurposeConsent;
use App\PurposeConsentUser;
use App\RecurringInvoice;
use App\RecurringInvoiceItems;
use App\Role;
use App\Scopes\CompanyScope;
use App\sportsTeams;
use App\Tax;
use App\UniversalSearch;
use App\User;
use App\Project;
use App\Contract;
use App\Notes;
use App\ContractType;
use App\memberCategory;
use App\ClientSubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ManageMembersController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.members';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules), 403);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MemberDataTable $dataTable)
    {
        abort_if(!$this->user->cans('view_members'), 403);
        $this->members = User::allMembers();
        $this->status = MemberStatus::all();
        $this->totalmembers = count($this->members);
        $this->categories = memberCategory::all();
        $this->projects = Project::all();
        $this->contracts = ContractType::all();
        $this->countries = Country::all();
        $this->subcategories = ClientSubCategory::all();
        $this->excluded_categories = ExcludedCategory::all(); /////////////
        return $dataTable->render('admin.members.index', $this->data);
    }
    public function dashboardIndex(MemberDataTable $dataTable, $par)
    {
        abort_if(!$this->user->cans('view_members'), 403);
        $this->par = $par;
        $this->members = User::allMembers();
        $this->totalmembers = '-';
        $this->status = MemberStatus::all();

        //mohamed elshimy
        $this->members = memberDetails::all();

        $this->categories = memberCategory::all();
        $this->excluded_categories = ExcludedCategory::all();
        $this->projects = Project::all();
        $this->contracts = ContractType::all();
        $this->countries = Country::all();
        $this->subcategories = ClientSubCategory::all();
        return $dataTable->render('admin.members.index', $this->data);
    }
    public function FamilyIndex(FamilyDatatTable $dataTable)
    {
        abort_if(!$this->user->cans('view_members'), 403);

        $this->members = memberDetails::where('category_id', 1)->get();
        $this->totalmembers = count($this->members);
        $this->categories = memberCategory::all();
        $this->projects = Project::all();
        $this->contracts = ContractType::all();
        $this->countries = Country::all();
        $this->subcategories = ClientSubCategory::all();
        return $dataTable->render('admin.members.family_index', $this->data);
    }

    public function add_to_family()
    {
        abort_if(!$this->user->cans('add_members'), 403);

        $this->families = memberDetails::where('category_id', '1')->get();
        $this->totalmembers = count($this->families);
        return view('admin.members.enter_family_id', $this->data);
    }

    public function createToFamily($id)
    {
        abort_if(!$this->user->cans('add_members'), 403);

        $existing_family_count = memberDetails::select('family_id')
            ->where(
                [
                    'family_id' => $id
                ]
            )->count();
        if ($existing_family_count == 0) {
            return Reply::error('Provided family doesn\'t exist. Try adding different family id.');
        } else {
            $this->member_id = memberDetails::where('category_id', 1)->where('family_id', $id)->first()->member_id . '-' . $existing_family_count;
            $this->categories = memberCategory::where('id', '!=', '1')->where('id', '!=', '3')->get();
            $this->relations = memberRelations::where('id', '!=', '1')->get();
            $this->status = memberStatus::all();
            $this->countries = Country::all();
            $this->family_id = $id;
            $this->excluded_categories = ExcludedCategory::all();

            return view('admin.members.create', $this->data);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ------if 403 appeared -----//
        abort_if(!$this->user->cans('add_members'), 403);

        $this->member_id = null;
        if (memberDetails::latest()->first()) {
            $this->family_id = memberDetails::max('family_id') + 1;
        } else {
            $this->family_id = 1;
        }

        $this->categories = memberCategory::where('id', 1)->Orwhere('id', 3)->Orwhere('id', 4)->Orwhere('id', 5)->Orwhere('id', 6)->Orwhere('id', 7)->get();
        $this->relations = memberRelations::where('id', '1')->get();
        //           $this->relations = memberRelations::all();
        $this->status = memberStatus::all();
        $this->countries = Country::all();
        $this->excluded_categories = ExcludedCategory::all();

        return view('admin.members.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function store(StoreMembertRequest $request)
    {
        //  403 frobbiden error
        abort_if(!$this->user->cans('add_members'), 403);

        $existing_family_count = memberDetails::select('family_id')
            ->where(
                [
                    'family_id' => $request->input('family_id')
                ]
            )->count();
            
        if ($existing_family_count != 0 && $request->input('category_id') == 1) {
            return Reply::error('Provided family is already exist. Try adding different family id.');
        }
        $existing_user = User::select('id', 'email')->where('email', $request->input('email'))->first();
        $new_code = Country::select('phonecode')->where('id', $request->phone_code)->first();
        // if no user found create new user with random password

        if (!$existing_user) {
            // $password = str_random(8);
            // create new user
            $user = new User();
            $user->name = $request->input('name'); ///member_name
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->mobile = ($new_code != null) ? $new_code->phonecode . ' ' . $request->input('mobile') : '';
            $user->country_id = $request->input('phone_code');

            if ($request->hasFile('image')) {
                $user->image = Files::upload($request->image, 'avatar', 300);
            }
            if ($request->has('lead')) {
                $user->country_id = $request->input('country_id');
            }
            if ($request->input('locale') != '') {
                $user->locale = $request->input('locale');
            } else {
                $user->locale = company()->locale;

            }
            $user->save();

            // attach role
            $role = Role::where('name', 'member')->first();
            $user->attachRole($role->id);

            if ($request->has('lead')) {
                $lead = Lead::findOrFail($request->lead);
                $lead->member_id = $user->id;
                $lead->save();
            }
        } else {
            return Reply::error('Provided email is already registered. Try with different email.');
        }
        $existing_member_count = memberDetails::select('id', 'email')
            ->where(
                [
                    'email' => $request->input('email')
                ]
            )->orWhere([
                    'id' => $request->input('id')
                ])->count();
        //
        // auto increment WA INSERT
        if ($existing_member_count === 0) {
            $member = new memberDetails();
            $member->user_id = $user->id;
            $member->member_id = $request->input('member_id');
            $member->family_id = $request->input('family_id');
            $member->name = $request->salutation . " " . $request->input('name');
            $member->email = $request->input('email');
            $member->gender = $request->input('gender');
            $birth = $request->input('date_of_birth');
            $formatted_birth = Carbon::parse($birth)->format('Y-m-d');
            $member->date_of_birth = $formatted_birth;
            $subscribe = $request->input('date_of_subscription');
            $formatted_birth = Carbon::parse($subscribe)->format('Y-m-d');
            $member->date_of_subscription = $formatted_birth;
            $member->phone = ($new_code != null) ? $new_code->phonecode . ' ' . $request->input('mobile') : ' ';
            $member->country_id = $request->input('country_id');
            $member->nationality_id = $request->input('nationality_id');
            $member->excluded_categories_id = $request->excluded_categories_id;
            $member->city = $request->input('city');
            $member->state = $request->input('state');
            $member->postal_code = $request->input('postal_code');
            $member->category_id = $request->input('category_id');
            $member->relation_id = $request->input('relation_id');
            $member->status_id = $request->input('status_id');
            $member->religion = $request->input('religion');
            $member->profession = $request->input('profession');
            $member->age = $request->input('age');
            $member->national_id = $request->input('national_id');

            //            $member->sub_category_id = ($request->input('sub_category_id') != 0 && $request->input('sub_category_id') != '') ? $request->input('sub_category_id') : null ;

            $member->address = $request->input('address');
            $member->note = $request->input('note');
            $member->note_2 = $request->input('note_2');
            $member->last_paid_fiscal_year = $request->input('last_paid_fiscal_year');
            $member->date_of_the_board_of_directors = $request->input('date_of_the_board_of_directors');
            $member->decision_number = $request->input('decision_number');
            $member->face_book = $request->input('facebook');
            $member->twitter = $request->input('twitter');

            //   Mohmmed  & Rola 
            // ADDING NEW COLUMS IN THE DATABASE FOR MEMBER_DETIALS  MEMBERDETIALS 
            $member->mem_GraduationDesc = $request->input('mem_GraduationDesc');
            $member->mem_HomePhone = $request->input('mem_HomePhone');
            $member->mem_WorkPhone = $request->input('mem_WorkPhone');
            $member->note_4 = $request->input('note_4');
            $member->note_3 = $request->input('note_3');
            $member->memCard_MemberName = $request->input('memCard_MemberName');
            $member->remarks = $request->remarks;

            if ($request->player == 1) {
                $member->player = $request->player;
                $member->team_id = $request->team_id;
                $member->injuries_effect = $request->injuries_effect;
                $member->physical_assessment = $request->physical_assess;
                $member->skills_assessment = $request->skills_assess;
                $member->injuries = $request->injuries;
            }
            if ($request->has('email_notifications')) {
                $member->email_notifications = $request->email_notifications;
            }

            $member->save();
            // attach role
            if ($existing_user) {
                $role = Role::where('name', 'member')->first();
                $user->attachRole($role->id);
            }

        } else {
            return Reply::error('Provided member id is already registered. Try with different id.');

        }


        if ($request->sendMail == 'yes') {
            //send welcome email notification
            $user->notify(new NewUser($password));
        }
        if ($request->date_of_last_payment) {
            $last_payement_date = Carbon::parse($request->date_of_last_payment)->year;
        } else {
            $last_payement_date = Carbon::now()->year + 1;
        }
        $this->createRecurringRenewMembershipAuto($user->id, $request->input('category_id'), $last_payement_date);

        if ($request->has('ajax_create')) {
            $teams = User::allMembers();
            $teamData = '';

            foreach ($teams as $team) {
                $teamData .= '<option value="' . $team->id . '"> ' . ucwords($team->name) . ' </option>';
            }
            return Reply::successWithData(__('messages.memberAdded'), ['teamData' => $teamData]);
        }

        return Reply::redirect(route('admin.members.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ViewMemberDataTable $dataTable)
    {
        abort_if(!$this->user->cans('view_members'), 403);

        $this->member = memberDetails::find($id);
        $this->members = $this->member->family();
        $this->memberUser = User::where('id', $this->member->user_id)->first();
        $this->categories = memberCategory::where('id', $this->member->category_id)->first();
        $this->relations = memberRelations::where('id', $this->member->relation_id)->first();
        $this->excluded_categories = ExcludedCategory::where('id', $this->member->excluded_categories_id)->first();
        $this->status = memberStatus::where('id', $this->member->status_id)->first();
        return $dataTable->render('admin.members.show', $this->data);
        return view('admin.members.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(!$this->user->cans('edit_members'), 403);

        //        $this->userDetail = memberDetails::join('users', 'member_details.user_id', '=', 'users.id')
//            ->where('member_details.id', $id)
//            ->select('member_details.id', 'member_details.name', 'member_details.email', 'member_details.user_id', 'member_details.phone', 'users.locale', 'users.status', 'users.login')
//            ->first();


        $this->memberDetail = memberDetails::where('id', '=', $id)->first();
        $this->userDetail = User::withoutGlobalScope('active')->findOrFail($this->memberDetail->user_id);

        if ($this->memberDetail->category_id == 1) {
            $this->relations = memberRelations::where('id', '1')->get();
            $this->status = memberStatus::all();
            $this->family_edit = true;
            $this->categories = memberCategory::where('id', '=', 1)->get();
        } elseif ($this->memberDetail->category_id == 3) {
            $this->relations = memberRelations::where('id', '1')->get();
            $this->status = memberStatus::all();
            $this->family_edit = true;
            $this->categories = memberCategory::where('id', '=', 3)->get();
        } else {
            $this->relations = memberRelations::where('id', '!=', '1')->get();
            $this->status = memberStatus::all();
            $this->family_edit = false;
            $this->categories = memberCategory::where('id', '!=', 1)->get();
        }

        //        if (!is_null($this->memberDetail)) {
//            $this->memberDetail = $this->memberDetail->withCustomFields();
//            $this->fields = $this->memberDetail->getCustomFieldGroupsWithFields()->fields;
//        }
        $this->countries = Country::all();
        $this->teams = sportsTeams::all();
        $this->excluded_categories = ExcludedCategory::all();

        //        $this->subcategories = ClientSubCategory::all();

        return view('admin.members.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $member = memberDetails::find($id);
        $user = User::where('id', $member->user_id)->first();
        if ($member->category_id == 1) {
            $family_members = $member->family();
            foreach ($family_members as $family_member) {
                $family_member->family_id = $request->input('family_id');
                $family_member->status_id = $request->input('status_id');
                $family_user = User::where('id', $family_member->user_id)->first();
                if ($request->input('status_id') != 1) {
                    $family_user->login = 'disable';
                    $family_user->status = 'deactive';

                } else {
                    $family_user->status = 'active';
                    $family_user->login = 'enable';

                }
                $family_member->save();
                $family_user->save();
            }
        }
        if ($request->input('status_id') != 1) {
            $user->login = 'disable';
            $user->status = 'deactive';

        } else {
            $user->status = 'active';
            $user->login = 'enable';

        }
        $member->name = $request->input('name');
        $member->family_id = $request->input('family_id');
        $member->email = $request->input('email');
        $member->phone = $request->input('mobile');
        $member->country_id = $request->input('country_id');
        $member->nationality_id = $request->input('nationality_id');
        $member->address = $request->address;
        $member->city = $request->input('city');
        $member->state = $request->input('state');
        $member->postal_code = $request->input('postal_code');
        $member->category_id = $request->input('category_id');
        $member->status_id = $request->input('status_id');
        $member->relation_id = $request->input('relation_id');
        $member->note = $request->note;
        $member->face_book = $request->facebook;
        $member->twitter = $request->twitter;
        $member->email_notifications = $request->email_notifications;
        $member->religion = $request->input('religion');
        $member->profession = $request->input('profession');
        $member->age = $request->input('age');
        $member->national_id = $request->input('national_id');
        $member->gender = $request->input('gender');
        $birth = $request->input('date_of_birth');
        $formatted_birth = Carbon::parse($birth)->format('Y-m-d');
        $member->date_of_birth = $formatted_birth;
        $subscribe = $request->input('date_of_subscription');
        $formatted_birth = Carbon::parse($subscribe)->format('Y-m-d');
        $member->date_of_subscription = $formatted_birth;
        $member->excluded_categories_id = $request->excluded_categories_id;
        if ($request->player == 1) {
            $member->player = 1;
            $member->team_id = $request->team_id;
        }
        $member->save();
        //User Data
        $user->name = $request->input('name');
        //        $user->image = $request->input('image');
        $user->email = $member->email;
        $user->mobile = $request->input('mobile');
        $user->country_id = $request->input('country_id');

        if ($request->input('locale') != '') {
            $user->locale = $request->input('locale');
        }

        if ($request->password != '') {
            $user->password = Hash::make($request->input('password'));
        }
        if ($request->hasFile('image')) {
            $user->image = Files::upload($request->image, 'avatar', 300);
        }
        $user->locale = $request->locale;
        $user->save();


        return Reply::redirect(route('admin.members.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_members'), 403);

        $member = memberDetails::where('user_id', $id)->first();
        if ($member->relation_id == 1) {
            $family = $member->family();
            foreach ($family as $f_member) {
                $f_user = User::where('id', $f_member->user_id)->first();
                $f_user->delete();
                $f_member->delete();
            }

        } else {
            $user = User::where('id', $id)->first();
            $user->delete();
            $member->delete();
        }
        return Reply::success(__('messages.memberDeleted'));
    }

    public function showInvoices($id)
    {
        $this->member = User::find($id);

        if (!$this->member) {
            abort(404);
        }

        $this->memberDetail = $this->member ? $this->member->member_details : abort(404);
        //        $this->memberStats = $this->memberStats($id);

        if (!is_null($this->memberDetail)) {
            $this->memberDetail = $this->memberDetail->withCustomFields();
            $this->fields = $this->memberDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $this->invoices = Invoice::selectRaw('invoices.invoice_number, invoices.total, currencies.currency_symbol, invoices.issue_date, invoices.id,
            ( select payments.amount from payments where invoice_id = invoices.id) as paid_payment')
            ->leftJoin('projects', 'projects.id', '=', 'invoices.project_id')
            ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->where(function ($query) use ($id) {
                $query->where('projects.member_id', $id)
                    ->orWhere('invoices.member_id', $id);
            })
            ->get();


        return view('admin.members.invoices', $this->data);
    }

    public function showPayments($id)
    {
        $this->member = User::find($id);
        $this->memberDetail = memberDetails::where('user_id', '=', $this->member->id)->first();
        //        $this->memberStats = $this->memberStats($id);

        if (!is_null($this->memberDetail)) {
            $this->memberDetail = $this->memberDetail->withCustomFields();
            $this->fields = $this->memberDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $this->payments = Payment::with(['project:id,project_name', 'currency:id,currency_symbol,currency_code', 'invoice'])
            ->leftJoin('invoices', 'invoices.id', '=', 'payments.invoice_id')
            ->leftJoin('projects', 'projects.id', '=', 'payments.project_id')
            ->select('payments.id', 'payments.project_id', 'payments.currency_id', 'payments.invoice_id', 'payments.amount', 'payments.status', 'payments.paid_on', 'payments.remarks')
            ->where('payments.status', '=', 'complete')
            ->where(function ($query) use ($id) {
                $query->where('projects.member_id', $id)
                    ->orWhere('invoices.member_id', $id);
            })
            ->orderBy('payments.id', 'desc')
            ->get();
        return view('admin.members.payments', $this->data);
    }

    public function Import(Request $request)
    {
        abort_if(!$this->user->cans('add_members'), 403);

        Validator::make($request->all(), [
            'file' => 'required',
        ])->validate();
        $role = Role::where('name', 'member')->first();
        $lastUserId = User::max('id');


        $lastMemberId = memberDetails::max('id');
        Excel::import(new UsersImport(), $request->file('file')->store('temp'));
        $users = User::where('id', '>', $lastUserId)->get();
        $userID = $lastUserId;
        foreach ($users as $user) {
            $userID++;
            $user->attachRole($role->id);
            $user->id = $userID;
            $user->save();
        }
        Excel::import(new MemberImport(), $request->file('file')->store('temp'));
        if ($lastMemberId) {
            $members = memberDetails::where('id', '>', $lastMemberId)->get();
        } else {
            $members = memberDetails::all();
        }
        foreach ($members as $member) {
            $lastUserId++;
            $member->user_id = $lastUserId;
            $member->save();
        }

        return back();
    }

    public function membersPenalties()
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $pendingPenalties = Penalties::where('status', 'pending')->get();
        $this->pendingPenalties = count($pendingPenalties);
        return view('admin.members.penalties_index', $this->data);

    }

    public function data(Request $request, $userId = null)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $penaltiesList = Penalties::select('penalties.id', 'member_details.name', 'member_details.member_id', 'penalties.penalty_name', 'penalties.status', 'penalties.details', 'penalties.amount', 'penalties.currency')
            ->join('member_details', 'member_details.user_id', '=', 'penalties.user_id');

        if ($userId != 0) {
            $penaltiesList->where('member_details.member_id', $userId);
        }
        if ($request->penalty_type != null) {
            $penaltiesList->where('penalties.penalty_name', $request->penalty_type);
        }


        $penalties = $penaltiesList->get();

        return DataTables::of($penalties)
            ->addColumn('user', function ($row) {
                return ucwords($row->name);
            })
            ->addColumn('penalty_type', function ($row) {
                $type = $row->penalty_name;

                return $type;
            })
            ->addColumn('amount', function ($row) {
                if ($row->penalty_name == 'Financial Penalty') {
                    $amount = $row->amount . $row->currency;
                } else {
                    $amount = '--';
                }
                return $amount;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'pending') {
                    $label = 'warning';
                } elseif ($row->status == 'approved') {
                    $label = 'success';
                } elseif ($row->status == 'rejected') {
                    $label = 'danger';
                }
                //                $label = $row->status == 'pending' ? 'warning' : 'success';
                return '<div class="label label-' . $label . '">' . $row->status . '</div>';
            })

            ->addColumn('action', function ($row) {
                if ($row->status == 'pending') {
                    return '<a href="javascript:;"
                            data-leave-id=' . $row->id . ' 
                            data-leave-action="approved" 
                            class="btn btn-success btn-circle leave-action"
                            data-toggle="tooltip"
                            data-original-title="' . __('app.approved') . '">
                                <i class="fa fa-check"></i>
                            </a>
                            <a href="javascript:;" 
                            data-leave-id=' . $row->id . '
                            data-leave-action="rejected"
                            class="btn btn-danger btn-circle leave-action-reject"
                            data-toggle="tooltip"
                            data-original-title="' . __('app.reject') . '">
                                <i class="fa fa-times"></i>
                            </a>
                            
                            <a href="javascript:;"
                            data-leave-id=' . $row->id . '
                            class="btn btn-info btn-circle show-leave"
                            data-toggle="tooltip"
                            data-original-title="' . __('app.details') . '">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </a>';
                }

                return '<a href="javascript:;"
                        data-leave-id=' . $row->id . '
                        class="btn btn-info btn-circle show-leave"
                        data-toggle="tooltip"
                        data-original-title="' . __('app.details') . '">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['user', 'status', 'penalty_type', 'action'])
            ->make(true);
    }
    public function penaltyAction(Request $request)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $penalty = Penalties::find($request->leaveId);
        $penalty->status = $request->action;
        if (!empty($request->reason)) {
            $penalty->reject_reason = $request->reason;
        }
        if ($request->action == 'approved') {
            if ($penalty->penalty_name == 'Suspend Membership') {
                $user = User::find($penalty->user_id);
                $user->status = 'deactive';
                $user->login = 'disable';
                $user->save();
                if (memberDetails::where('user_id', $penalty->user_id)->first()) {
                    $member = memberDetails::where('user_id', $penalty->user_id)->first();
                    $member->status_id = 4;
                    $member->save();
                }
            }
        }
        $penalty->save();

        return Reply::success(__('modules.members.success'));

    }
    public function rejectModal(Request $request)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $this->leaveAction = $request->leave_action;
        $this->leaveID = $request->leave_id;
        return view('admin.members.reject-reason-modal', $this->data);
    }
    public function showPenalty($id)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $this->penalty = Penalties::findOrFail($id);
        $this->user = User::where('id', $this->penalty->user_id)->first();
        return view('admin.members.show_penalty', $this->data);
    }
    public function editPenalty($id)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $this->currencies = Currency::all();

        $this->penalty = Penalties::find($id);
        $view = view('admin.members.penalties_edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }
    public function updatePenalty(Request $request, $id)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        $penalty = Penalties::find($id);
        $penalty->details = $request->details;
        $penalty->penalty_name = $request->penalty_type;
        $penalty->amount = $request->amount;
        $penalty->currency = $request->currency;
        $penalty->status = $request->status;
        if ($request->status == 'approved') {
            if ($request->penalty_type == 'Suspend Membership') {
                $user = User::find($penalty->user_id);
                $user->status = 'deactive';
                $user->login = 'disable';
                $user->save();
                if (memberDetails::where('user_id', $penalty->user_id)->first()) {
                    $member = memberDetails::where('user_id', $penalty->user_id)->first();
                    $member->status_id = 4;
                    $member->save();
                }
            }
        }
        $penalty->save();
        return Reply::redirect(route('admin.members.penalties'));
    }
    public function deletePenalty($id)
    {
        abort_if(!$this->user->cans('edit_members'), 403);

        Penalties::destroy($id);
        return Reply::success('messages.Success');
    }
    public function searchMember($key)
    {
        $members = DB::table('member_details')->where('member_id', 'like', '%' . $key . '%')->get();

        return $members;

    }
    public function selectUser($displayCategory)
    {
        $this->projects = Project::whereNotNull('client_id')->get();
        $this->currencies = Currency::all();
        $this->employees = User::allEmployees();
        $this->categories = memberCategory::all();
        $this->displayCategory = $displayCategory;
        $view = view('club.select_user', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);

    }
    public function selectClientMember($displayCategory)
    {
        $this->projects = Project::whereNotNull('client_id')->get();
        $this->currencies = Currency::all();
        $this->employees = User::allEmployees();
        $this->categories = memberCategory::all();
        $this->displayCategory = $displayCategory;
        $view = view('club.select_client_member', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);

    }
    public function invoiceInex(MembersInvoicesDataTable $dataTable)
    {
        abort_if(!$this->user->cans('view_members'), 403);

        $this->categories = memberCategory::all();
        // dd($this->data['invoiceSetting']->toArray());
        return $dataTable->render('admin.members.invoices_index', $this->data);
    }
    public function invoiceCreate()
    {
        $this->currencies = Currency::all();
        $this->lastInvoice = Invoice::lastInvoiceNumber() + 1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }


        $this->taxes = Tax::all();

        // $this->products = Product::select('id', 'name as title', 'name as text')->get();
        $this->products = Product::with('tax')
            ->join('product_inventories', 'products.id', '=', 'product_inventories.product')
            ->join('inventories', 'inventories.id', '=', 'product_inventories.inventory')
            ->where('products.allow_purchase', 1)
            ->select(
                'product_inventories.id', DB::raw("CONCAT(inventories.name,' - ',products.name) AS title"),
                DB::raw("CONCAT(inventories.name,' - ',products.name) AS text")
            )
            ->get();
        // return $this->products;
        $this->categories = memberCategory::all();
        if (request('type') == "timelog") {
            $this->startDate = Carbon::now($this->global->timezone)->subDays(7);
            $this->endDate = Carbon::now($this->global->timezone);
            return view('admin.invoices.create-invoice', $this->data);
        }

        $invoice = new Invoice();
        $this->fields = $invoice->getCustomFieldGroupsWithFields()->fields;

        return view('admin.members.create_invoice', $this->data);
    }
    public function membershipRenew(RenewMembershipDataTable $dataTable)
    {
        $this->projects = Project::all();
        $this->clients = User::allClients();
        $this->employees = User::allEmployees();
        $this->categories = memberCategory::all();
        return $dataTable->render('admin.members.membership_renew', $this->data);
    }
    public function membershipRenewCreate()
    {
        $this->projects = Project::all();
        $this->currencies = Currency::all();
        $this->renewSetting = MembershipRenewSetting::all();
        $this->members = memberDetails::all();
        $this->lastInvoice = Invoice::lastInvoiceNumber() + 1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }

        $this->taxes = Tax::all();
        $this->products = Product::select('id', 'name as title', 'name as text')->get();
        $this->categories = memberCategory::all();
        return view('admin.members.create_recurring_invoice', $this->data);
    }
    public function membershipRenewStore(StoreRecurringInvoice $request)
    {
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $hsnSacCode = request()->input('hsn_sac_code');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');

        foreach ($quantity as $qty) {
            if (!is_numeric($qty) && (intval($qty) < 1)) {
                return Reply::error(__('messages.quantityNumber'));
            }
        }

        foreach ($cost_per_item as $rate) {
            if (!is_numeric($rate)) {
                return Reply::error(__('messages.unitPriceNumber'));
            }
        }

        foreach ($amount as $amt) {
            if (!is_numeric($amt)) {
                return Reply::error(__('messages.amountNumber'));
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error(__('messages.itemBlank'));
            }
        }

        if ($request->category_id) {
            $members = memberDetails::where('category_id', $request->category_id)->get();
            foreach ($members as $member) {
                $chkExistance = RecurringInvoice::where('client_id', $member->user_id)
                    ->where('is_renew', 1)
                    ->first();
                if (!$chkExistance) {
                    $invoice = new RecurringInvoice();
                    $invoice->is_renew = 1;
                    $invoice->project_id = $request->project_id ?? null;
                    $invoice->client_id = $member->user_id;
                    $invoice->issue_date = Carbon::createFromFormat($this->global->date_format, $request->issue_date)->format('Y-m-d');
                    $invoice->due_date = Carbon::createFromFormat($this->global->date_format, $request->due_date)->format('Y-m-d');
                    $invoice->sub_total = $request->sub_total;
                    $invoice->total = $request->total;
                    $invoice->discount = round($request->discount_value, 2);
                    $invoice->discount_type = $request->discount_type;
                    $invoice->total = round($request->total, 2);
                    $invoice->currency_id = $request->currency_id;
                    $invoice->note = $request->note;

                    $invoice->rotation = $request->rotation;
                    $invoice->billing_cycle = $request->billing_cycle > 0 ? $request->billing_cycle : null;
                    $invoice->unlimited_recurring = $request->billing_cycle < 0 ? 1 : 0;
                    $invoice->created_by = $this->user->id;

                    if ($request->rotation == 'weekly' || $request->rotation == 'bi-weekly') {
                        $invoice->day_of_week = $request->day_of_week;
                    } elseif ($request->rotation == 'monthly' || $request->rotation == 'quarterly' || $request->rotation == 'half-yearly' || $request->rotation == 'annually') {
                        $invoice->day_of_month = $request->day_of_month;
                    }

                    if ($request->project_id > 0) {
                        $invoice->project_id = $request->project_id;
                    }

                    $invoice->client_can_stop = ($request->client_can_stop) ? 1 : 0;

                    $invoice->status = 'active';
                    $invoice->save();
                }

            }
            return Reply::redirect(route('admin.members.membership-renew'), __('messages.recurringInvoiceCreated'));
        } else {
            $invoice = new RecurringInvoice();
            if ($request->client_id) {
                $invoice->client_id = $request->client_id;
            } elseif ($request->employee_id) {
                $invoice->client_id = $request->employee_id;
            } elseif ($request->member_id) {
                $member = memberDetails::where('member_id', $request->member_id)->first();
                $invoice->client_id = $member->user_id;
            }

            $chkExistance = RecurringInvoice::where('client_id', $member->user_id)
                ->where('is_renew', 1)
                ->first();
            if (!$chkExistance) {
                $invoice->project_id = $request->project_id ?? null;
                $invoice->is_renew = 1;
                //            $invoice->client_id = $request->project_id == '' || $request->has('client_id') ? $request->client_id : null;
                $invoice->issue_date = Carbon::createFromFormat($this->global->date_format, $request->issue_date)->format('Y-m-d');
                $invoice->due_date = Carbon::createFromFormat($this->global->date_format, $request->due_date)->format('Y-m-d');
                $invoice->sub_total = $request->sub_total;
                $invoice->total = $request->total;
                $invoice->discount = round($request->discount_value, 2);
                $invoice->discount_type = $request->discount_type;
                $invoice->total = round($request->total, 2);
                $invoice->currency_id = $request->currency_id;
                $invoice->note = $request->note;

                $invoice->rotation = $request->rotation;
                $invoice->billing_cycle = $request->billing_cycle > 0 ? $request->billing_cycle : null;
                $invoice->unlimited_recurring = $request->billing_cycle < 0 ? 1 : 0;
                $invoice->created_by = $this->user->id;

                if ($request->rotation == 'weekly' || $request->rotation == 'bi-weekly') {
                    $invoice->day_of_week = $request->day_of_week;
                } elseif ($request->rotation == 'monthly' || $request->rotation == 'quarterly' || $request->rotation == 'half-yearly' || $request->rotation == 'annually') {
                    $invoice->day_of_month = $request->day_of_month;
                }

                if ($request->project_id > 0) {
                    $invoice->project_id = $request->project_id;
                }

                $invoice->client_can_stop = ($request->client_can_stop) ? 1 : 0;

                $invoice->status = 'active';
                $invoice->save();
            }

            return Reply::redirect(route('admin.members.membership-renew'), __('messages.recurringInvoiceCreated'));
        }

    }
    public function membershipRenewShow($id)
    {
        $this->invoice = RecurringInvoice::with('recurrings')->findOrFail($id);

        if ($this->invoice->discount > 0) {
            if ($this->invoice->discount_type == 'percent') {
                $this->discount = (($this->invoice->discount / 100) * $this->invoice->sub_total);
            } else {
                $this->discount = $this->invoice->discount;
            }
        } else {
            $this->discount = 0;
        }

        $taxList = array();

        $items = RecurringInvoiceItems::whereNotNull('taxes')
            ->where('invoice_recurring_id', $this->invoice->id)
            ->get();
        foreach ($items as $item) {
            if ($this->invoice->discount > 0 && $this->invoice->discount_type == 'percent') {
                $item->amount = $item->amount - (($this->invoice->discount / 100) * $item->amount);
            }
            foreach (json_decode($item->taxes) as $tax) {
                $this->tax = InvoiceItems::taxbyid($tax)->first();
                if (!isset($taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'])) {
                    $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] = ($this->tax->rate_percent / 100) * $item->amount;
                } else {
                    $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] = $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] + (($this->tax->rate_percent / 100) * $item->amount);
                }
            }
        }

        $this->taxes = $taxList;

        $this->settings = $this->company;
        $this->invoiceSetting = InvoiceSetting::first();

        return view('admin.members.show_recurring_invoice', $this->data);
    }
    public function membershipRenewEdit($id)
    {
        $this->invoice = RecurringInvoice::findOrFail($id);
        $this->projects = Project::all();
        $this->currencies = Currency::all();

        if ($this->invoice->status == 'paid') {
            abort(403);
        }
        $this->taxes = Tax::all();
        $this->products = Product::select('id', 'name as title', 'name as text')->get();
        if ($this->invoice->project_id != '') {
            $companyName = Project::where('id', $this->invoice->project_id)->with('clientdetails')->first();
            if (isset($companyName)) {
                $this->companyName = $companyName->clientdetails ? $companyName->clientdetails->company_name : '';
                $this->clientId = $companyName->clientdetails ? $companyName->clientdetails->user_id : '';
            }
        }

        return view('admin.members.edit_recurring_invoice', $this->data);
    }
    public function membershipRenewUpdate(Request $request, $id)
    {
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $hsnSacCode = request()->input('hsn_sac_code');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');
        $isMainMembershipItem = $request->input('isMainMembershipItem');
        foreach ($quantity as $qty) {
            if (!is_numeric($qty) && (intval($qty) < 1)) {
                return Reply::error(__('messages.quantityNumber'));
            }
        }

        foreach ($cost_per_item as $rate) {
            if (!is_numeric($rate)) {
                return Reply::error(__('messages.unitPriceNumber'));
            }
        }

        foreach ($amount as $amt) {
            if (!is_numeric($amt)) {
                return Reply::error(__('messages.amountNumber'));
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error(__('messages.itemBlank'));
            }
        }

        $invoice = RecurringInvoice::findOrFail($id);
        $invoice->project_id = $request->project_id ?? null;
        $invoice->is_renew = 1;
        //        $invoice->client_id           = $request->project_id == '' && $request->has('client_id') ? $request->client_id : null;
        $invoice->issue_date = Carbon::createFromFormat($this->global->date_format, $request->issue_date)->format('Y-m-d');
        $invoice->due_date = Carbon::createFromFormat($this->global->date_format, $request->due_date)->format('Y-m-d');
        $invoice->sub_total = $request->sub_total;
        $invoice->total = $request->total;
        $invoice->discount = round($request->discount_value, 2);
        $invoice->discount_type = $request->discount_type;
        $invoice->total = round($request->total, 2);
        $invoice->currency_id = $request->currency_id;
        $invoice->note = $request->note;

        $invoice->rotation = $request->rotation;
        $invoice->billing_cycle = $request->billing_cycle > 0 ? $request->billing_cycle : null;
        $invoice->unlimited_recurring = $request->billing_cycle < 0 ? 1 : 0;
        $invoice->created_by = $this->user->id;

        if ($request->rotation == 'weekly' || $request->rotation == 'bi-weekly') {
            $invoice->day_of_week = $request->day_of_week;
        } elseif ($request->rotation == 'monthly' || $request->rotation == 'quarterly' || $request->rotation == 'half-yearly' || $request->rotation == 'annually') {
            $invoice->day_of_month = $request->day_of_month;
        }

        if ($request->project_id > 0) {
            $invoice->project_id = $request->project_id;
        }

        $invoice->client_can_stop = ($request->client_can_stop) ? 1 : 0;

        $invoice->status = $request->status;
        $invoice->save();

        // delete and create new
        RecurringInvoiceItems::where('invoice_recurring_id', $invoice->id)->delete();

        foreach ($items as $key => $item):
            RecurringInvoiceItems::create(
                [
                    'invoice_recurring_id' => $invoice->id,
                    'is_main_membership_item' => (isset($isMainMembershipItem[$key]) && !is_null($isMainMembershipItem[$key])) ? $isMainMembershipItem[$key] : 0,
                    'item_name' => $item,
                    'hsn_sac_code' => $hsnSacCode[$key] ?? null,
                    'item_summary' => $itemsSummary[$key],
                    'type' => 'item',
                    'quantity' => $quantity[$key],
                    'unit_price' => round($cost_per_item[$key], 2),
                    'amount' => round($amount[$key], 2),
                    'taxes' => $tax ? array_key_exists($key, $tax) ? json_encode($tax[$key]) : null : null
                ]
            );
        endforeach;

        return Reply::redirect(route('admin.members.membership-renew'), __('messages.recurringInvoiceCreated'));

    }
    public function membershipRenewDelete($id)
    {
        RecurringInvoice::destroy($id);
        return Reply::success(__('messages.invoiceDeleted'));
    }
    public function createRecurringRenewMembershipAuto($user_id, $category_id, $payDate)
    {
        $chkExistance = RecurringInvoice::where('client_id', $user_id)->first();
        if (!$chkExistance) {
            $nextYear = $payDate;
            $invoice = new RecurringInvoice();

            $invoice->is_renew = 1;
            $invoice->project_id = null;
            $invoice->client_id = $user_id;
            $invoice->issue_date = Carbon::parse($nextYear . '-07-01')->format('Y-m-d');
            $invoice->due_date = Carbon::parse($nextYear . '-10-31')->format('Y-m-d');
            $invoice->company_id = 1;

            $set = MembershipRenewSetting::find(1);

            if ($category_id == 2) //affliate
            {
                $item_name = ['اشتراك عضو تابع', 'مصاريف ادارية للعضوية', 'طباعة كارنية', 'طابع معاقين للعضوية', 'طابع شهيد للعضوية', 'رفع الكفاءة الانشائية'];
                $itemsSummary = [];
                $cost_per_item = [$set->affiliate_annual_fees, $set->administrative_expenses, $set->card_printing, $set->disabled_stamp, $set->martyr_stamp, $set->enhancing_constructions];
                $quantity = [1, 1, 1, 1, 1, 1];
                $amount = [$set->affiliate_annual_fees, $set->administrative_expenses, $set->card_printing, $set->disabled_stamp, $set->martyr_stamp, $set->enhancing_constructions];
                $tax = [];
                $hsnSacCode = [];
                $isMainMembershipItem = [1, 0, 0, 0, 0, 0];
                $invoice->sub_total = $set->affiliate_annual_fees + $set->administrative_expenses + $set->card_printing + $set->disabled_stamp + $set->martyr_stamp + $set->enhancing_constructions;
                $invoice->total = $set->affiliate_annual_fees + $set->administrative_expenses + $set->card_printing + $set->disabled_stamp + $set->martyr_stamp + $set->enhancing_constructions;
            } else {
                $item_name = ['اشتراك عضو عامل', 'مصاريف ادارية للعضوية', 'طباعة كارنية', 'طابع معاقين للعضوية', 'طابع شهيد للعضوية', 'رفع الكفاءة الانشائية'];
                $itemsSummary = [];
                $cost_per_item = [$set->main_annual_fees, $set->administrative_expenses, $set->card_printing, $set->disabled_stamp, $set->martyr_stamp, $set->enhancing_constructions];
                $quantity = [1, 1, 1, 1, 1, 1];
                $amount = [$set->main_annual_fees, $set->administrative_expenses, $set->card_printing, $set->disabled_stamp, $set->martyr_stamp, $set->enhancing_constructions];
                $tax = [];
                $hsnSacCode = [];
                $isMainMembershipItem = [1, 0, 0, 0, 0, 0];
                $invoice->sub_total = $set->main_annual_fees + $set->administrative_expenses + $set->card_printing + $set->disabled_stamp + $set->martyr_stamp + $set->enhancing_constructions;
                $invoice->total = $set->main_annual_fees + $set->administrative_expenses + $set->card_printing + $set->disabled_stamp + $set->martyr_stamp + $set->enhancing_constructions;

            }
            $invoice->currency_id = 1;
            $invoice->note = 'automatic add renew membership recurring invoice ';
            $invoice->rotation = 'annually';
            $invoice->billing_cycle = null;
            $invoice->unlimited_recurring = 1;
            $invoice->created_by = 2;
            $invoice->client_can_stop = 0;
            $invoice->status = 'active';
            $invoice->save();



            foreach ($item_name as $key => $item) {
                if (!is_null($item)) {
                    RecurringInvoiceItems::create(
                        [
                            'invoice_recurring_id' => $invoice->id,
                            'item_name' => $item,
                            'hsn_sac_code' => (isset($hsnSacCode[$key]) && !is_null($hsnSacCode[$key])) ? $hsnSacCode[$key] : null,
                            'is_main_membership_item' => (isset($isMainMembershipItem[$key]) && !is_null($isMainMembershipItem[$key])) ? $isMainMembershipItem[$key] : 0,
                            'item_summary' => (isset($itemsSummary[$key]) && !is_null($itemsSummary[$key])) ? $itemsSummary[$key] : null,
                            'type' => 'item',
                            'quantity' => $quantity[$key],
                            'unit_price' => round($cost_per_item[$key], 2),
                            'amount' => round($amount[$key], 2),
                            'taxes' => $tax ? array_key_exists($key, $tax) ? json_encode($tax[$key]) : null : null
                        ]
                    );
                }
            }

        }
    }
    public function membershipRenewSettings()
    {
        $this->renewSetting = MembershipRenewSetting::all();
        return view('admin.members.renew_settings', $this->data);
    }
    public function updateRenewSettings(Request $request)
    {
        $set = MembershipRenewSetting::find(1);
        $set->main_annual_fees = $request->main_annual_fees;
        $set->affiliate_annual_fees = $request->affiliate_annual_fees;
        $set->administrative_expenses = $request->administrative_expenses;
        $set->card_printing = $request->card_printing;
        $set->disabled_stamp = $request->disabled_stamp;
        $set->martyr_stamp = $request->martyr_stamp;
        $set->enhancing_constructions = $request->enhancing_constructions;
        $set->save();
        return Reply::redirect(route('admin.members.membership-renew'), __('messages.updateSuccess'));
    }

}
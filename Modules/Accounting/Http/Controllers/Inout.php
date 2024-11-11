<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\Entities\InoutFile;
use Modules\Accounting\Entities\InoutGroup;
use Yajra\DataTables\DataTables;

class Inout extends AdminBaseController {

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });

    }

    private function viewCommonAttributes($type)
    {
        $this->pageTitle = __('accounting::modules.accounting.accounting');
        if($type=='in'){
            $this->pageTitle .= ' / '.__('accounting::modules.accounting.sidebar.received');
        }else{
            $this->pageTitle .= ' / '.__('accounting::modules.accounting.sidebar.outgoing');
        }

        $this->pageIcon = 'fa fa-money';

        $this->data['type']=$type;


    }

    public function index($type,Request $request)
    {
        $this->viewCommonAttributes($type);


        if ($request->ajax()) {

            
            $query = InoutGroup::where('type', ($type=='in')?'IN':'OUT');
            $query->orderBy('created_at','desc');
            return DataTables::of($query)->make(true);
   
        }

        $this->data['totalEntries']=InoutGroup::where('type', ($type=='in')?'IN':'OUT')->count();

        return view('accounting::inout.index',$this->data);
    }

    public function create($type,Request $request)
    {
        $this->viewCommonAttributes($type);

        $this->pageTitle .= ' / '.__('accounting::modules.accounting.add');

        if($request->isMethod('get'))
        {
            $this->data['mimes']=InoutFile::mimeValidator();
            $this->data['maxSize']=InoutFile::DEFAULT_ALLOWED_SIZE;
            $this->data['htmlFileTypeValidator']=InoutFile::htmlValidator();

            return view('accounting::inout.create',$this->data);
        }
        else
        {

            $request->validate(
                [
                    'title' => 'required',
                    'files' => 'required',
                    'files.*' => 'file|max:'.InoutFile::sizeValidator().'|mimes:'.InoutFile::mimeValidator()
                ]
                );

                DB::beginTransaction();

                $group = InoutGroup::create(
                    [
                        'title'=>$request->input('title'),
                        'description'=> $request->input('description'),
                        'type'=>InoutGroup::getTypeEnum($type)
                    ]
                    );

                try
                {

                    foreach($request->file('files') as $file)
                    {
                        $newFile=InoutFile::create(
                            [
                                'original_name'=>$file->getClientOriginalName(),
                                'inout_group_id'=>$group->id
                            ]
                            );

                        Storage::put(InoutFile::STORAGE_PATH.'/'.$newFile->name_on_disk,file_get_contents($file->getRealPath()));
                    }

                    DB::commit();
                }
                catch (Exception $e)
                {
                    
                    DB::rollback();
                    foreach($group->files as $file)
                    {
                        Storage::delete(InoutFile::STORAGE_PATH.'/'.$file->name_on_disk);
                        $file->delete();
                    }
                
                    $group->delete();
                    
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    
                }

                return redirect(route('admin.accounting.inout.index', $type))
                ->with('success', __('accounting::modules.accounting.storesuccess'));
    
        }

    }

    public function destroy($type,$id)
    {
        $group=InoutGroup::findOrFail($id);
        foreach($group->files as $file)
        {
            Storage::delete(InoutFile::STORAGE_PATH.'/'.$file->name_on_disk);
            $file->delete();
        }
    
        $group->delete();
        return redirect(route('admin.accounting.inout.index', $type))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));

    }

    public function list($type,$id,Request $request)
    {
        $group=InoutGroup::findOrFail($id);
        $this->viewCommonAttributes($type);
        $this->pageTitle .= ' / '.$group->title;
        $this->data['id']=$group->id;
        
        if ($request->ajax()) {

            
            $query = $group->files;
            return DataTables::of($query)->make(true);
   
        }

        $this->data['totalEntries']=$group->files->count();

        return view('accounting::inout.list',$this->data);

    }


    public function download($id)
    {
        $file=InoutFile::findOrFail($id);
        return Storage::download(InoutFile::STORAGE_PATH.'/'.$file->name_on_disk,$file->original_name);
    }
}

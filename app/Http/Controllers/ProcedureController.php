<?php

namespace App\Http\Controllers;

use App\Procedure;
use App\User;
use App\Location;
use View;
use Helper;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }
    public function index(Request $request)
    {
        $result = [];
        $all_data = User::with('roles')->get();

         foreach ($all_data as $key => $data) {
           // print_r($data->last_name);
          
            if (!($data->roles->isEmpty())) {
                if (($data->roles[0]->name =='doctor') || ($data->roles[0]->name =='hospital')) {
              
            }
            else{
                $all_data->forget($key);
            }
            }

           
            
        }
        $all_users = $all_data;
        foreach ($all_users as $key => $newdata) {
        $result[]  =   $newdata;
        }

        // $doctor = User::role('doctor')->get();
        // $hospital = User::role('hospital')->get();

               if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $procedures = $this->procedure::where('name', 'like', '%' . $keyword . '%')->get()->setPath('');
            $pagination = $procedures->appends(
                array(
                    'keyword' => $request->get('keyword')
                )
            );
        } else {
            $procedures = $this->procedure->get();
            $procedures = Procedure::orderBy("id","desc")->with('users')->get();
        }
       return view('back-end.admin.procedure.index',compact('result','procedures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $doctors = explode( ',',$request->doctor);
            
            $this->validate(
                $request,
                [
                    'name' => 'required',
                    'fee' => 'required',
                    'doctor' => 'required'
                ],
                [
                    'name.required' => 'Enter Name!',
                    'fee.required' => 'Enter Fee!',
                    'doctor.required' => 'Please Enter at least one Doctor or Hospital!'
    ]
            );
            $this->procedure->saveProcedure($request);
            foreach ($doctors as $doctor){
                $this->procedure->users()->attach($doctor);
            }
            Session::flash('message','Procedure Created Successfully');  
            return Redirect::back();
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function show(Procedure $procedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function edit($procedure)
    {
           $result = [];
        $all_data = User::with('roles')->get();
         foreach ($all_data as $key => $data) {
            if (!($data->roles->isEmpty())) {
            if (($data->roles[0]->name =='doctor') || ($data->roles[0]->name =='hospital')) {
              
            }
            else{
                $all_data->forget($key);
            }
        }
            
        }
        $all_users = $all_data;
        foreach ($all_users as $key => $newdata) {
        $result[]  =   $newdata;
        }
        $procedure = Procedure::find($procedure);
        $user_tags = $procedure->users()->get();
        
         return view('back-end.admin.procedure.edit',compact('result','procedure','user_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $procedure)
    {
        $doctors = explode( ',',$request->doctor);
        $this->validate(
            $request,
            [
                'name' => 'required',
                'fee' => 'required',
                'doctor' => 'required'
            ]
        );
        $this->procedure->updateProcedure($request, $procedure);
        $this->procedure['id'] = $procedure;
        $this->procedure->users()->detach();
        foreach ($doctors as $doctor){
                $this->procedure->users()->attach($doctor);
            }
        Session::flash('message','Procedure Update Successfully');  
         return Redirect::to('admin/procedure');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         {

        $server = Helper::doctieIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $id = $request['id'];
        
        if (!empty($id)) {
          $procedure = $this->procedure::find($id);
           $this->procedure['id'] = $request['id'];
            $this->procedure->users()->detach();
          Procedure::where('id', $id)->delete();
      
            $json['type'] = 'success';
            $json['message'] = 'Procedure Deleted Successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    
    }
    }
}

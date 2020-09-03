<?php

namespace App\Http\Controllers;

use App\Speciality_Test;
use App\Speciality;
use View;
use Helper;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;


class Speciality_TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
        {
       $specialities = Speciality::all();
       $tests = Speciality_Test::with('specialities')->orderBy("id","desc")->get();
     return view('back-end.admin.speciality-tests.index',compact('specialities','tests'));
       
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
              $this->validate(
            $request,
            [
                'name' => 'required',
                'speciality_id' => 'required',
            ]
        );
         $Speciality_Test = new Speciality_Test();
        $Speciality_Test ->name = $request->name;
        $Speciality_Test ->speciality_id = $request->speciality_id;
        $Speciality_Test ->save();
         Session::flash('message','Speciality Test Created Successfully');  
            return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Speciality_Test  $Speciality_Test
     * @return \Illuminate\Http\Response
     */
    public function show(Speciality_Test $Speciality_Test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Speciality_Test  $Speciality_Test
     * @return \Illuminate\Http\Response
     */
    public function edit($Speciality_Test)
    {
          $specialities = Speciality::all();
        $tests = Speciality_Test::find($Speciality_Test);
        return view('back-end.admin.speciality-tests.edit',compact('specialities','tests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Speciality_Test  $Speciality_Test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Speciality_Test)
        {
        $this->validate(
            $request,
          [
                'name' => 'required',
                'speciality_id' => 'required',
            ]
        );
        $Speciality_Test = Speciality_Test::find($Speciality_Test);
        $Speciality_Test->name  = $request->get('name');
        $Speciality_Test->speciality_id  = $request->get('speciality_id');
        $Speciality_Test->save();
        Session::flash('message','Speciality Test Edit Successfully');  
       return Redirect::to('admin/speciality-test');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speciality_Test  $Speciality_Test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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
          Speciality_Test::where('id', $id)->delete();
      
            $json['type'] = 'success';
            $json['message'] = 'Speciality Test Deleted Successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
}

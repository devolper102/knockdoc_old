<?php

namespace App\Http\Controllers;

use App\Treatment;
use Illuminate\Http\Request;
use View;
use Helper;
use App\Disease;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
    }
    public function index()
    {
       $diseases = Disease::all();
       $treatments = Treatment::orderBy("id","desc")->get();
       return view('back-end.admin.treatments.index',compact('treatments','diseases'));

       
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
       //dd($request->diseases);
         $diseases = explode( ',',$request->diseases);
       $this->validate(
            $request,
            [
                'title' => 'required',
                'diseases' => 'required'
            ]
        );
          $this->treatment->saveTreatment($request);
            foreach ($diseases as $disease){
                $this->treatment->diseases()->attach($disease);
            }


         Session::flash('message','Treatment Created Successfully');  
            return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit( $treatment)
    {
        $disease = Disease::all();
        $treatments = Treatment::find($treatment);
        $dis_tags = $treatments->diseases()->get();
        
         return view('back-end.admin.treatments.edit',compact('treatments','disease','dis_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $treatment)
    {
       $diseases = explode( ',',$request->diseases);
        $this->validate(
            $request,
            [
                'title' => 'required',
                'diseases' => 'required'
            ]
        );
        $this->treatment->updateTreatment($request, $treatment);
        $this->treatment['id'] = $treatment;
        $this->treatment->diseases()->detach();
        foreach ($diseases as $disease){
                $this->treatment->diseases()->attach($disease);
            }


        

        // $treatment = Treatment::find($treatment);
        // $treatment->title  = $request->get('title');
        // $treatment->description  = $request->get('description');
        // $treatment ->save();
        Session::flash('message','Treatment Update Successfully');  
       return Redirect::to('admin/treatments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treatment  $treatment
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
          $treatment = $this->treatment::find($id);
           $this->treatment['id'] = $request['id'];
            $this->treatment->diseases()->detach();
          Treatment::where('id', $id)->delete();
      
            $json['type'] = 'success';
            $json['message'] = 'Treatment Deleted Successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    
    }
}

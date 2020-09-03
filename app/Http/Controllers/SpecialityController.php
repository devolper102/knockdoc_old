<?php

/**
 * Class SpecialityController
 *
 * @category Doctry
 *
 * @package Doctry
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Location;
use App\User;
use FontLib\Table\Type\loca;
use View;
use Session;
use App\Helper;
use App\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Service;

/**
 * Class SpecialityController
 *
 */
class SpecialityController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $speciality
     */
    protected $speciality;

    /**
     * Create a new controller instance.
     *
     * @param instance $speciality instance
     *
     * @return void
     */
    public function __construct(Speciality $speciality)
    {
        $this->speciality = $speciality;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $specialitty = Speciality::all();
        $speciality_top = Speciality::orderBy("id","desc")->where('top', '1')->get();

        $location = Location::where('parent',0)->get();

        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $specialities = $this->speciality::where('title', 'like', '%' . $keyword . '%')->get()->setPath('');
            $pagination = $specialities->appends(
                array(
                    'keyword' => $request->get('keyword')
                )
            );
        } else {
            $specialities = $this->speciality->get();
        }
        if (file_exists(resource_path('views/extend/back-end/admin/specialities/edit.blade.php'))) {
            return View::make(
                'extend.back-end.admin.specialities.index',
                compact('specialities','location','specialitty','speciality_top')
            );
        } else {
            return View::make(
                'back-end.admin.specialities.index',
                compact('specialities','location','specialitty','speciality_top')
            );
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->user_type);
        $locations = explode( ',',$request->location);
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate(
                $request,
                [
                    'title' => 'required|string',
                    'user_type' => 'required',
                    'location' => 'required'
                ],
                [
                    'title.required' => 'Enter Specialty title!',
                    'title.string' => 'Enter title in string form',
                    'user_type.required' => 'Enter Specialty User Type!',
                    'location.required' => 'please Enter at least one location!'
    ]
            );
            $this->speciality->saveSpeciality($request);
            foreach ($locations as $location){
                $this->speciality->locations()->attach($location);
            }
            Session::flash('message', trans('lang.speciality_saved_success'));
            return Redirect::back();
        }
    }
    public function store_speciality(Request $request)
    {
        if (!empty($request)) {
            $this->validate(
                $request,
                [
                    'speciality' => 'required'
                ],
                [
                    'speciality.required' => 'please Enter at least one speciality!'
                ]
            );
            $str_arr = explode (",", $request->speciality);
            foreach ($str_arr as $data){
                $top = DB::table('specialities')->where("id",$data)->update([
                    'top' => 1
                ]);
            }
            Session::flash('message','Add Top Specialities');
            return Redirect::back();
        }
    }
    /**
     * Edit resource.
     *
     * @param int $slug integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $location = Location::all();

        if (!empty($slug)) {
            $speciality = $this->speciality::where('slug', $slug)->first();
            $loc_tags = $speciality->locations()->get();

            if (!empty($speciality)) {
                if (file_exists(resource_path('views/extend/back-end/admin/specialities/edit.blade.php'))) {
                    return View::make('extend.back-end.admin.specialities.edit', compact('speciality', 'location', 'loc_tags'));
                } else {
                    return View::make(
                        'back-end.admin.specialities.edit',
                        compact('speciality','location', 'loc_tags')
                    );
                }
                return Redirect::to('admin/specialities');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }


    /**
     * Update resource.
     *
     * @param string $request string
     * @param int    $id      int
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $locations = explode( ',',$request->location);
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'title' => 'required|string',
                'location' => 'required'
            ],
            [
                'title.required' => 'Enter Specialty title!',
                'title.string' => 'Enter title in string form',
                'location.required' => 'please Enter at least one location!'
            ]
        );
        $this->speciality->updateSpeciality($request, $id);
        $this->speciality['id'] = $id;
        $this->speciality->locations()->detach();
        foreach ($locations as $location){
            $this->speciality->locations()->attach($location);
        }
        Session::flash('message', trans('lang.speciality_updated'));
        return Redirect::to('admin/specialities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $request request attributes
     *
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
            $speciality = $this->speciality::find($id);
            if ($speciality->services->count() > 0) {
                foreach ($speciality->services as $key => $speciality_service) {
                    $service = Service::find($speciality_service->id);
                    if ($service->users->count() > 0) {
                        $service->users()->detach();
                    }
                    $service->delete();
                }
                
            }
            $this->speciality['id'] = $request['id'];
            $this->speciality->locations()->detach();
            $this->speciality::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.speciality_deleted');
            return $json;
        }
    }
    public function destroy_top(Request $request){
         $server = Helper::doctieIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $speciality = $this->speciality::find($id);
            if ($speciality->services->count() > 0) {
                foreach ($speciality->services as $key => $speciality_service) {
                    $service = Service::find($speciality_service->id);
                    if ($service->users->count() > 0) {
                        $service->users()->detach();
                    }
                    $service->delete();
                }
                
            }
            $this->speciality['id'] = $request['id'];
            $this->speciality->locations()->detach();
            $this->speciality::where('id', $id)->update([
           'top' => null
        ]);
            $json['type'] = 'success';
            $json['message'] = ('Top Speciality Delete Successfully');
            return $json;
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        $server = Helper::DoctieIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $checked = $request['ids'];
        foreach ($checked as $id) {
            $this->speciality::where("id", $id)->delete();
        }
        if (!empty($checked)) {
            $json['type'] = 'success';
            $json['message'] = trans('lang.specialities_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get specialities
     *
     * @return \Illuminate\Http\Response
     */
    public function getSpecialities()
    {
        $json = array();
        $specialities = $this->speciality::all();
        if (!empty($specialities)) {
            $json['type'] = 'success';
            $json['specialities'] = $specialities;
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get selected speciality service
     *
     * @param mixed $request request attributes
     * 
     * @return \Illuminate\Http\Response
     */
    public function getSpecialityService(Request $request)
    {
        $json = array();
        $speciality = $this->speciality::find($request['id']);
        $speciality->services->toArray();
        if (!empty($speciality)) {
            $json['type'] = 'success';
            $json['speciality'] = $speciality;
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get selected speciality service
     *
     * @param mixed $request request attributes
     * 
     * @return \Illuminate\Http\Response
     */
    public function getServices(Request $request)
    {
        $json = array();
        $type = !empty($request['type']) && $request['type'] == 'slug' ? 'slug' : 'id';
        if ($type == 'slug') {
            $selected_speciality = speciality::select('id')->where('slug', $request['id'])
                ->first();
            $speciality = $this->speciality::find($selected_speciality->id);
        } else {
            $speciality = $this->speciality::find($request['id']);
        }
        if (!empty($speciality) && $speciality->services->count() > 0) {
            $services = $speciality->services->toArray();
            if (!empty($speciality)) {
                if (!empty($speciality)) {
                    $json['type'] = 'success';
                    $json['services'] = $services;
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.something_wrong');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    public function forum(){
        $diseases = Speciality::paginate(5);
        return view('front-end.speciality-forum.index', compact('diseases'));
    }
    public function detail_page($slug){
        $locations = Location::all();
        $speciality = Speciality::where('slug',$slug)->with('locations')->first();
        $doctors = User::role('doctor')->with('diseases')->with('specialities')->with('location')->with('services')->with('profile')->with('location')->with('feedbacks')->with('doc_teams')->with('appointments')->with('roles')->get();
        $hospitals = User::role('hospital')->with('diseases')->with('specialities')->with('location')->with('services')->with('profile')->with('location')->with('feedbacks')->with('doc_teams')->with('appointments')->with('roles')->get();
        $services = Service::with('symptom')->with('speciality')->with('diseases')->get();
        return view('front-end.speciality-forum.details',compact('speciality', 'doctors', 'locations','hospitals', 'service', 'services'));
    }
    public function getAllDiseases(){
        $json = array();
        $diseases = Speciality::all();
        if (!empty($diseases)) {
            $json['type'] = 'success';
            $json['diseases'] = json_decode($diseases);
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function getAllDoctor (Request $request) {
        $doctors = User::role('doctor')->with('profile')->with('specialities')->with('services')->with('location')->with('feedbacks')->get();
        $location = $request['location'];
        $specialty = $request['specialty'];
        return view('front-end.find-a-doctor.detail', compact('doctors', 'location', 'specialty'));
    }
    public function getAllHospital (Request $request) {
        $doctors = User::role('doctor')->with('profile')->with('specialities')->with('services')->with('location')->with('feedbacks')->get();
        $location = $request['location'];
        $specialty = $request['specialty'];
        return view('front-end.find-a-doctor.detail', compact('doctors', 'location', 'specialty'));
    }

    public function getDataByArea (Request $request) {
        $doctors = User::role($request['role'])->with('profile')->with('specialities')->with('services')->with('location')->with('feedbacks')->get();
        $location = $request['location'];
        $area = $request['area'];
        dd($doctors, $location, $area);
        return view('front-end.find-a-doctor.detail', compact('doctors', 'location', 'specialty'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Helper;
use App\Service;
use App\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use View;

class DiseaseController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $location
     */
    protected $diseases;

    /**
     * Create a new controller instance.
     *
     * @param mixed $location location instance
     *
     * @return void
     */
    public function __construct(Disease $diseases)
    {
        $this->diseases = $diseases;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::all();
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $diseases = $this->diseases::where('title', 'like', '%' . $keyword . '%')->get()->setPath('');
            $pagination = $diseases->appends(
                array(
                    'keyword' => $request->get('keyword')
                )
            );
        } else {
            $diseases = $this->diseases->get();
        }

        if (file_exists(resource_path('views/extend/back-end/admin/diseases/index.blade.php'))) {
            return View::make(
                'extend.back-end.admin.diseases.index',
                compact('diseases','services')
            );
        } else {
            return View::make(
                'back-end.admin.diseases.index',
                compact('diseases','services')
            );
        }
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
       // dd($request->speciality);
         $services = explode( ',',$request->speciality);
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
                'speciality' => 'required'
            ],
            [

                    'speciality.required' => 'please Enter at least one speciality!'
    ]
        );
        if (!empty($request['title'])) {
            $this->diseases->storeDisease($request);
              foreach ($services as $service){
                $this->diseases->services()->attach($service);
            }
            Session::flash('message', trans('lang.save_disease'));
            return Redirect::back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
         $speciality = Service::all();
        // dd($speciality);
        if (!empty($slug)) {
            $disease = $this->diseases::where('slug', $slug)->first();

            $spe_tags = $disease->services()->get();
           // dd($spe_tags);
            if (!empty($disease)) {
                if (file_exists(resource_path('views/extend/back-end/admin/diseases/edit.blade.php'))) {
                    return View::make(
                        'extend.back-end.admin.diseases.edit',
                        compact(
                            'disease','speciality','spe_tags'
                        )
                    );
                } else {
                    return View::make(
                        'back-end.admin.diseases.edit',
                        compact(
                            'disease','speciality','spe_tags'
                        )
                    );
                }
                Session::flash('message', trans('lang.disease_updated'));
                return Redirect::to('admin/locations');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $specialitys = explode( ',',$request->speciality);
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
                 'speciality' => 'required'
            ],
            [

                    'speciality.required' => 'please Enter at least one speciality!'
    ]
        );
        $this->diseases->updateDisease($request, $id);
        $this->diseases['id'] = $id;
         $this->diseases->services()->detach();

        foreach ($specialitys as $speciality){
                $this->diseases->services()->attach($speciality);
            }
        Session::flash('message', trans('lang.disease_updated'));
        return Redirect::to('admin/diseases');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $server = Helper::doctieIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $this->diseases::where('id', $id)->delete();
            $this->diseases['id'] = $id;
            $this->diseases->specialties()->detach();
            $json['type'] = 'success';
            $json['message'] = trans('lang.disease_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Remove the all resource from storage.
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
        if (!empty($checked)) {
            foreach ($checked as $id) {
//                $this->diseases->user_meta()->detach();
                $this->diseases::where("id", $id)->delete();
            }
            $json['type'] = 'success';
            $json['message'] = trans('lang.disease_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function forum(){
        $specialities = Disease::all();
        return view('front-end/all-diseases/index', compact('specialities'));
    }
    public function detail_page($slug){
        $disease = Disease::where('slug',$slug)->first();
        return view('front-end.disease-forum.details',compact('disease'));
    }
    public function getAllDiseases(){
        $json = array();
        $diseases = Disease::all();
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
    public function allDiseases() {
        $specialities = Speciality::with('services_diseases')->get();
        return view('front-end.all-diseases.index', compact('specialities'));
    }
}

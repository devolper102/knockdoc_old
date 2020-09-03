<?php

/**
 * Class LocationController.
 *
 * @category Doctry
 *
 * @package Doctry
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Speciality;
use PHPUnit\Util\Json;
use View;
use Helper;
use Session;
use DB;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
/**
 * Class Location Controller
 *
 */
class LocationController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $location
     */
    protected $location;

    /**
     * Create a new controller instance.
     *
     * @param mixed $location location instance
     *
     * @return void
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $location_top = Location::all();
       $location_tops = Location::orderBy("id","desc")->where('top', '1')->get();
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $locations = $this->location::where('title', 'like', '%' . $keyword . '%')->get()->setPath('');
            $pagination = $locations->appends(
                array(
                    'keyword' => $request->get('keyword')
                )
            );
        } else {
            $locations = $this->location->get();
        }
        
        if (file_exists(resource_path('views/extend/back-end/admin/locations/index.blade.php'))) {
            return View::make('extend.back-end.admin.locations.index', compact('locations','location_top','location_tops')
            );
        } else {
            return View::make('back-end.admin.locations.index', compact('locations','location_top','location_tops'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
            ]
        );
        if (!empty($request['title'])) {
            $this->location->storeLocation($request);
            Session::flash('message', trans('lang.save_location'));
            return Redirect::back();
        }
    }
    public function store_location(Request $request)
    {
          
               if (!empty($request)) {
            $this->validate(
                $request,
                [
                    
                    'location' => 'required'
                ],
                [
                    
                    'location.required' => 'please Enter at least one location!'
    ]
            );
       $str_arr = explode (",", $request->location);  
      foreach ($str_arr as $data){
        $top = DB::table('locations')->where("id",$data)->update([
           'top' => 1
        ]);
            }
            Session::flash('message','Add Top Locations');  
            return Redirect::back();
    }
}

    /**
     * Edit Locations.
     *
     * @param int $slug string
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if (!empty($slug)) {
            $location = $this->location::where('slug', $slug)->first();
            $locations_list = Arr::pluck($this->location::where('slug', '!=', $slug)->get(), 'title', 'id');
            if (!empty($location)) {
                $location_parent = $this->location::where('slug', $slug)->select('parent')->pluck('parent')->first();
                if (file_exists(resource_path('views/extend/back-end/admin/locations/edit.blade.php'))) {
                    return View::make('extend.back-end.admin.locations.edit', compact('location', 'location_parent', 'locations_list')
                    );
                } else {
                    return View::make('back-end.admin.locations.edit', compact('location', 'location_parent', 'locations_list'
                        )
                    );
                }
                Session::flash('message', trans('lang.location_updated'));
                return Redirect::to('admin/locations');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Update locations.
     *
     * @param string $request string
     * @param int    $id      integer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $server_verification = Helper::doctieIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
            ]
        );
        $this->location->updateLocation($request, $id);
        Session::flash('message', trans('lang.location_updated'));
        return Redirect::to('admin/locations');
    }

    /**
     * Remove location from database.
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
            $this->location::where('id', $id)->delete();
            $this->location['id'] = $id;
            $result = $this->location->specialities()->detach();
            $json['type'] = 'success';
            $json['message'] = trans('lang.location_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
 public function destroy_top(Request $request)
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
            $this->location::where('id', $id)->update([
           'top' => null
        ]);
            $this->location['id'] = $id;
            $result = $this->location->specialities()->detach();
            $json['type'] = 'success';
            $json['message'] = 'Top Location Delete Successfully';
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
                $this->location::where("id", $id)->delete();
            }
            $json['type'] = 'success';
            $json['message'] = trans('lang.location_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function getChildLocations(Request $request){
        $childLocation = Location::where('parent', $request['id'])->get();
        $json = array();
        if (!empty($childLocation)){
            $json['child'] = $childLocation;
            $json['message'] = 'success';
        }
        else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
        }
        return $json;
    }
    public function doctorsLocation() {
        $locations = Location::where('parent','0')->get();
        $topspecialities = Speciality::where('top',1)->get();
        return view('front-end.doctors-in-pakistan.index', compact('locations', 'topspecialities'));
    }
    public function hospitalsLocation() {
        $locations = Location::where('parent','0')->get();
        $topspecialities = Speciality::where('top',1)->get();
        return view('front-end.hospitals-in-pakistan.index', compact('locations', 'topspecialities'));
    }
}

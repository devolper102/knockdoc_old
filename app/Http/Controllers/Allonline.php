<?php

namespace App\Http\Controllers;

use View;
use Session;
use App\Helper;
use App\Speciality;
use App\Feedback;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Service;
use App\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;



class Allonline extends Controller
{
    //
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
    public function index ()
    {   
        /*Request for all services*/
        $special = Service::with('users')->get();
        
        $specialities = Helper::getDoctorsFromArray($special);
       
            return View::make(
                'back-end.admin.all-online.index',
                compact('specialities')
            );
       
    
    }

    public function moredoc($request)
    {

        /*If request for view more doc*/
        $special = Service::with('users')->where('id', $request)->get();
        /*Get doctors from all users array*/
        $specialities = Helper::getDoctorsFromArray($special);

        return View::make(
                'back-end.admin.all-online.view-more',
                compact('specialities')
            );
        


    }
    public function doctors()
    {       
        $doctors = User::role('doctor')->select('*');
    
        $users = $doctors->get();
      
            return View::make(
                'back-end.admin.all-doctors.index',
                compact('users')
            );
    }

    public function extendDoctors()
    {
        $doctors = User::role('doctor')->with('profile')->with('appointments')->with('feedbacks')->with('answers')->with('question')->with('answers')->select('*');
        $doctors = $doctors->get();

        /*Count docs having feedbacks / review using helper function*/
        $countFeed = Helper::getCountFeedbacks($doctors);

        /*Get count for doctors complete profile*/
        $extended = Helper::getExtended($doctors);

        /*Get count for doctors without schedular and video*/
        $without = Helper::withoutVS($doctors);

        /*Get count for doctors without schedular and video*/
        $withoutVSA = Helper::withoutVSA($doctors);

        /*Get count for doctors mark as red*/
        $markRed = Helper::markRed($doctors);

        /*Get count for doctors With vedio schedular Appt*/
        $withVSA = Helper::withVSA($doctors);


            return View::make(
                'back-end.admin.all-extend.index',
                compact('doctors','countFeed','extended','without','withoutVSA','markRed','withVSA')
            );
    }
}

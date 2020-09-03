<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Disease;
use App\Location;
use App\Speciality;
use App\User;
use View;
use Helper;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentBookingController extends Controller
{
    //
    public function callAppointmentBooking (Request $request)
    {
        if ($request['phone_number']) {
            if (strlen($request['phone_number']) >11) {
                $request['phone_number'] = str_replace('92','0',$request['phone_number']);
                $user = User::where('phone_number', $request['phone_number'])->first();
            }
            elseif (strlen($request['phone_number']) < 11) {
                $request['phone_number'] = '0'.$request['phone_number'];
                $user = User::where('phone_number', $request['phone_number'])->first();
            }
            else {
                $user = User::where('phone_number', $request['phone_number'])->first();
            }
        }
        if ($user === null) {
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'verification_code' => strtoupper('msnsoft'),
                'slug' => filter_var($request['first_name'], FILTER_SANITIZE_STRING) . '-' . filter_var($request['last_name'], FILTER_SANITIZE_STRING),
                'password' => password_hash('', PASSWORD_DEFAULT),
                'phone_number' => $request['phone_number'],
            ]);
        }
        $role = DB::table('roles')->select('name')->where('role_type', 'patient')->first();
        $user->assignRole($role->name);
        $request->patient_id = $user->id;
        $app = new Appointment;
        $app->user_id = $request->user_id;
        $app->hospital_id = $request->hospital;
        $app->patient_id = $request->patient_id;
        $app->patient_name = $request->first_name.' '.$request->last_name;
        $app->comments = $request->comments;
        $app->appointment_time = $request['appointment']['time'];
        $app->appointment_date = $request['appointment']['date'];
        $app->status = 'pending';
        $app->type = $request->type;
        $app->follow_up = $request->follow_up;
        $app->booked = $request->booked;
        $app->direct_booking = $request->direct_booking;
        $app->notes = $request->notes;
        $app->charges = $request->charges;
        $app->save();
    }

    public function onlineAppointmentBooking () {

        $doctors = User::role('doctor')->with('diseases')->with('specialities')->with('location')->with('services')->with('profile')->with('location')->with('feedbacks')->with('doc_teams')->with('teams')->with('appointments')->with('roles')->get();
        $hospitals = User::role('hospital')->with('diseases')->with('specialities')->with('location')->with('services')->with('profile')->with('location')->with('feedbacks')->with('doc_teams')->with('teams')->with('appointments')->with('roles')->get();
        $specialities = Speciality::where('top',1)->get();
        $diseases = Disease::all();
        $locations = Location::all();
        return view('back-end.csr.bookings.onlineBookingConsultation', compact('doctors', 'hospitals', 'specialities', 'diseases', 'locations'));
    }
    public function visit_appointment(){
        $appointments = Appointment::where('type','visit')->get();
        return view('back-end.admin.appointment-booking-system.visit_appointment',compact('appointments'));
    }
      public function delete_visit(Request $request)
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
          Appointment::where('id', $id)->delete();
      
            $json['type'] = 'success';
            $json['message'] = 'Visit Apointment Deleted Successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
    public function online_appointment(){
        $appointments = Appointment::where('type','online')->get();
        return view('back-end.admin.appointment-booking-system.online_appointment',compact('appointments'));
    }
     public function delete_online(Request $request)
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
          Appointment::where('id', $id)->delete();
      
            $json['type'] = 'success';
            $json['message'] = 'Online Apointment Deleted Successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
}

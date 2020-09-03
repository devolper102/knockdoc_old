@extends('back-end.master')
@push('backend_stylesheets')
<style type="text/css">
	
</style>

@endpush
@section('content')
@include('includes.pre-loader')
    <div class="dc-services" id="services">
    	  @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
 <section class="dc-haslayout">
  <div class="row">
                        
                       
                        @if ($appointments->count() > 0)
                        <div class="col-md-12">
                        
                            <!-- Recent Orders -->
                            <div class="card card-table">
                                <div class="card-header">
                                    <h4 class="card-title">Visit Appointments</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover dt-responsive nowrap"id="visit_appointment_table">
                                            <thead>
                                                <tr>
                                                    <th>Doctor Name</th>
                                                    <th>Hospital Name</th>
                                                    <th>Patient Name</th>
                                                     <th>Speciality</th> 
                                                    <th>Apointment Time</th>
                                                    <th class="text-right">Amount</th>
                                                    <th class="action">{{{ trans('lang.action') }}}</th>
                                                    <th class="none">Status</th>
                                                    <th class="none">Type</th>
                                                    <th class="none">Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as  $key => $appointment)

                                                <tr>
                        @php
                            $app_doctor = App\User::where('id',$appointment->user_id)->with('profile')->first();
                            
                        @endphp

                                                    <td>
                                                            <a href="/profile/{{clean($app_doctor->slug)}}">{{Helper::getUserData($app_doctor->id)}}</a>
                                                    </td>
                        @php
                            $app_hospital = App\User::where('id',$appointment->hospital_id)->with('profile')->first();
                            
                        @endphp                        
                                                     <td>
                                                            <a href="/profile/{{clean($app_hospital->slug)}}">{{Helper::getUserData($app_hospital->id)}}</a>
                                                    </td>  
                        @php

                            $app_patient = App\User::where('id',$appointment->patient_id)->with('profile')->first();

                        @endphp                       
                                                    <td>
                                                            <b>{{Helper::getUserData($app_patient->id)}}</b>
                                                    </td>        
                                                    <td>Anesthesiology</td>

                                                    <td>{{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}}<span class="text-primary d-block">{{$appointment->appointment_time}}</span></td>
                                                   <td class="text-right">
                                                        Rs{{$appointment->charges}}
                                                    </td>
                                                    <td>
                                                    <div class="dc-actionbtn">
                                                        <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ $appointment->id }}'" :message="'{{'Visit Apointment Deleted Successfully'}}'" :url="'{{url('admin/visit-appointment/delete')}}'" :redirect_url="'{{url('admin/visit-appointment')}}'"></delete>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    {{$appointment->status}}
                                                        
                                                    </td>
                                                    <td>
                                                        {{$appointment->type}}
                                                    </td>
                                                    
                                                      <td>
                                                       {!!$appointment->comments!!}
                                                    </td>
                                                </tr>
                                                <div id="message"></div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /Recent Orders -->
                            
                        </div>
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
       </section>                  	
</div>
@endsection
@push('scripts')
@stack('backend_scripts')
<script type="text/javascript">
     
      jQuery(document).ready(function() {
        jQuery('#visit_appointment_table').DataTable();
      } );

    </script>
@endpush

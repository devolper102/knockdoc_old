@extends('back-end.master')
<?php use App\UserMeta;?>
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        table>tbody>tr>td{
            text-align: left;
        }
        #example{
            width: 100% !important;
        }
        .dtr-details{
            width: 100%;
        }
        .dtr-details li{
            float: none !important;
        }
    </style>
@endpush
@section('content')
@include('includes.pre-loader')
    <div class="dc-specialities" id="specialities">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='100' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='100' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="dc-haslayout">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel">
                            <h2>Activated Doctors</h2>
                        </div>
                        
                        @if ($users->count() > 0)
                            <div class="dc-dashboardboxcontent dc-categoriescontentholder">
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Speciality</th>
                                            <th>Category</th>
                                            <th>Fee</th>
                                            <th>Doc Degree</th>
                                            <th>Email</th>
                                            <th>Monday</th> 
                                            <th>Tuesday</th> 
                                            <th>Wednesday</th> 
                                            <th>Thursday</th> 
                                            <th>Friday</th> 
                                            <th>Saturday</th> 
                                            <th>Sunday</th> 
                                            <th>aptPh</th> 
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @php $counter = 
                                        0; @endphp
                                        @foreach ($users as $key => $user)
                                                @if($user->user_verified == '1' && $user->profile->services != null)
                                            <tr class="del-{{{ $user->id }}}">
                                               
                                                <td>{{$user->id}}</td>
                                                <td><b>{{{ html_entity_decode(clean($user->first_name)) ?? ''.' '.$user->last_name ?? '' }}}</b></td>

                                                <td>
                                                <?php 
                                                    $service = $user->profile->services; 
                                                     $user_specialities = !empty($service) ? Helper::getUnserializeData($service) : array();
                                                    
                                                    if (!empty($user_specialities)) {
                                                    foreach ($user_specialities as $key => $user_speciality) {
                                                        if($key == '0'){
                                                        $speciality = Helper::getSpecialityByID($user_speciality['speciality_id']);
                                                        echo $speciality->title;
                                                      
                                                   ?>
                                                </td>

                                                <td>
                                                <?php   
                                                
                                                if(isset($user_speciality['services'][0])){
                                                   
                                                $service = Helper::getServiceByID($user_speciality['services'][0]['service']);
                                                if($service ==''){
                                                }
                                                else{
                                                    echo $service->title;
                                                }

                                                   
                                               
                                                 ?>  </td>
                                                 <td><?php echo $user_speciality['services'][0]['price']; ?></td>
                                                 <?php
                                                    } else {?>
                                                        <td></td>
                                                   <?php }}}} ?>
                                                <td>
                                                    <?php 
                                                        $education = UserMeta::where('user_id', $user->id)->pluck('educations')->first();
                                                        $experiences = !empty($education) ? Helper::getUnserializeData($education) : array();
                                                    if (!empty($experiences)) {
                                                        foreach ($experiences as $key => $value) {
                                                            if($key == '0'){
                                                                    echo $value['degree_title'];
                                                            } else {

                                                                     echo ', '.' ',$value['degree_title'];
                                                            }
                                                        }
                                                    }    

                                                ?></td>
                                                    <td>{{{ html_entity_decode(clean($user->email))}}}</td>
                                                    
                                                    <?php  $days = UserMeta::where('user_id', $user->id)->pluck('available_days')->first(); 
                                                         $avDays = !empty($days) ? json_decode($days, true) : array();
                                                        
                                                        if(in_array('mon',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; } 

                                                        if(in_array('tue ',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; }

                                                         if(in_array('wed  ',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; }

                                                        if(in_array('thu   ',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; }

                                                        if(in_array('fri',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; }

                                                        if(in_array('sat',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; }

                                                        if(in_array('sun',$avDays)){ ?>
                                                           <td>1</td>
                                                        <?php  } else { echo '<td>0</td>'; } ?>
                                                        
                                                        <td>{{{ html_entity_decode(clean($user->assistant_phone_number)) ?? ''}}}</td>

                                                   
                                            </tr>
                                            
                                            @php $counter++; @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                               
                            </div>
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
                </div>
                
            </div>
        </section>
    </div>
    <style type="text/css">
        #example_wrapper {

            overflow-x: auto;
        }
    </style>
@endsection
@push('scripts')
@stack('backend_scripts')
<script type="text/javascript">
    

   jQuery(document).ready(function() {
    jQuery('#example').DataTable();
} );
</script>
@endpush

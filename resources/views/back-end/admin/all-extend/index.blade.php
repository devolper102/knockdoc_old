@extends('back-end.master')
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        table>tbody>tr>td{
            text-align: left;
        }
    </style>
@endpush
@section('content')
@include('includes.pre-loader')
    <div class="dc-doctors" id="doctors">
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding: 0px;">
                    <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel table-responsive" style="padding:0px;">
                            <h2 style="margin: 13px 0 13px 50px;float: none;">All Extended Doctors</h2>
                           <table id="roles" class="table-bordered table-striped dt-responsive nowrap" style="width: 100%;">
                             <thead style="font-size: 12px;">
                               <tr>
                                 <th>Total</th>
                                 <th>Complete Profile</th>
                                 <th>Without(Video, schedular)</th>
                                 <th>Without(Video, schedular, Appt#)</th>
                                 <th>Doctors having Reviews</th>
                                 <th>Mark as Red</th>
                                 <th>with (picture, Appt#, schedular, Reviews, A.O.I)</th>
                               </tr>
                             </thead>
                             <tbody>
                               <tr>
                                 <td>{{count($doctors)}}</td>
                                 <td>{{count($extended)}}</td>
                                 <td>{{$without}}</td>
                                 <td>{{$withoutVSA}}</td>
                                 <td>{{$countFeed}}</td>
                                 <td>{{$markRed}}</td>
                                 <td>{{$withVSA}}</td>
                               </tr>
                             </tbody>
                           </table>
                        </div>
                        @if (count($doctors) > 0)
                        <br>
                          <div class="dc-dashboardboxcontent dc-categoriescontentholder table-responsive">
                                <table id="example" class="table-bordered table-striped dt-responsive nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                          <th>ID</th>
                                          <th>Name</th>
                                          <th>Picture</th>
                                          <th>Phone</th>
                                          <th>Appt Phone</th>
                                          <th>Reviews</th>
                                          <th>Fourm Answers</th>
                                          <th>Schedular</th>
                                          <th>Speciality</th>
                                          <th>City</th>
                                          <th>Mark Red</th>
                                          <th>Visit Profile</th>
                                          <th>Edit</th>
                                          <th>Completed</th>
                                          <th>Ext Profile Created Date</th>
                                          <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @php
                                      $i = 0;
                                      @endphp
                                        @foreach ($extended as $key => $doc)

                                      <tr>

                                        <?php
                                        $service = $doc->profile->services; 
                                        $user_specialities = !empty($service) ? Helper::getUnserializeData($service) : array();
                                        ?>
                                        
                                        <td>{{$i++}}</td>
                                        <td>{{$doc->first_name.' '.$doc->last_name}}</td>
                                        @if(empty($doc->profile->avatar))
                                        <td style="background: red;"></td>
                                        @else
                                        <td><img style="display:block;" width="50px" height="50px" src="{{url('uploads/users/'.$doc->id.'/'.$doc->profile->avatar)}}"></td>
                                        @endif
                                        @if(empty($doc->phone_number))
                                        <td style="background: red;"></td>
                                        @else
                                        <td>{{$doc->phone_number}}</td>
                                        @endif
                                        @if(empty($doc->assistant_phone_number))
                                        <td style="background: red;"></td>
                                        @else
                                        <td>{{$doc->assistant_phone_number}}</td>
                                        @endif
                                        <td>{{count($doc->feedbacks) ?? '0'}}</td>
                                        @if(count($doc->question) > count($doc->answers))
                                        <td  style="background: red;"><?php echo count($doc->answers).'/'. count($doc->question); ?></td>
                                        @else
                                        <td><?php echo count($doc->answers).'/'. count($doc->question); ?></td>
                                        @endif
                                        @if($doc->profile->available_days ==null)
                                        <td style="background: red;"></td>
                                        @else
                                        <td>{{(!empty($doc->profile->available_days) || $doc->profile->available_days !=null) ?? 'yes' }}</td>
                                        @endif
                                        <td>
                                          <?php 
                                          if(isset($user_specialities[0]['speciality_id'])){
                                          $speciality = Helper::getSpecialityByID($user_specialities[0]['speciality_id']);
                                          echo $speciality->title; }?></td>
                                        <td>{{{ html_entity_decode(clean($service = Helper::getLocationByID($doc->location_id)->title)) }}}</td>
                                        @if($doc->profile->mark_red == 'on')
                                        <td style="background: red;"></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                         <td class="{{$key}}">
                                                                   
                                          <a style="color: #3fabf3" target="_blank" href="{{ url('/profile/'.$doc->slug)}}">Visit</a>
                                                                    
                                        </td>
                                        <td class="{{$key}}">
                                                                   
                                          <a style="color: #3fabf3" target="_blank" href="{{ url('admin/edit-user/'.$doc->id)}}">Edit</a>
                                                                    
                                        </td>
                                        <td>
                                          {{($doc->profile->mark_incomplete == 'on') ? '' : 'completed'}}
                                        </td>
                                        <td>
                                          {{Carbon\Carbon::parse($doc->profile->created_extend)->format('m/d/Y') }}
                                        </td>
                                        <td>
                                          {{$doc->created_at->format('m/d/Y') ?? '' }}
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>  
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
                </div>
  
            </div>

        </section>
    </div>
  
@endsection
@push('scripts')
@stack('backend_scripts')

 <script type="text/javascript">
    

   jQuery(document).ready(function() {
    jQuery('#example').DataTable();
    jQuery('#roles').DataTable();
} );

</script>

@endpush

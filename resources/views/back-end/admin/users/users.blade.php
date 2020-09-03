@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        /*table>tbody>tr>td{
            text-align: left;
        }*/
        #roles{
            width: 100% !important;
        }
        #account_settings{
            padding-bottom: 50px;
        }
        .card {
            border: 1px solid #f0f0f0;
            margin-bottom: 1.875rem;
        }
        .dash-count {
            font-size: 18px;
            margin-left: auto;
        }
        .dash-widget-header {
            align-items: center;
            display: flex;
            margin-bottom: 15px;
        }
        .progress.progress-sm {
            height: 6px;
        }
        h1,h2,h3,h4,h5,h6{
            font-weight: 400 !important;
        }
        .dash-widget-icon {
            align-items: center;
            display: inline-flex;
            font-size: 1.875rem;
            height: 50px;
            justify-content: center;
            line-height: 48px;
            text-align: center;
            width: 50px;
            border: 3px solid;
            border-radius: 50px;
            padding: 28px;
        }
    </style>
@endpush
@section('content')
    <section class="dc-haslayout" id="account_settings">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='500' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <div class="dc-preloader-section" v-if="is_loading" v-cloak>
            <div class="dc-preloader-holder">
                <div class="dc-loader"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                @if (Session::has('message'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="dc-dashboardbox">
                    <div class="dc-dashboardboxtitle dc-titlewithsearch">
                            <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                 <h3>{{{ 'All '.$role.'s' }}}</h3>
                               <!--  <ul class="breadcrumb">
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    @if($role ==='doctor')
                      @php
                            $alldoctors = App\User::role('doctor')->get(); 
                            $extended_doctors = Helper::getExtended($alldoctors);
                        @endphp
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-primary border-primary">
                                            <i class="fa fa-user-md"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>{{count($alldoctors)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Doctors</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary"style="width: {{count($alldoctors)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-success">
                                            <i class="fa fa-arrows-alt"></i>
                                        </span>
                                        <div class="dash-count">
                                        <h3>{{count($extended_doctors)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Extend Doctors</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"style="width: {{count($extended_doctors)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-warning border-warning">
                                             <i class="fa fa-plus-square"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Requested Doctors</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning"style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-danger border-danger">
                                            <i class="fa fa-exclamation-circle"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Spam Doctors</h6>
                                        <div class="progress progress-sm">
                                            
                                            <div class="progress-bar bg-danger" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    @endif
                     @if($role ==='hospital')
                      @php
                            $allhospitals = App\User::role('hospital')->get(); 
                            $extended_hospitals = Helper::getExtended($allhospitals);
                        @endphp
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-primary border-primary">
                                            <i class="fa fa-hospital-o"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>{{count($allhospitals)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Hospitals</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary"style="width: {{count($allhospitals)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-success">
                                            <i class="fa fa-arrows-alt"></i>
                                        </span>
                                        <div class="dash-count">
                                        <h3>{{count($extended_hospitals)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Extend Hospitals</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"style="width: {{count($extended_hospitals)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                       <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-warning border-warning">
                                             <i class="fa fa-plus-square"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Requested Hospitals</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning"style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-danger border-danger">
                                            <i class="fa fa-exclamation-circle"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Spam Hospitals</h6>
                                        <div class="progress progress-sm">
                                            
                                            <div class="progress-bar bg-danger" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    @endif
                      @if($role ==='laboratory')
                      @php
                            $alllaboratory = App\User::role('laboratory')->get(); 
                            $extended_alllaboratory = Helper::getExtended($alllaboratory);
                        @endphp
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-primary border-primary">
                                            <i class="fa fa-flask"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>{{count($alllaboratory)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Laboratories</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary"style="width: {{count($alllaboratory)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-success">
                                            <i class="fa fa-arrows-alt"></i>
                                        </span>
                                        <div class="dash-count">
                                        <h3>{{count($extended_alllaboratory)}}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Extend Lab</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"style="width: {{count($extended_alllaboratory)/100}}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-warning border-warning">
                                             <i class="fa fa-plus-square"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Requested Lab</h6>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning"style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-danger border-danger">
                                            <i class="fa fa-exclamation-circle"></i>
                                        </span>
                                        <div class="dash-count">
                                           <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        
                                        <h6 class="text-muted">Spam Lab</h6>
                                        <div class="progress progress-sm">
                                            
                                            <div class="progress-bar bg-danger" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    @endif
                        <div class="dc-rightarea">
                            <form action="{{ route('adminAddUser')}}" method="get">
                                <input type="hidden" name="role" value="{{{$role}}}">
                                <input type="submit" name="submit"class="dc-btn" value="Add new {{$role}}">
                            <!-- <a href="{{ route('adminAddUser')}}" class="dc-btn">Add new user</a> -->
                            </form>
                        </div>
                    </div>
                    <div class="dc-dashboardboxcontent dc-categoriescontentholder table-responsive">
                        @if (!empty($role_based_users))
                    <table id="roles"class="blank_td table table-bordered table-hover dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>{{{ trans('lang.user_name') }}}</th>
                                        <th>{{{ trans('lang.ph_email') }}}</th>
                                        <th class="none">{{{ trans('lang.role') }}}</th>
                                        @if($role !== 'hospital')
                                            <th class="none">Appointments</th>
                                        @endif
                                       
                                        @if($role === 'hospital')
                                            <th class="none">Onboard Doctors</th>
                                        @endif
                                        <th class="none">{{{ trans('lang.medical_verified') }}}</th>
                                        <th class="none">{{{ trans('lang.user_verified') }}}</th>
                                        <th>{{{ trans('lang.action') }}}</th>
                                         @if($role === 'doctor')
                                            <th class="none">Hospitals</th>
                                        @endif
                                        <th class="none">Area</th>
                                        <th class="none">City</th>
                                        <th class="none">Address</th>
                                        <th class="none">Longitude</th>
                                        <th class="none">Latitude</th>
                                        <th class="none">Phone</th>
                                        <th class="none">Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($role_based_users as $key => $user_data)
                                        @php
                                            $verify_medical = Helper::getUnserializeData($user_data->profile->verify_medical);
                                        @endphp
                                        @if ($role != 'admin')
                                            <tr class="del-{{{ $user_data->id }}}">
                                                <td>{{{ ucwords(\App\Helper::getUserName($user_data->id)) }}}</td>
                                                <td>{{{ clean($user_data->email) }}}</td>
                                                <td>{{ $user_data->getRoleNames()->first() }}</td>
                                                @if ($role !=='hospital')
                                                    @if ($role === 'doctor')
                                                        <td><a href="{{url($role.'/appointments',['id' => $user_data->id])}}">{{ count($user_data->appointments) }}</a></td>
                                                    @else
                                                        <td><a href="{{url($role.'/appointments',['id' => $user_data->id])}}">{{ count($user_data->appointments_patient) }}</a></td>
                                                    @endif
                                                @endif
                                              
                                                @if($role === 'hospital')
                                                    <td><a href="{{route('manageTeams',['id' => $user_data->id])}}">{{ count($user_data->teams) }}</a></td>
                                                @endif
                                        @if (!empty($verify_medical))
                                                    <td>
                                                        {{ html_entity_decode(clean($verify_medical['registration_number'])) }}</br>
                                                        <a href="{{{route('getfile', ['type'=>'users', 'id'=>clean($user_data->id), 'attachment'=>$verify_medical['registration_document']])}}}">
                                                            {{ trans('lang.download') }}
                                                        </a>
                                                    </td>
                                                @elseif ($role == 'patient')
                                                    <td>{{ trans('lang.not_available') }}</td>
                                                @else
                                                    <td>{{ trans('lang.not_uploaded') }}</td>
                                                @endif
                                                <td id="verify_cell-{{$user_data->id}}">
                                        @if ($user_data->profile->verify_registration == 1)
                                                        <a href="javascript:;" class="" v-on:click.prevent="verifiedUser('verify_cell-{{$user_data->id}}', '{{$user_data->id}}', 'not_verify')">{{ trans('lang.verified') }}</a>
                                            @elseif ($role == 'patient')                                                        
                                                        <a href="javascript:;">{{ trans('lang.not_available') }}</a>
                                                    @else
                                                        <a href="javascript:;" class="" v-on:click.prevent="verifiedUser('verify_cell-{{$user_data->id}}', '{{$user_data->id}}', 'verify')">{{ trans('lang.not_verified') }}</a>
                                                    @endif
                                                </td>
                                                           <td>
                                                    <div class="dc-actionbtn">
                                                        <a href="{{ route('adminEditUser',$user_data->id) }}" class="dc-addinfo dc-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'{{trans("lang.ph.delete_confirm_title")}}'" :id="'{{$user_data->id}}'" :message="'{{trans("lang.user_deleted")}}'" :url="'{{url('admin/delete-user')}}'"></delete>
                                    @if ($role != 'patient')
                                                            <a href="{{ url('profile/'.clean($user_data->slug)) }}" class="dc-addinfo dc-skillsaddinfo"><i class="lnr lnr-eye"></i></a>
                                                        @else
                                                            <a href="javascript:;" class="dc-addinfo dc-skillsaddinfo disable-eye"><i class="lnr lnr-eye"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                                  @if($role === 'doctor')
                                                    <td><a href="#">{{ count($user_data->doc_teams) }}</a></td>
                                                @endif

                                                        <td>{{{ clean(@$user_data->location->title) }}}</td>
                                                 

                                               
                                @if (@$user_data->location->parent != 0)
                                   @php
                                        $find_id = clean($user_data->location->parent);
                                        $location_data =   \App\Location::find(intVal(clean($find_id)));

                                    @endphp

                                                 <td>{{ $location_data->title }} </td>
                                                
                                  
                                @else
                                                  <td></td>
                                @endif  
                                                 
                                      
                                                 <td>{{{ clean(@$user_data->profile->address) }}}</td>
                                                 <td>{{{ clean(@$user_data->profile->longitude) }}}</td>
                                                 <td>{{{ clean(@$user_data->profile->latitude) }}}</td>
                                                 <td>{{{ clean($user_data->phone_number) }}}</td>
                                                 <td>{{{ clean($user_data->created_at) }}}</td>
                                               
                                            
                                            </tr>
                                            @else 
                                            exit();
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                                @include('extend.errors.no-record')
                            @else
                                @include('errors.no-record')
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@stack('backend_scripts')
<script src="{{ asset('js/jquery.basictable.min.js') }}"></script>
<!-- <script type="text/javascript">
    jQuery('.dc-table-responsive').basictable({
            breakpoint: 767,
    });
</script> -->
<script>
    

   $(document).ready(function() {
    $('#roles').DataTable();
} );
</script>
@endpush
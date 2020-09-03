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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                   <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel">
                            <h2>Manage Roles</h2>
                        </div>
                        @if ($roles->count() > 0)
                           <div class="dc-dashboardboxcontent dc-categoriescontentholder table-responsive">
                                <table id="department"  class="table table-bordered table-hover dt-responsive nowrap"cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role Type</th>
                                            <th>Guard Name</th>
                                            <th class="action">{{{ trans('lang.action') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{$role->name}}</td>
                                                <td>{{$role->role_type}}</td>
                                                <td>{{$role->guard_name}}</td>
                                                <td>
                                                    <div class="dc-actionbtn">
                                                        <a href="{{action('RolesController@edit',$role->id) }}" class="dc-addinfo dc-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                
                                                    <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ intVal(clean($role->id)) }}'" :message="'{{trans("Role Deleted Successfully")}}'" :url="'{{url('admin/role/delete')}}'" :redirect_url="'{{url('admin/role')}}'"></delete>

                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ( method_exists($roles,'links') )
                                    {{ $roles->links('pagination.custom') }}
                                @endif
                            </div>
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
                </div>
            </div>    
     <div class="row">       
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-6">
        <div class="dc-dashboardbox">
            <div class="dc-dashboardboxtitle dc-titlewithsearch dc-titlewithdel">

                        	<h2>Add New Role</h2>
                <div class="dc-dashboardboxtitle">

                    <form action="{{ url('admin/store-role') }}"method="post"> 
                        {{csrf_field()}}
                        <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Role Name" />
                                    @if ($errors->has('name'))  
                                           <p class="text-danger">{{$errors->first('name')}}</p>   
                                    @endif  
                                </div>
                              
                             <div class="form-group">
                                    <input type="text" name="role_type" id="tag2" class="form-control" placeholder="Enter Role Type" />
                                    @if ($errors->has('role_type'))  
                                           <p class="text-danger">{{$errors->first('role_type')}}</p>   
                                    @endif  
                                </div>
                                <div class="form-group">
                                    <input type="text" name="guard_name" id="tag2" class="form-control" placeholder="Enter Guard Name" />
                                    @if ($errors->has('guard_name'))  
                                           <p class="text-danger">{{$errors->first('guard_name')}}</p>   
                                    @endif  
                                </div>
                                <div class="form-group dc-btnarea">
                                       <button type="submit" name="submit" class="dc-btn">Create Role</button>
                                </div>      
                                   
                        </div> 

                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>                    	
    </div>
       </section>                  	
</div>
@endsection
@push('scripts')
@stack('backend_scripts')
<script type="text/javascript">
      $(document).ready(function() {
        $('#department').DataTable();
      } );
</script>
@endpush

@extends('back-end.master')
@push('backend_stylesheets')
 <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
    <style>
        .action {
            width: 80px !important;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.css">
        <style>
        /* autocomplete tagsinput*/
        .label-info {
            background-color: #5bc0de;
            display: inline-block;
            padding: 0.2em 0.6em 0.3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 2;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25em;
        }
        .bootstrap-tagsinput{
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: inline-block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;width: 100%;
            line-height: 22px;
            cursor: text;
        }
        .bootstrap-tagsinput input{
            border:none;
            padding: 0px;
            height: 30px;
        }
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            content: "x";
            padding: 0px 4px;
            cursor: pointer;
        }
        .tt-menu {
            float: left;
            min-width: 90px;
            padding: 5px;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
            cursor: pointer;
        }
        .action {
            width: 80px !important;
        }
    </style>
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
                            <h2>Manage Surgeries</h2>
                        </div>
                        @if ($procedures->count() > 0)
                           <div class="dc-dashboardboxcontent dc-categoriescontentholder table-responsive">
                                <table id="procedure"  class="table table-bordered table-hover dt-responsive nowrap"cellspacing="0">
                                    <thead>
                                        <tr>
                                          
                                            <th>Name</th>
                                            <th>Fee</th>
                                            <th>Doctors/Hospitals</th>
                                            
                                            <th class="action">{{{ trans('lang.action') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @php $counter = 0; @endphp
                                        @foreach ($procedures as $key => $procedure)
                                        
                                            <tr class="del-{{{ $procedure->id }}}">
                                                
                                                <td>{{$procedure->name}}</td>
                                                <td>{{$procedure->fee}}</td>
                                                <td>
                                                @foreach($procedure->users as $user)
                                                    {{Helper::getUserData($user->id)}}<br />
                                               @endforeach
                                                </td>
                                                <td>
                                                    <div class="dc-actionbtn">
                                                        <a href="{{action('ProcedureController@edit',$procedure->id) }}" class="dc-addinfo dc-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                
                                                    <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ intVal(clean($procedure->id)) }}'" :message="'{{trans("Precedure Deleted Successfully")}}'" :url="'{{url('admin/procedure/delete')}}'" :redirect_url="'{{url('admin/procedure')}}'"></delete>
                                               

                                                       

                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ( method_exists($procedures,'links') )
                                    {{ $procedures->links('pagination.custom') }}
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

                        	<h2>Add New Surgery</h2>
                <div class="dc-dashboardboxtitle">

                    <form action="{{ url('admin/store-procedure') }}"method="post"> 
                        {{csrf_field()}}
                        <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="name"  class="form-control" placeholder="Enter Name" />
                                    @if ($errors->has('name'))  
                                          <br>
                                           <p class="text-danger">{{$errors->first('name')}}</p>   
                                    @endif  
                                    
                                </div>
                                <div class="form-group">
                                    <input type="text" name="fee"  class="form-control" placeholder="Enter Fee" />
                                     @if ($errors->has('fee'))  
                                          <br>
                                           <p class="text-danger">{{$errors->first('fee')}}</p>   
                                    @endif  
                                </div>
                                   <div class="form-group">
                                    <input type="text" name="doctor" id="tag1" class="form-control" placeholder="Enter Doctor/Hospital"
                                           style="display: none;"/>
                                    @if ($errors->has('doctor'))  
                                          <br>
                                           <p class="text-danger">{{$errors->first('doctor')}}</p>   
                                    @endif 
                                </div> 
                                 <div class="form-group">
                                    <input type="text" name="color"  class="form-control" placeholder="Enter Color" />
                                </div>

                                  <div class="dc-settingscontent form-group">
                                    <div class = "dc-formtheme dc-userform"style="float: left;">
                                        <upload-media
                                                :img="'procedure_image'"
                                                :img_id="'procedure_image'"
                                                :img_name="'procedure_image'"
                                                :img_ref="'procedure_image'"
                                                :img_hidden_name="'procedure_image'"
                                                img_hidden_id="'procedure_image'"
                                                :url="'{{ url("media/upload-temp-image/procedure/procedure_image/procedure") }}'"
                                        >
                                        </upload-media>
                                    </div>
                                </div>
                                <div class="form-group dc-btnarea">
                                       <button type="submit" name="submit" class="dc-btn">Create Surgery</button>
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
 <script src="{{ asset('js/jquery.basictable.min.js') }}"></script>
    <script type="text/javascript">
      jQuery('.dc-table-responsive').basictable({
        breakpoint: 767,
      });
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script>
      
      var data = JSON.stringify({!!json_encode($result)!!});
        /*'[' +
        ' { "value": 2, "text": "Task 2"},' +
        ' { "value": 3, "text": "Task 3"},' +
        ' { "value": 4, "text": "Task 4"},' +
        ' { "value": 5, "text": "Task 5"},' +
        ' { "value": 6, "text": "Task 6"} ]';*/

      //get data pass to json
      var task = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("first_name"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: jQuery.parseJSON(data) //your can use json type
      });

      task.initialize();

      var elt = $("#tag1");
      elt.tagsinput({
        itemValue: "id",
        itemText: "first_name",
        typeaheadjs: {
          name: "id",
          displayKey: "first_name",
          source: task.ttAdapter()
        }
      });

      //insert data to input in load page
      /*elt.tagsinput("add", {
        value: 1,
        title: "task",
      });*/

    </script>
<script type="text/javascript">
      $(document).ready(function() {
        $('#procedure').DataTable();
      } );
</script>
   
@endpush

@extends('back-end.master')
@push('backend_stylesheets')
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
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
    </style>
@endpush
@section('content')
    @include('includes.pre-loader')
    <div class="dc-locations-edit" id="locations">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="dc-haslayout la-editcategory">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-6 float-left">
                    <div class="dc-dashboardbox">
                        <div class="dc-dashboardboxtitle">
                            <h2>{{{ trans('lang.update_disease') }}}</h2>
                        </div>
                        <div class="dc-dashboardboxcontent">
                            {!! Form::open(['url' => url('admin/diseases/update/'.$disease->id.''),
                                'class' =>'dc-formtheme dc-userform dc-formprojectinfo dc-formcategory dc-updatelocation', 'id' => 'diseases-form'] )
                            !!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text( 'title', e($disease->title), ['class' =>'form-control'] ) !!}
                                    </div>
                                      <div class="form-group">
                                    <input type="text" name="speciality" id="tag2" class="form-control" placeholder="Enter Specialty/Specialties"/>
                                          @if ($errors->has('speciality'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('speciality') }}</strong>
                                        </span>
                                            @endif
                                </div>
                                    @if (!empty($disease_parent))
                                        <div class="form-group">
                                            <span class="dc-select">
                                                {!! Form::select('parent', $diseases_list, e($disease_parent), ['placeholder' => trans('lang.ph.select_parent')]) !!}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        {!! Form::textarea( 'description', e($disease->description), ['id' => 'description','class' =>'form-control',
                                        'placeholder' => trans('lang.ph_desc')] )
                                        !!}
                                    </div>
                                    <div class="dc-settingscontent form-group">
                                        @if (!empty($disease->flag))
                                            <upload-media
                                                    :img="'{{ $disease->flag }}'"
                                                    :img_id="'disease_image'"
                                                    :img_name="'disease_image'"
                                                    :img_ref="'disease_image'"
                                                    :img_hidden_name="'disease_image'"
                                                    img_hidden_id="'disease_image'"
                                                    :existed_img="'{{$disease->flag}}'"
                                                    :url="'{{ url("media/upload-temp-image/disease/disease_image/disease") }}'"
                                                    :existing_img_url="'{{ url("uploads/disease/$disease->flag") }}'"
                                                    :size = "'{{ Helper::getImageDetail($disease->flag, 'size', 'uploads/disease/') }}'"
                                                    :existing_img_name = "'{{ Helper::getImageDetail($disease->flag, 'name', 'uploads/disease/') }}'"
                                            >
                                            </upload-media>
                                        @else
                                            <upload-media
                                                    :img="'disease_image'"
                                                    :img_id="'disease_image'"
                                                    :img_name="'disease_image'"
                                                    :img_ref="'disease_image'"
                                                    :img_hidden_name="'disease_image'"
                                                    img_hidden_id="'disease_image'"
                                                    :url="'{{ url("media/upload-temp-image/disease/disease_image/disease") }}'"
                                            >
                                            </upload-media>
                                        @endif
                                    </div>
                                    <div class="form-group dc-btnarea">
                                        {!! Form::submit(trans('lang.update_disease'), ['class' => 'dc-btn']) !!}
                                    </div>
                                </fieldset>
                            {!! Form::close(); !!}
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
      <script>
      var data =JSON.stringify({!!json_encode($speciality)!!});
      var stored_data =JSON.stringify({!!json_encode($spe_tags)!!});
      //get data pass to json
      var task = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("title"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: jQuery.parseJSON(data) //your can use json type
      });

      task.initialize();

      var elt = $("#tag2");
      elt.tagsinput({
        itemValue: "id",
        itemText: "title",
        typeaheadjs: {
          name: "id",
          displayKey: "title",
          source: task.ttAdapter()
        }
      });
      populate('#tag2', stored_data);

      function populate(frm, data) {

        $.each(JSON.parse(data), function(id, title){
          $(elt).tagsinput('add', title);
        });
      }

    </script>
@endpush

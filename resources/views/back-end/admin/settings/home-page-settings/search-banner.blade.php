{!! Form::open(['url' => '', 'class' =>'dc-formtheme dc-userform', 'id' =>'home-search-banner-form', '@submit.prevent'=>'submitHomeSearchBannerSettings'])!!}
    <div class="dc-securitysettings dc-search-banner-settings dc-tabsinfo">
        <div class="dc-tabscontenttitle la-switch-option">
            <h3>{{ trans('lang.search_banner_settings') }}</h3>
            <div class="float-right">
                <switch_button v-model="show_search_banner">{{{ trans('lang.show_or_hide_section') }}}</switch_button>
                <input type="hidden" :value="show_search_banner" name="show_search_banner">
            </div>
        </div>
        <div class="dc-sidepadding">
            <div class="dc-formtheme dc-userform">
                 @if (!empty($search_form_title))
                
                 @foreach ($search_form_title as $key => $title)
                 @if (!empty($title))
                 <div class="form-group">
                        {!! Form::text('search_form_title[]', e($title),['class' =>
                            'form-control','placeholder'=>trans('Text')]) !!}
                </div>
                @endif
                 @endforeach
                    <span id="buildyourform">  
                    </span>
                    <div class="dc-tabscontenttitle">
                    <h3>Add Multiple Small and Large text</h3>
                    </div>
    <div class="form-group" style="    width: auto;
    float: right;
    margin-top: 15px;">
    <a type="button" value="Add a field" class="add btn btn-success" id="add" style="color: white;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </div> 
                    <div class="form-group">
                        {!! Form::text('search_banner_subheading', e($search_banner_subheading), ['class' =>
                            'form-control','placeholder'=>trans('Background Color')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('search_banner_btn_title', e($search_banner_btn_title), ['class' =>
                            'form-control','placeholder'=>trans('Wave Color')]) !!}
                    </div>
                       <div class="dc-settingscontent dc-dbsectionspace  upload-imgresizehold">
                        <div class="dc-formtheme dc-userform">
                            @if (!empty($search_banner_img))
                                <upload-media
                                :title="'{{ trans('lang.search_banner_image') }}'"
                                :img="'{{ $search_banner_img }}'"
                                :img_id="'search_banner_img'"
                                :img_name="'search_banner_img'"
                                :img_ref="'search_banner_img'"
                                :img_hidden_name="'hidden_search_banner_img'"
                                :img_hidden_id="'hidden_search_banner_img'"
                                :existed_img="'{{$search_banner_img}}'"
                                :url="'{{ url("media/upload-temp-image/settings/search_banner_img/banner_img") }}'"
                                :existing_img_url="'{{ url("uploads/settings/home/$search_banner_img") }}'"
                                :size = "'{{ Helper::getImageDetail( $search_banner_img, 'size', 'uploads/settings/home') }}'"
                                :existing_img_name = "'{{ Helper::getImageDetail( $search_banner_img, 'name', 'uploads/settings/home') }}'"
                                >
                                </upload-media>
                            @else
                                <upload-media
                                :title="'{{ trans('lang.search_banner_image') }}'"
                                :img="'search_banner_img'"
                                :img_id="'search_banner_img'"
                                :img_name="'search_banner_img'"
                                :img_ref="'search_banner_img'"
                                :img_hidden_name="'hidden_search_banner_img'"
                                :img_hidden_id="'hidden_search_banner_img'"
                                :url="'{{ url("media/upload-temp-image/settings/search_banner_img/banner_img") }}'"
                                >
                                </upload-media>
                            @endif
                        </div>
                    </div>
                  @else
                <fieldset>
                   
                  <div class="after-add-more"> 
                    <div class="form-group">
                        {!! Form::text('search_form_title[]', null,['class' =>
                            'form-control','placeholder'=>trans('Small Text')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('search_form_title[]', null,['class' =>
                            'form-control','placeholder'=>trans('Large Text')]) !!}
                    </div> 

                                    <div class="form-group change"align="right">
                                        <a class="btn btn-success add-more"style="color: white;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                    </div>

  
                     </div>
                                <div class="dc-tabscontenttitle">
                    <h3>Add Multiple Small and Large text</h3>
                    </div>
                    <div class="form-group">
                        {!! Form::text('search_banner_subheading', null, ['class' =>
                            'form-control','placeholder'=>trans('Background Color')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('search_banner_btn_title', null, ['class' =>
                            'form-control','placeholder'=>trans('Wave Color')]) !!}
                    </div>
                   <div class="dc-settingscontent dc-dbsectionspace  upload-imgresizehold">
                        <div class="dc-formtheme dc-userform">
                            @if (!empty($search_banner_img))
                                <upload-media
                                :title="'{{ trans('lang.search_banner_image') }}'"
                                :img="'{{ $search_banner_img }}'"
                                :img_id="'search_banner_img'"
                                :img_name="'search_banner_img'"
                                :img_ref="'search_banner_img'"
                                :img_hidden_name="'hidden_search_banner_img'"
                                :img_hidden_id="'hidden_search_banner_img'"
                                :existed_img="'{{$search_banner_img}}'"
                                :url="'{{ url("media/upload-temp-image/settings/search_banner_img/banner_img") }}'"
                                :existing_img_url="'{{ url("uploads/settings/home/$search_banner_img") }}'"
                                :size = "'{{ Helper::getImageDetail( $search_banner_img, 'size', 'uploads/settings/home') }}'"
                                :existing_img_name = "'{{ Helper::getImageDetail( $search_banner_img, 'name', 'uploads/settings/home') }}'"
                                >
                                </upload-media>
                            @else
                                <upload-media
                                :title="'{{ trans('lang.search_banner_image') }}'"
                                :img="'search_banner_img'"
                                :img_id="'search_banner_img'"
                                :img_name="'search_banner_img'"
                                :img_ref="'search_banner_img'"
                                :img_hidden_name="'hidden_search_banner_img'"
                                :img_hidden_id="'hidden_search_banner_img'"
                                :url="'{{ url("media/upload-temp-image/settings/search_banner_img/banner_img") }}'"
                                >
                                </upload-media>
                            @endif
                        </div>
                    </div>
                </fieldset>
                 @endif
            </div>
        </div>
    </div>
    <div class="dc-experienceaccordion">
        <div class="dc-updatall la-btn-setting">
            {!! Form::submit(trans('lang.btn_save'), ['class' => 'dc-btn']) !!}
        </div>
    </div>
{!! Form::close() !!}

 <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
 <script>
$(document).ready(function() {
    $("body").on("click",".add-more",function(){ 
        var html = $(".after-add-more").first().clone();   
          $(html).find(".change").html("<a class='btn btn-danger remove'style='color: white'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>");   
        $(".after-add-more").last().after(html);
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".after-add-more").remove();
    });
});
</script> 
  <script type="text/javascript">
    $(document).ready(function() {
    $("#add").click(function() {
        var lastField = $("#buildyourform div:last");
        var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        fieldWrapper.data("idx", intId);
        var fName = $("<div class=\"form-group\"> <input type=\"text\" name=\"search_form_title[]\"placeholder=\"Small Text\"class=\"fieldname form-control\" /> </div>");
        var fType = $("<input type=\"text\" name=\"search_form_title[]\"placeholder=\"Large Text\"class=\"fieldname form-control\" />");
        var removeButton = $("<a href=\"javascript:void(0)\" style=\"color:#fff;margin:15px 0;float:left;\" class=\"remove btn btn-danger\" > <i class='fa fa-minus-circle' aria-hidden='true'></i> </a>");

        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fName);
        fieldWrapper.append(fType);
        fieldWrapper.append(removeButton);
        $("#buildyourform").append(fieldWrapper);
    });
 
});

    </script> 

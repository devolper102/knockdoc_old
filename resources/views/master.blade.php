<!doctype html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <!--<![endif]-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{Helper::getTextDirection()}}">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @if (trim($__env->yieldContent('title')))
        <title>@yield('title')</title>
    @else 
        <title>{{ config('app.name') }}</title>
    @endif
    <meta name="google-site-verification" content="-_ZmedFnjBo2SgHDNNXi14NaoU06n76Wfr3uGK8MXo4" />
    <meta name="description" content="An online doctor booking platform">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="icon" href="{{ asset(Helper::getGeneralSettings('site_favicon')) }}" type="image/x-icon">
    @stack('PackageStyle')
    
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/linearicons.css') }}" rel="stylesheet">  
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
     
    {{-- <link href="{{ asset('css/everything.css') }}" rel="stylesheet">--}}
    @stack('stylesheets')
    @stack('inlineStyle')
    @php echo \App\Typo::setSiteStyling(); @endphp
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
        var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
    </script>
    @if (Auth::user())
        <script type="text/javascript">
            var USERID = {!! json_encode(Auth::user()->id) !!}
            window.Laravel = {!! json_encode([
            'csrfToken'=> csrf_token(),
            'user'=> [
                'authenticated' => auth()->check(),
                'id' => auth()->check() ? auth()->user()->id : null,
                'name' => auth()->check() ? auth()->user()->first_name : null,
                'image' => !empty(auth()->user()->profile->avatar) ? asset('uploads/users/'.auth()->user()->id .'/'.auth()->user()->profile->avatar) : asset('images/user-login.png'),
                'image_name' => !empty(auth()->user()->profile->avatar) ? auth()->user()->profile->avatar : '',
                ]
                ])
            !!};
        </script>
    @endif
    <script>
            window.trans = <?php
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            echo json_encode($trans);
            ?>;
    </script>
</head>
<body class="{{'lang-'.str_replace('_', '-', app()->getLocale())}} {{Helper::getTextDirection()}}">
    {{ \App::setLocale(env('APP_LANG')) }}
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Wrapper Start -->
    <div id="dc-wrapper" class="dc-wrapper dc-haslayout dc-closemenu">
        @if (Helper::getTopBarSettings('enable_topbar') == 'true')
            <div class="dc-topbar mobile_view_btn">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 less_padding">
                            <div class="dc-helpnum">
                                <span>{{ Helper::getTopBarSettings('title') }}</span>
                                <a class="dc-btn" href="tel:{{ clean(Helper::getTopBarSettings('number')) }}"> <i class="fas fa-phone"></i>Call Now</a>
                            </div>
                            @if (Helper::getTopBarSettings('enable_socials') === 'true')
                                <div class="dc-rightarea">
                                    @php Helper::displaySocials('topbar'); @endphp
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div id="dc_fix_Header">
          @yield('header')

          @yield('banner')
        </div>

        @yield('main')
        
        @yield('footer')
    </div>
    
    
    @yield('bootstrap_script')
  
    


    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/vendor/jquery-library.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
      CKEDITOR.replace( 'description' );
    </script>

    <!-- CkEditor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/markerclustererplus/2.1.4/markerclusterer.js"></script>

    @stack('scripts')
    
    
    <script type="text/javascript">
    
        /*$("#main_doctor_search").click(function () {
        $("#datas").addClass("absolute_search");
        $("#countryList").addClass("absolute_dropdown");
        });*/

        $("#location_main .ais-SearchBox-input").click(function () {
        //  alert("hi");
        $("#location_inner").addClass("absolute_search");
        $("#cityList").addClass("absolute_dropdown");
        });
        // Select values from serach drop down
        $(window).on('load', function() {
            $("#countryList").on("click", "#hits-instant-search-spec li", function(event){
                event.stopPropagation();
                var clone = $(this).clone()    //clone the element
                              .end()  //again go back to selected element
                              .text();
                              
            var word = $(this).find('.text-uppercase').text();
            var dBlock = $(this).find('.d-block').text();
            
            var text = clone.replace(word,'');
            var text = text.replace(dBlock,'');
            var text = $.trim(text);
            $('#searchbox .ais-SearchBox-input').val(text);
            $('#submitSearchValue').attr('name', word);
            $('#submitSearchValue').val(text);
            $('#searchbox .ais-SearchBox-input').attr("name", "search");
            $('#searchbox .ais-SearchBox-input').attr("id", "search");
            $(".dropdown-menu").css('display', "none !important");
            
            $('#datas').removeClass('absolute_search');
            $('#countryList').removeClass('absolute_dropdown');
            $('#countryList').removeClass('show');
            $("#close_doctor_search").css('display','none');
            $('#search-btn').click();
            $("body").removeClass("fixed");
        });
        $("#countryList").on("click", "#hits-instant-search li", function(event){
                event.stopPropagation();
                var clone = $(this).clone()    //clone the element
                              .end()  //again go back to selected element
                              .text();
                              
            var word = $(this).find('.text-uppercase').text();
            var dBlock = $(this).find('.d-block').text();
            var text = clone.replace(word,'');
            var text = text.replace(dBlock,'');
            var text = $.trim(text);
            $('#searchbox .ais-SearchBox-input').val(text);
            $('#submitSearchValue').val(text);
            $('#submitSearchValue').attr('name', 'search');
            $('#searchbox .ais-SearchBox-input').attr("name", "search");
            $('#searchbox .ais-SearchBox-input').attr("id", "search");
            $(".dropdown-menu").css('display', "none !important");
            
            $('#datas').removeClass('absolute_search');
            $('#countryList').removeClass('absolute_dropdown');
            $('#countryList').removeClass('show');
            $("#close_doctor_search").css('display','none');
            $('#search-btn').click();
            $("body").removeClass("fixed");
        });
         $("#countryList").on("click", "#hits-instant-search-disease li", function(event){
                event.stopPropagation();
                var clone = $(this).clone()    //clone the element
                              .end()  //again go back to selected element
                              .text();
                              
            var word = $(this).find('.text-uppercase').text();
            var dBlock = $(this).find('.d-block').text();
            var text = clone.replace(word,'');
            var text = text.replace(dBlock,'');
            var text = $.trim(text);
            $('#searchbox .ais-SearchBox-input').val(text);
            $('#submitSearchValue').val(text);
            $('#submitSearchValue').attr('name', 'diseases');
            $('#searchbox .ais-SearchBox-input').attr("name", "search");
            $('#searchbox .ais-SearchBox-input').attr("id", "search");
            $(".dropdown-menu").css('display', "none !important");
            
            $('#datas').removeClass('absolute_search');
            $('#countryList').removeClass('absolute_dropdown');
            $('#countryList').removeClass('show');
            $("#close_doctor_search").css('display','none');
            $('#search-btn').click();
            $("body").removeClass("fixed");
        });
         $("#countryList").on("click", "#hits-instant-search-hospital li", function(event){
                event.stopPropagation();
                var clone = $(this).clone()    //clone the element
                              .end()  //again go back to selected element
                              .text();
                              
            var word = $(this).find('.text-uppercase').text();
            var dBlock = $(this).find('.d-block').text();
            var text = clone.replace(word,'');
            var text = text.replace(dBlock,'');
            var text = $.trim(text);
            $('#searchbox .ais-SearchBox-input').val(text);
            $('#submitSearchValue').val(text);
            $('#submitSearchValue').attr('name', 'search');
            $('#searchbox .ais-SearchBox-input').attr("name", "search");
            $('#searchbox .ais-SearchBox-input').attr("id", "search");
            $(".dropdown-menu").css('display', "none !important");
            
            $('#datas').removeClass('absolute_search');
            $('#countryList').removeClass('absolute_dropdown');
            $('#countryList').removeClass('show');
            $("#close_doctor_search").css('display','none');
            $('#search-btn').click();
            $("body").removeClass("fixed");
        });
    $("#close_doctor_search").click(function(){
        $('#datas').removeClass('absolute_search');
        $('#countryList').removeClass('absolute_dropdown', 'show');
        $("body").removeClass("fixed");

        $(this).css('display','none');
    });

    $("#close_location_search").click(function(){
        //alert("hi");
        $('#location_inner').removeClass('absolute_search');
        $('#cityList').removeClass('absolute_dropdown','show');
        $(this).css('display','none');
        $("body").removeClass("fixed");
    });

    $(".ais-SearchBox-reset").click(function(){
        $(".ais-SearchBox-input").val("");
    });

    if ($(window).width() <= 992) {
        $("#main_doctor_search .ais-SearchBox-input").on("click", function(){
        //alert("hi");    
        $("#close_doctor_search").css('display','block');
        //$(".show").css('display','none !important');
        $("body").addClass("fixed");
       });

        $("#location_main .ais-SearchBox-input").on("click", function(){
            $("#close_location_search").css('display','block');
            $("body").addClass("fixed");
        });
        $(window).scroll(function() {
            var sticky_map = $('#search_form'),
                scroll = $(window).scrollTop();
           
             if (scroll >= 40) { 
                sticky_map.addClass('sticky_mobile_view_search'); }
            else { 
            sticky_map.removeClass('sticky_mobile_view_search');

            }
        });
    }

    $("#cityList").on("click", ".ais-Hits-item li", function(event){
        //alert('city selected')
            event.stopPropagation();
            var clone = $(this).clone()    //clone the element
                              .end()  //again go back to selected element
                              .text();
            var word = $(this).find('.text-uppercase').text();
            var text = clone.replace(word,'');
            var text = $.trim(text);
            $('#locations .ais-SearchBox-input').val(text);
            $('#submitCityValue').val(text);
            $('#locations .ais-SearchBox-input').attr("name", "location");
            $('#locations .ais-SearchBox-input').attr("id", "location");
            $(".dropdown-menu").css('display', "none !important");

            $('#location_inner').removeClass('absolute_search');
            $('#cityList').removeClass('absolute_dropdown');
            $('#cityList').removeClass('show');
            $('#location_dropdown').removeClass('show');
            $("#close_location_search").css('display','none');
            $("body").removeClass("fixed");
            //alert("remove");
        });
 
});
    /*window.onscroll = function() {myFunction()};

    var header = document.getElementById("dc_fix_Header");
    var sticky = header.offsetTop;

    function myFunction() {
      if (window.pageYOffset > 100) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }*/
    $(window).scroll(function() {
          var sticky = $('#dc_fix_Header'),
            scroll = $(window).scrollTop();
           
          if (scroll >= 40) { 
            sticky.addClass('sticky');
        }
          else { 
           sticky.removeClass('sticky');
        }
    });

    $(window).scroll(function() {
          var sticky_map = $('.google_map_main'),
            scroll = $(window).scrollTop();
           
          if (scroll >= 40) { 
            sticky_map.addClass('sticky_map'); }
          else { 
           sticky_map.removeClass('sticky_map');

        }
    });

    $(window).scroll(function() {
          var sticky_map = $('.search_main'),
            scroll = $(window).scrollTop();
           
          if (scroll >= 40) { 
            sticky_map.addClass('sticky_search'); }
          else { 
           sticky_map.removeClass('sticky_search');

        }
    });
    $(window).scroll(function() {
          var sticky_map = $('.front_end'),
            scroll = $(window).scrollTop();
           
          if (scroll >= 40) { 
            sticky_map.addClass('hide_nav'); }
          else { 
           sticky_map.removeClass('hide_nav');

        }
    });

    $(".mobile_view_search").on("click",function(){
        //alert("hi");

        $(".search_main").addClass("first_modal");
        $(".first_modal").show();

    });

    $("#first_modal_close").on("click",function(){
        $(".first_modal").hide();
    });

    $(".dc-userlogedin").on("click",function(){
        if($('.dc-usernav').height() > 300){
            $(".dc-usernav").css({'overflow-y' : 'scroll','height' : '470px'});    
        };
        $(".dc-usernav").toggle();
    });

    $('.dc-usernav').bind('click', function (e) { e.stopPropagation() });

    $(".more_filter_btn").on("click",function(){
        $(".filter_outer").slideToggle(500);
    });
    $("#close_filter , .mobile_apply_btn").on("click", function(){
        $(".filter_outer").hide();
    });
    </script>

    <!-- start webpushr code -->
    <script>
        (function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));webpushr('setup',{'key':'BDv4kRIx1EN4Pe0cYJyJLw2xPEnvL53njoWlVYElIEDfNCTv8WCyVbGVoqq0YrC8ZKbda47yLbAKngAFCR1IHwI' });
    </script>
    <!-- end webpushr code -->
</body>
</html>

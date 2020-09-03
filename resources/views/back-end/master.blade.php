@extends('master')
@push('PackageStyle')
    <link href="{{ asset('css/antd.css') }}" rel="stylesheet">
@endpush
@push('stylesheets')
@stack('backend_stylesheets')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/dbresponsive.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/emojionearea.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/scrollbar.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('main')
<div class="dc-contentwrapper">
    @include('back-end.includes.header')
	<main id="dc-main" class="dc-main dc-haslayout main_padding">
        @auth
        <div id="dc-sidebarwrapper" class="dc-sidebarwrapper">
            @include('back-end.includes.dashboard-menu')
        </div>
        @endauth
		<section class="dc-haslayout dc-dbsectionspace">
			@yield('content')
		</section>
	</main>
</div>
@endsection
@push('scripts')
@stack('backend_scripts')
<script src="{{ asset('js/scrollbar.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    $(window).scroll(function () {          
        var $pscroll = $(window).scrollTop();                       
            if($pscroll > 76) {
             $('.dc-sidebarwrapper').addClass('dc-fixednav');
            }else{
             $('.dc-sidebarwrapper').removeClass('dc-fixednav');
            }
        });
</script>

<script src='https://maps.googleapis.com/maps/api/js?v=3&sensor=false&amp;libraries=places&key=AIzaSyCTtKFT6ROLiapWLQf-ATNCdy5fn_VJ68s'></script>

<script>
   $(document).ready(function() {
        $("#lat_area").addClass("d-none");
        $("#long_area").addClass("d-none");
   });
</script>
<script>
   google.maps.event.addDomListener(window, 'load', initialize);

   function initialize() {
       console.log('hello world: ')
       var input = document.getElementById('autocomplete');
       //var options = {types: ['(regions)']}
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.setComponentRestrictions(
            {'country': ['pk']});
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
           $('#address_lat').val(place.geometry['location'].lat());
           $('#address_long').val(place.geometry['location'].lng());
       });
       console.log(autocomplete)
   }

   
$("#bankCard").click(function(e) {

    
    var form = $(this).parents('form');
   
    var CardNo = $('#cc-number').val();
    var regCardNo = /^[0-9]{09,16}$/;
    var regibanCardNo = /^[0-9]{00,24}$/;
    var bankName = $('#x_bank').val();
    var ibanName = $('#x_iban').val();
    var bankTitle = $('#x_title').val();
    
    if (form[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    }
    else {
       if (!regCardNo.test(CardNo)) {
       
        $("#cc-number").addClass('required');
        $("#cc-number").focus();
        alert(" Enter a valid 12 to 16 card number");
        return false;
      } else if(ibanName !=''){
        
        var valid = isValidIBANNumber(ibanName);
        if(valid == false){
          $("#x_iban").addClass('required');
          $("#x_iban").focus();
          alert(" Enter a valid 24 digit IBAN number");
          return false;
        }

      }else if (bankName == '')
      {
       $("#x_bank").addClass('required');
        $("#x_bank").focus();
        alert("Bank name required");
        return false; 
      } else if (bankTitle == '')
      {
       $("#x_title").addClass('required');
        $("#x_title").focus();
        alert("Account title required");
        return false; 
      } 
      
      
    }
    
    form.addClass('was-validated');
});


   
    /*
     * Returns 1 if the IBAN is valid 
     * Returns FALSE if the IBAN's length is not as should be (for CY the IBAN Should be 28 chars long starting with CY )
     * Returns any other number (checksum) when the IBAN is invalid (check digits do not match)
     */
    function isValidIBANNumber(input) {
        var CODE_LENGTHS = {
            AD: 24, AE: 23, AT: 20, AZ: 28, BA: 20, BE: 16, BG: 22, BH: 22, BR: 29,
            CH: 21, CR: 21, CY: 28, CZ: 24, DE: 22, DK: 18, DO: 28, EE: 20, ES: 24,
            FI: 18, FO: 18, FR: 27, GB: 22, GI: 23, GL: 18, GR: 27, GT: 28, HR: 21,
            HU: 28, IE: 22, IL: 23, IS: 26, IT: 27, JO: 30, KW: 30, KZ: 20, LB: 28,
            LI: 21, LT: 20, LU: 20, LV: 21, MC: 27, MD: 24, ME: 22, MK: 19, MR: 27,
            MT: 31, MU: 30, NL: 18, NO: 15, PK: 24, PL: 28, PS: 29, PT: 25, QA: 29,
            RO: 24, RS: 22, SA: 24, SE: 24, SI: 19, SK: 24, SM: 27, TN: 24, TR: 26
        };
        var iban = String(input).toUpperCase().replace(/[^A-Z0-9]/g, ''), // keep only alphanumeric characters
                code = iban.match(/^([A-Z]{2})(\d{2})([A-Z\d]+)$/), // match and capture (1) the country code, (2) the check digits, and (3) the rest
                digits;
        // check syntax and length
        if (!code || iban.length !== CODE_LENGTHS[code[1]]) {
            return false;
        }
        // rearrange country code and check digits, and convert chars to ints
        digits = (code[3] + code[1] + code[2]).replace(/[A-Z]/g, function (letter) {
            return letter.charCodeAt(0) - 55;
        });
        // final check
        return mod97(digits);
    }
    function mod97(string) {
        var checksum = string.slice(0, 2), fragment;
        for (var offset = 2; offset < string.length; offset += 7) {
            fragment = String(checksum) + string.substring(offset, offset + 7);
            checksum = parseInt(fragment, 10) % 97;
        }
        return checksum;
    }
</script>
@endpush

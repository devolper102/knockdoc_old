<?php
    header('Access-Control-Allow-Origin: *');
    header('X-XSS-Protection: 0');
    $orderId = "ORD1". date('YmdHis');
    //$ExpiryTime = date('YmdHis', strtotime("+5 hours"));
    $TxnDateTime = date('YmdHis', strtotime("+0 hours"));
    $_TxnRefNumber = "T". date('YmdHis');
    $_AmountTmp = 1*100;
    $_AmtSplitArray = explode('.', $_AmountTmp);
    $_FormattedAmount = $_AmtSplitArray[0];
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script type="text/javascript" src="https://sandbox.jazzcash.com.pk/hostedpay/Scripts/PayChk3Ds-2.0.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        var pp_payload = {
    pp_IsRegisteredCustomer: "Yes",
        pp_TokenizedCardNumber:"",
        pp_CustomerID: "TestingID",
        pp_CustomerEmail: "test@test.com",
        pp_CustomerMobile: "033456789025",
        pp_MerchantID: 'MC0787',
        pp_Password: '31s91vtcu5',
        pp_TxnRefNo: <?php echo(json_encode($_TxnRefNumber));?>,
        pp_DiscountedAmount: "",
        pp_DiscountBank: "",
        pp_Amount: '<?php echo(json_encode($_AmountTmp)); ?>',
        pp_TxnCurrency: "PKR",
        pp_TxnDateTime: <?php echo(json_encode($TxnDateTime));?>,
        pp_TxnExpiryDateTime: '',
        pp_BillReference: "billRef",
        pp_Description: "Description of transaction",
        pp_SecureHash:""
    };

    var CryptoJS=CryptoJS||function(h,s){var f={},g=f.lib={},q=function(){},m=g.Base={extend:function(a){q.prototype=this;var c=new q;a&&c.mixIn(a);c.hasOwnProperty("init")||(c.init=function(){c.$super.init.apply(this,arguments)});c.init.prototype=c;c.$super=this;return c},create:function(){var a=this.extend();a.init.apply(a,arguments);return a},init:function(){},mixIn:function(a){for(var c in a)a.hasOwnProperty(c)&&(this[c]=a[c]);a.hasOwnProperty("toString")&&(this.toString=a.toString)},clone:function(){return this.init.prototype.extend(this)}},
r=g.WordArray=m.extend({init:function(a,c){a=this.words=a||[];this.sigBytes=c!=s?c:4*a.length},toString:function(a){return(a||k).stringify(this)},concat:function(a){var c=this.words,d=a.words,b=this.sigBytes;a=a.sigBytes;this.clamp();if(b%4)for(var e=0;e<a;e++)c[b+e>>>2]|=(d[e>>>2]>>>24-8*(e%4)&255)<<24-8*((b+e)%4);else if(65535<d.length)for(e=0;e<a;e+=4)c[b+e>>>2]=d[e>>>2];else c.push.apply(c,d);this.sigBytes+=a;return this},clamp:function(){var a=this.words,c=this.sigBytes;a[c>>>2]&=4294967295<<
32-8*(c%4);a.length=h.ceil(c/4)},clone:function(){var a=m.clone.call(this);a.words=this.words.slice(0);return a},random:function(a){for(var c=[],d=0;d<a;d+=4)c.push(4294967296*h.random()|0);return new r.init(c,a)}}),l=f.enc={},k=l.Hex={stringify:function(a){var c=a.words;a=a.sigBytes;for(var d=[],b=0;b<a;b++){var e=c[b>>>2]>>>24-8*(b%4)&255;d.push((e>>>4).toString(16));d.push((e&15).toString(16))}return d.join("")},parse:function(a){for(var c=a.length,d=[],b=0;b<c;b+=2)d[b>>>3]|=parseInt(a.substr(b,
2),16)<<24-4*(b%8);return new r.init(d,c/2)}},n=l.Latin1={stringify:function(a){var c=a.words;a=a.sigBytes;for(var d=[],b=0;b<a;b++)d.push(String.fromCharCode(c[b>>>2]>>>24-8*(b%4)&255));return d.join("")},parse:function(a){for(var c=a.length,d=[],b=0;b<c;b++)d[b>>>2]|=(a.charCodeAt(b)&255)<<24-8*(b%4);return new r.init(d,c)}},j=l.Utf8={stringify:function(a){try{return decodeURIComponent(escape(n.stringify(a)))}catch(c){throw Error("Malformed UTF-8 data");}},parse:function(a){return n.parse(unescape(encodeURIComponent(a)))}},
u=g.BufferedBlockAlgorithm=m.extend({reset:function(){this._data=new r.init;this._nDataBytes=0},_append:function(a){"string"==typeof a&&(a=j.parse(a));this._data.concat(a);this._nDataBytes+=a.sigBytes},_process:function(a){var c=this._data,d=c.words,b=c.sigBytes,e=this.blockSize,f=b/(4*e),f=a?h.ceil(f):h.max((f|0)-this._minBufferSize,0);a=f*e;b=h.min(4*a,b);if(a){for(var g=0;g<a;g+=e)this._doProcessBlock(d,g);g=d.splice(0,a);c.sigBytes-=b}return new r.init(g,b)},clone:function(){var a=m.clone.call(this);
a._data=this._data.clone();return a},_minBufferSize:0});g.Hasher=u.extend({cfg:m.extend(),init:function(a){this.cfg=this.cfg.extend(a);this.reset()},reset:function(){u.reset.call(this);this._doReset()},update:function(a){this._append(a);this._process();return this},finalize:function(a){a&&this._append(a);return this._doFinalize()},blockSize:16,_createHelper:function(a){return function(c,d){return(new a.init(d)).finalize(c)}},_createHmacHelper:function(a){return function(c,d){return(new t.HMAC.init(a,
d)).finalize(c)}}});var t=f.algo={};return f}(Math);
(function(h){for(var s=CryptoJS,f=s.lib,g=f.WordArray,q=f.Hasher,f=s.algo,m=[],r=[],l=function(a){return 4294967296*(a-(a|0))|0},k=2,n=0;64>n;){var j;a:{j=k;for(var u=h.sqrt(j),t=2;t<=u;t++)if(!(j%t)){j=!1;break a}j=!0}j&&(8>n&&(m[n]=l(h.pow(k,0.5))),r[n]=l(h.pow(k,1/3)),n++);k++}var a=[],f=f.SHA256=q.extend({_doReset:function(){this._hash=new g.init(m.slice(0))},_doProcessBlock:function(c,d){for(var b=this._hash.words,e=b[0],f=b[1],g=b[2],j=b[3],h=b[4],m=b[5],n=b[6],q=b[7],p=0;64>p;p++){if(16>p)a[p]=
c[d+p]|0;else{var k=a[p-15],l=a[p-2];a[p]=((k<<25|k>>>7)^(k<<14|k>>>18)^k>>>3)+a[p-7]+((l<<15|l>>>17)^(l<<13|l>>>19)^l>>>10)+a[p-16]}k=q+((h<<26|h>>>6)^(h<<21|h>>>11)^(h<<7|h>>>25))+(h&m^~h&n)+r[p]+a[p];l=((e<<30|e>>>2)^(e<<19|e>>>13)^(e<<10|e>>>22))+(e&f^e&g^f&g);q=n;n=m;m=h;h=j+k|0;j=g;g=f;f=e;e=k+l|0}b[0]=b[0]+e|0;b[1]=b[1]+f|0;b[2]=b[2]+g|0;b[3]=b[3]+j|0;b[4]=b[4]+h|0;b[5]=b[5]+m|0;b[6]=b[6]+n|0;b[7]=b[7]+q|0},_doFinalize:function(){var a=this._data,d=a.words,b=8*this._nDataBytes,e=8*a.sigBytes;
d[e>>>5]|=128<<24-e%32;d[(e+64>>>9<<4)+14]=h.floor(b/4294967296);d[(e+64>>>9<<4)+15]=b;a.sigBytes=4*d.length;this._process();return this._hash},clone:function(){var a=q.clone.call(this);a._hash=this._hash.clone();return a}});s.SHA256=q._createHelper(f);s.HmacSHA256=q._createHmacHelper(f)})(Math);
(function(){var h=CryptoJS,s=h.enc.Utf8;h.algo.HMAC=h.lib.Base.extend({init:function(f,g){f=this._hasher=new f.init;"string"==typeof g&&(g=s.parse(g));var h=f.blockSize,m=4*h;g.sigBytes>m&&(g=f.finalize(g));g.clamp();for(var r=this._oKey=g.clone(),l=this._iKey=g.clone(),k=r.words,n=l.words,j=0;j<h;j++)k[j]^=1549556828,n[j]^=909522486;r.sigBytes=l.sigBytes=m;this.reset()},reset:function(){var f=this._hasher;f.reset();f.update(this._iKey)},update:function(f){this._hasher.update(f);return this},finalize:function(f){var g=
this._hasher;f=g.finalize(f);g.reset();return g.finalize(this._oKey.clone().concat(f))}})})();

    var IntegritySalt = '9yt1u3w2w1';
            hashString = '';

            hashString += IntegritySalt + '&';

            if (pp_payload.pp_Amount != '') {
                hashString += pp_payload.pp_Amount + '&';
            }
            if (pp_payload.pp_BillReference != '') {
                hashString += pp_payload.pp_BillReference + '&';
            }
            if (pp_payload.pp_CustomerEmail != '') {
                hashString += pp_payload.pp_CustomerEmail + '&';
            }
            if (pp_payload.pp_CustomerID != '') {
                hashString += pp_payload.pp_CustomerID + '&';
            }
            if (pp_payload.pp_CustomerMobile != '') {
                hashString += pp_payload.pp_CustomerMobile + '&';
            }
            if (pp_payload.pp_Description != '') {
                hashString += pp_payload.pp_Description + '&';
            }
            if (pp_payload.pp_IsRegisteredCustomer != '') {
                hashString += pp_payload.pp_IsRegisteredCustomer + '&';
            }
            if (pp_payload.pp_MerchantID != '') {
                hashString += pp_payload.pp_MerchantID + '&';
            }
            if (pp_payload.pp_Password != '') {
                hashString += pp_payload.pp_Password + '&';
            }
            if (pp_payload.pp_TokenizedCardNumber != '') {
                hashString += pp_payload.pp_TokenizedCardNumber + '&';
            }
            if (pp_payload.pp_TxnCurrency != '') {
                hashString += pp_payload.pp_TxnCurrency + '&';
            }
            if (pp_payload.pp_TxnDateTime != '') {
                hashString += pp_payload.pp_TxnDateTime + '&';
            }
            if (pp_payload.pp_TxnExpiryDateTime != '') {
                hashString += pp_payload.pp_TxnExpiryDateTime + '&';
            }
            if (pp_payload.pp_TxnRefNo != '') {
                hashString += pp_payload.pp_TxnRefNo + '&';
            }

            hashString += 'MPAY' + '&';

            hashString = hashString.slice(0, -1);

            var hash = CryptoJS.HmacSHA256(hashString, IntegritySalt);

            console.log('string: ' + hashString);
            console.log('hash: ' + hash);

            pp_payload.pp_SecureHash = hash;
        populateJazzCashFields (pp_payload);
    });

    $(function () {
        window.addEventListener("message", invokeCompletion, false);
    });

    function invokeCompletion(_paPayload) {
        obj = JSON.parse(_paPayload.data);
        $("#ResponseCode").val(obj.ResponseCode);
        $("#ResponseMessage").val(obj.ResponseMessage);
        $("#pp_IsRegisteredCustomer").val(obj.pp_IsRegisteredCustomer);
        $("#pp_CustomerID").val(obj.pp_CustomerID);
        $("#pp_CustomerEmail").val(obj.pp_CustomerEmail);
        $("#pp_CustomerMobile").val(obj.pp_CustomerMobile);
        $("#pp_ShouldTokenizeCardNumber").val(obj.pp_ShouldTokenizeCardNumber);
        $("#pp_TokenizedCardNumber").val(obj.pp_TokenizedCardNumber);

        $("#IsReturningCustomer").val(obj.IsReturningCustomer);
        $("#IsTokenizationAllowedForMerchant").val(obj.IsTokenizationAllowedForMerchant);
        $("#IsAllowedCheck3DS").val(obj.IsAllowedCheck3DS);
        $("#IsAllowedCVV").val(obj.IsAllowedCVV);

        $("#InstitutionID").val(obj.InstitutionID);
        $("#MerchantResponseCode").val(obj.MerchantResponseCode);
        $("#TransactionReqLogID").val(obj);

        $("#pp_TxnType").val("MPAY");
        $("#pp_MerchantID").val(obj.pp_MerchantID);
        $("#pp_Language").val(obj.pp_Language);
        $("#pp_SubMerchant").val(obj.pp_SubMerchantID);
        $("#pp_Password").val(obj.pp_Password);
        $("#pp_TxnRefNo").val(obj.pp_TxnRefNo);
        $("#pp_Amount").val(obj.pp_Amount);
        $("#pp_DiscountedAmount").val(obj.pp_DiscountedAmount);
        $("#pp_DiscountBank").val(obj.pp_DiscountBank);
        $("#pp_TxnCurrency").val(obj.pp_TxnCurrency);
        $("#pp_TxnExpiryDateTime").val(obj.pp_TxnExpiryDateTime);
        $("#pp_TxnDateTime").val(obj.pp_TxnDateTime);
        $("#pp_BillReference").val(obj.pp_BillReference);
        $("#pp_Description").val(obj.pp_Description);
        $("#pp_ReturnURL").val(obj.pp_ReturnURL);
        $("#ppmpf_1").val(obj.ppmpf_1);
        $("#ppmpf_2").val(obj.ppmpf_2);
        $("#ppmpf_3").val(obj.ppmpf_3);
        $("#ppmpf_4").val(obj.ppmpf_4);
        $("#ppmpf_5").val(obj.ppmpf_5);
        $("#pp_SecureHash").val(obj.pp_SecureHash);
        document.forms[0].submit();
    }
    </script>

    <form id="onlineform" action="/testjazz" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="JazzCashFields">
            <div id="JazzCashErrorDiv" style="display: none; color: red"></div>
            <div id="JazzCashSuccessDiv" style="display: none; color: green"></div>
        </div>
        <input type="submit" value="Submit" />
    </form>
    <div id="stagingForm" style="display: none;"></div>
    <div id="pp_masterCardResponse" style="background: rgba(255, 193, 7, 0.25); padding: 1rem; margin: 1.5rem; display: none;"></div>
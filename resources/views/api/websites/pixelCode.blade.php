(function(){

  /**
   *  Stores the visitor hash as a cookie with unique name to avoid duplication with other services
   */
  function setTrackingCookie(value) {
      var name = 'tt_uid_' + '{{$website->hash}}';
      var expires = "";
      document.cookie = name + "=" + (value || "")  + expires + "; path=/";
  }

  /**
   *  Retrives the visitor tracking hash for this account if exist or returns null
   */
  function getTrackingCookie() {
      var name = 'tt_uid_' + '{{$website->hash}}';
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for(var i=0;i < ca.length;i++) {
          var c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1,c.length);
          if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
  }

  /**
   *  Makes Post Ajax requests
   */
  function postAjax(url, data, success) {
    var params = typeof data == 'string' ? data : Object.keys(data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
        ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
  }

  /**
   *  Get browser of user
   */
  function getBrowser() {
    // Opera 8.0+
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    if (isOpera) return "OPERA";

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
    if (isFirefox) return "FIREFOX";

    // Safari 3.0+ "[object HTMLElementConstructor]"
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
    if (isSafari) return "SAFARI";

    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    if (isIE) return "IE";

    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
    if (isEdge) return "EDGE";

    // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    if (isChrome) return "CHROME";

    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;
    if (isBlink) return "BLINK";

    return false; // can't detect browser
  }


  /**
   *  register new visitor, issue hash and store it as a cookie
   */
  function registerNewVisitor() {

      // call api to gennerate visitor
      postAjax("{{route('api.visitor.create')}}", { website_hash: '{{$website->hash}}' }, function(data){

        // make JSON data to Object
        var response = JSON.parse(data);

        if (response.success == true) {

          // set cookie with visitor_hash and track the visit
          setTrackingCookie(response.visitor_hash);
          trackVisit(response.visitor_hash);
        }
      });
  }

  /**
   *  Track visit actions using visitors_hash
   */
  function trackVisit(visitror_hash) {

    postAjax("{{route('api.action.create')}}",
    {
      visitor_hash: visitror_hash,
      url: window.location,
      browser: getBrowser()
    },
    function(data){

      // make JSON data to Object
      var response = JSON.parse(data);

      if (response.success == false) {

        if (response.delete_cookie) {
            // hash of cookie does not exist in visitors, create new visitor
            registerNewVisitor();
        }
      }

    });
  }

  // check if visitor hash exist
  var tt_uid = getTrackingCookie();

  // if visitor hash does not exist [TODO: check fingerprint_hash]
  if (tt_uid == null) {
      registerNewVisitor();
  }
  else {
      // track visit
      trackVisit(tt_uid);
  }

})();

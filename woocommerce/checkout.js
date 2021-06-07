(function ($) {
    $(document).ready(function () {
        var savedCookie = ocmCheckCookie();
        var link = savedCookie['routePermalink'];
        var goBack = $(".checkout-go-back-btn");
        var lang = document.documentElement.lang;
        if (lang == "en-US") {
            goBack.html("<a href='"+link+"'><p>Go back</p></a>")
          } else {
            goBack.html("<a href='"+link+"'><p>Torna indietro</p></a>")
          }
    });
})(jQuery);
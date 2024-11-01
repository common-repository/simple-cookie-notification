//Author: Before / After
//Author URL: https://b4after.pl

(function ($) {

    /**
     * Accept cookie on closing or clicking button
     */
    $(document).on('click', '.ba_cookie_bar button, .ba_cookie_bar img', function () {


        setCookie();

        $('.ba_cookie_bar').fadeOut();


    });

    /**
     * Accept cookie on interaction by clicking a internal link
     */
    if ($('.ba_cookie_bar').hasClass('interactionClass')) {
        $(document).on('click', 'a', function (e) {
            $('.ba_cookie_bar').fadeOut();

            // e.preventDefault();
            // console.log($(window));

            if (isLinkInternal($(this))) {
                setCookie();
            }

        });
    }



    function isLinkInternal(url) {

        var currentHost = $(window)["0"].location.host;
        var flag = false;

        if (url["0"].host === currentHost) {
            flag = true;
        }

        return flag;
    }

    function setCookie() {

        var date = new Date(new Date().setFullYear(new Date().getFullYear() + 1));

        document.cookie = "cookie_info=1; expires=" + date + "; path=/";

    }

})(jQuery);
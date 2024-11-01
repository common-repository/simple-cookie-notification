(function ($) {


    $(document).on('click', '#ba_cookie_info_export', function (e) {
        e.preventDefault();
        var inputs = {};
        var formInputs = $('.ba_cookie_info input, .ba_cookie_info textarea');


        $.each(formInputs, function () {

            if ($(this).attr('name') === 'option_page' || $(this).attr('name') === 'action' || $(this).attr('name') === '_wpnonce' || $(this).attr('name') === '_wp_http_referer' || $(this).attr('name') === 'submit' || $(this).attr('name') === 'ba_json') {

            }
            else {
                let name = $(this).attr('name');
                let val = $(this).val();

                inputs[name] = val;
            }


        });
        console.log(inputs)
        var json = JSON.stringify(inputs);

        // alert('skopiowano do schowka');

        // $(document).execCommand('copy');

        $('#json_export').html('<pre>' + json + '</pre>');




    })


})(jQuery);
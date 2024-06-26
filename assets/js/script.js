jQuery(document).ready(function($) {
    $('#custom-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=submit_custom_form';
        formData += '&nonce=' + customPluginVars.nonce;

        $.ajax({
            url: customPluginVars.ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#form-message').html('<p style="color: green;">' + response.data + '</p>');
                    $('#custom-form')[0].reset();
                } else {
                    $('#form-message').html('<p style="color: red;">' + response.data + '</p>');
                }
            }
        });
    });
});
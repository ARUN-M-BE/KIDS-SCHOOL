//Contact Form Validation
if ($("#contact").length) {
    $("#contact").validate({
        submitHandler: function(form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            //   form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');

            form_btn.before(' <div id="form-result" style="display:none; background:none; text-align:center; color:#dc3545; padding-bottom:61px"><br><br><p>Thanks for contacting us!</p><h4>**RaGlobalCity**</h4></div>');

            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function(data) {
                    if (data.status = 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function() { $(form_result_div).fadeOut('slow') }, 6000);
                }
            });
        }
    });
}

const script = 'https://script.google.com/macros/s/AKfycbyXyHJUjMkyFnxkCDky7jgjqY9xvJTNiURPmhYPfxcEIUS9WYjtexQR-4nJov1gh-ou/exec'
const form = document.forms['contact']

form.addEventListener('submit', e => {
    e.preventDefault();
    fetch(script, { method: 'POST', body: new FormData(form) })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Form submitted successfully, show thank you message
                form.style.display = 'none'; // Hide the form
                document.querySelector('thankyou_message').style.display = 'block'; // Show the thank you message
            } else {
                // Handle errors or display an error message
                console.error('Form submission failed:', data.message);
            }
        })
        .catch(error => console.error('Error!', error.message))
})
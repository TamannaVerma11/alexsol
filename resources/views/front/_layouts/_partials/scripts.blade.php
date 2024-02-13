<!-- Scripts -->

<script>
    function checkTfaType() {
        let tfa_email = document.getElementById('tfa_email');
        let tfa_phone = document.getElementById('tfa_phone');
        let tfa_email_input = document.getElementById('forgot_pass_email');
        let tfa_phone_input = document.getElementById('forgot_pass_phone');
        if (tfa_email.checked) {
            tfa_email_input.classList.contains('d-none') ? tfa_email_input.classList.remove('d-none') : '';
            !tfa_phone_input.classList.contains('d-none') ? tfa_phone_input.classList.add('d-none') : '';
        }
        if (tfa_phone.checked) {
            !tfa_email_input.classList.contains('d-none') ? tfa_email_input.classList.add('d-none') : '';
            tfa_phone_input.classList.contains('d-none') ? tfa_phone_input.classList.remove('d-none') : '';
        }
    }
    checkTfaType();

    var changeLocale = '{{route('changeLocale', app()->getLocale())}}';
    var pricingURL   = '{{route('pricing', app()->getLocale())}}';
</script>

<script src="{{ url('vendor/jquery-3.4.1/jquery.min.js') }}"></script>
<script src="{{ url('vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/index.js?v=' . time()) }}"></script>

<!-- notification pop up js -->
<script src="{{ url('js/toastr.js') }}"></script>

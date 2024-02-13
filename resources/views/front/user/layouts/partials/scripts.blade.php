<script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>

<script src="{{ url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ url('assets/libs/metismenu/metisMenu.min.js') }}"></script>

<script src="{{ url('assets/libs/simplebar/simplebar.min.js') }}"></script>

<script src="{{ url('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ url('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ url('assets/js/pages/dashboard.init.js') }}"></script>

<script src="{{ url('assets/js/app.js') }}"></script>

<script>
    var citys = '';
    var trackers = '';
    var changeLocale = '{{route('changeLocale', app()->getLocale())}}';
    var tosWithCompURL = '{{route('tos.index_with_comp', app()->getLocale())}}';
    var optionURL    = '{{ route('support.option.update', ['lang'=>app()->getLocale()]) }}';
    var csrfToken = '{{ csrf_token() }}';
    var user_tickets_phrase10 = '{{ trans('index.user_tickets_phrase10') }}';
    var message_no_of_rec = '{{ trans('index.message_no_of_rec') }}';
    var text_previous = '{{ trans('index.text_previous') }}';
    var text_next = '{{ trans('index.text_next') }}';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ url('js/dashboard.js') }}"></script>

<script src="{{ url('vendor/jquery-3.4.1/jquery.min.js') }}"></script>

<script src="{{ url('vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<script src="{{ url('js/popper.min.js') }}" crossorigin="anonymous">
</script>
<script src="{{ url('js/bootstrap.min.js') }}" crossorigin="anonymous">
</script>
<script src="{{ url('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('vendor/chartjs-2.9.3/Chart.min.js') }}"></script>

<!-- <script type="text/javascript" src="/vendor/datatable/js/jquery.dataTables.min.js"></script> -->
<!-- <script type="text/javascript" src="/vendor/datatable/js/dataTables.rowGroup.min.js"></script> -->
<script src="{{ url('js/iconify.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/custom-datatable.js') }}"></script>
<script type="text/javascript" src="{{ url('js/toastr/toastr.min.js') }}"></script>

<script src="{{ url('assets/js/custom.js') }}"></script>

<script src="{{ url('js/user.js') }}"></script>


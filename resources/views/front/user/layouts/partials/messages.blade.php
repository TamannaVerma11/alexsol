
@if(Session::get('success', false))
<?php $data = Session::get('success'); ?>
@if (is_array($data))
    @foreach ($data as $msg)
        <script>
            var shortCutFunction = "success"; //success, error, warning, info
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-center',
            };

            toastr.options.timeOut = "10000";

            var $toast = toastr[shortCutFunction]('{{$msg}}');
        </script>
    @endforeach
@else
    <script>
        var shortCutFunction = "success"; //success, error, warning, info
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-center',
        };

        toastr.options.timeOut = "10000";

        var $toast = toastr[shortCutFunction]('{{$data}}');
    </script>
@endif
@endif


@if(Session::get('error'))
<?php $data = Session::get('error'); ?>
@if (is_array($data))
    @foreach ($data as $msg)
        <script>
            var shortCutFunction = "error"; //success, error, warning, info
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-center',
            };

            toastr.options.timeOut = "10000";

            var $toast = toastr[shortCutFunction]('{{$msg}}');
        </script>
    @endforeach
@else
    <script>
        var shortCutFunction = "error"; //success, error, warning, info
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-center',
        };

        toastr.options.timeOut = "10000";

        var $toast = toastr[shortCutFunction]('{{$data}}');
    </script>
@endif
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta name="viewport" content="initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- bootstrap 5.3 --}}
    <link href="{{ asset('bootstrap5.3/bootstrap.min.css') }}" rel="stylesheet">
    {{-- datatables --}}
    <link href="{{ asset('datatables2.0/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('datatables2.0/datatables.min.js') }}"></script>

</head>

<body>
    @yield('main')
    @if (session('message'))
        <div class="modal fade" id="myMessageModal" tabindex="-1" aria-labelledby="myMessageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myMessageModalLabel">訊息</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! session('message') !!}
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- bootstrap 5.3 --}}
    <script src="{{ asset('bootstrap5.3/bootstrap.bundle.min.js') }}"></script>
    @if (session('message'))
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("myMessageModal"), {});
            document.onreadystatechange = function() {
                myModal.show(); //訊息顯示
            };
        </script>
    @endif
</body>

</html>

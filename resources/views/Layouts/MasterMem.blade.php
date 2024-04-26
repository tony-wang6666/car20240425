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

    <!-- icon圖像 -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    {{-- bootstrap 5.3 --}}
    <link href="{{ asset('bootstrap5.3/bootstrap.min.css') }}" rel="stylesheet">
    {{-- datatables --}}
    <link href="{{ asset('datatables2.0/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('datatables2.0/datatables.min.js') }}"></script>

    <style>
        .navbar-nav .nav-item .active { /* 底線效果 */
            padding: 0.5rem 1rem;
            margin: 0.5rem;
            border-bottom: 1px solid #000; 
        }
    </style>
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

    <script>
        $('.no_submit').on('keydown', 'input, select, textarea', function(e) { //enter按鍵 類似於 tab按鍵
            if (e.key === "Enter") {
                var self = $(this),
                    form = self.parents('form:eq(0)'),
                    focusable, next;
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                } else {
                    // form.submit(); //最後一個就送出
                }
                return false;
            }
        });
    </script>
</body>

</html>

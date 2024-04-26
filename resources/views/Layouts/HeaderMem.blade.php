@extends('Layouts.MasterMem')
@section('main')
    <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">允利</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (in_array('MemberWorkOrder', session('WebAccess') ?? []))
                        <li class="nav-item">
                            <a class="nav-link @if ($page == 'wo_page') active @endif" aria-current="page" href="{{ route('MemberWorkOrderList') }}">工單</a>
                        </li>
                    @endif
                    
                    
                    {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        測試
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">測試2</a></li>
                    </ul>
                </li> --}}
                </ul>
                <div>
                    @if (count(session('WebAccess') ?? []) > 0)
                        <span class="navbar-text">
                            <a class="nav-link active" aria-current="page" href="{{ route('Logout') }}">
                                <span class="material-symbols-outlined">logout</span>
                                <span></span>
                            </a>
                        </span>
                    @else
                        <span class="navbar-text">
                            <a class="nav-link active" aria-current="page" href="{{ route('Login') }}">
                                <span class="material-symbols-outlined">login</span>
                                <span></span>
                            </a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="">
        <main role="main" class="">
            @yield('content')
        </main>
    </div>
@endsection

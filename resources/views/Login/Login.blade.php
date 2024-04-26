@extends('Layouts.HeaderMem')
@section('title', '登入')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        登入
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="s_acc" class="form-label">帳號</label>
                                <input type="text" class="form-control" id="s_acc" name="s_acc" placeholder="輸入帳號">
                            </div>
                            <div class="mb-3">
                                <label for="s_pass" class="form-label">密碼</label>
                                <input type="password" class="form-control" id="s_pass" name="s_pass" placeholder="輸入密碼">
                            </div>
                            <button type="submit" class="btn btn-primary">登入</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

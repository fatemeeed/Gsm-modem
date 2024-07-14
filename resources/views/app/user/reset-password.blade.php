@extends('app.layouts.master')

@section('title')
    <title> ریست پسورد </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ریست پسورد</li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ریست پسورد </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.user.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.user.reset-password.post',$user->id) }}" method="post" >
                        @csrf
                        @method('put')

                        <section class="row">


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""> کلمه عبور </label>
                                    <input class="form-control form-control-sm" name="password" id="password"
                                        type="password">
                                </div>
                                @error('password')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تکرار کلمه عبور </label>
                                    <input class="form-control form-control-sm" name="password_confirmation"
                                        type="password">
                                </div>
                                @error('password_confirmation')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            
                            <section class="col-12 col-md-12 mt-3">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>


                    </form>


                </section>






            </section>

        </section>




    </section>
@endsection

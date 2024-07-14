@extends('app.layouts.master')

@section('head-tag')
    <title>ایجاد کاربر </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد کاربر </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ایجاد کاربر </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm" href="{{ route('app.user.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <section class="row">

                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">نام </label>
                                    <input class="form-control form-control-sm" name="first_name" type="text"
                                        value="{{ old('first_name') }}">
                                </div>
                                @error('first_name')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">نام خانوادگی </label>
                                    <input class="form-control form-control-sm" name="last_name" type="text"
                                        value="{{ old('last_name') }}">
                                </div>
                                @error('last_name')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">کد ملی </label>
                                    <input class="form-control form-control-sm" name="national_code" id="national_code"
                                        type="text" value="{{ old('national_code') }}">
                                </div>
                                @error('national_code')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            {{-- <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ایمیل </label>
                                    <input class="form-control form-control-sm" name="email" id="email" type="text"
                                    value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section> --}}
                            

                            <section class="col-12 col-md-6 mb-3">
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
                            <section class="col-12 col-md-6 mb-3">
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
                            {{-- <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""> تصویر کاربر </label>
                                    <input class="form-control form-control-sm" name="profile_photp_path"
                                        id="profile_photp_path" type="file">
                                </div>
                                @error('profile_photp_path')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section> --}}
                            {{-- <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""> نقش کاربر </label>
                                    <select class="form-control  form-control-sm" name="role_id" id="role_id">
                                        <option value="">نقش کاربر را انتخاب کنید</option>
                                        @foreach ($roles as $role)
                                            <option
                                                value="{{ $role->id }} @if (old('role_id') == $role->id) selected @endif">
                                                {{ $role->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </section> --}}

                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for=""> وضعیت فعالسازی</label>
                                    <select class="form-control  form-control-sm" name="activation" id="activation">
                                        <option>وضعیت را انتخاب کنید</option>
                                        <option value="1" @if (old('activation') == 1) selected @endif>فعال
                                        </option>
                                        <option value="0" @if (old('activation') == 0) selected @endif>غیر فعال
                                        </option>
                                    </select>
                                </div>
                            </section>
                            <section class="col-12 col-md-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>


                    </form>


                </section>






            </section>

        </section>




    </section>
@endsection

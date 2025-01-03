@extends('app.layouts.master')

@section('title')
    <title>ویرایش کاربر </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش کاربر </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ویرایش کاربر </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.user.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tags">شهرک صنعتی </label>

                                    <select class="form-control form-control-sm" name="industrial_id" >

                                        <option value="">شهرک کاربر را انتخاب کنید</option>
                                    @foreach ($industrials as $industrial)
                                        <option value="{{ $industrial->id }}" >{{ $industrial->name }}</option>
                                    @endforeach

                                </select>
                                </div>
                                @error('industrial_id')
                                    <span class="alert-danger rounded" role="alert">
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
                                        type="text" value="{{ old('national_code', $user->national_code) }}">
                                </div>
                                @error('national_code')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">نام </label>
                                    <input class="form-control form-control-sm" name="first_name" id="first_name"
                                        type="text" value="{{ old('first_name', $user->first_name) }}">
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
                                    <input class="form-control form-control-sm" name="last_name" id="last_name"
                                        type="text" value="{{ old('last_name', $user->last_name) }}">
                                </div>
                                @error('last_name')
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
                                    value="{{ old('email',$user->email) }}">
                                </div>
                                @error('email')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section> --}}
                            

                            <section class="col-12 col-md-6">
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
                                @error('role_id')
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
                                        <img src="{{ asset($user->profile_photp_path)}}" alt="" width="80px" height="100px;">
                                </div>
                                @error('profile_photp_path')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                          
                            </section> --}}

                           

                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>

                    </form>

                </section>

            </section>

        </section>

    </section>
@endsection

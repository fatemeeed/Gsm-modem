@extends('admin.layouts.master')

@section('head-tag')
    <title> ویرایش تنظیمات مودم</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> تنظیمات مودم</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تنظیمات </li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                          ویرایش تنظیمات مودم
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="" class="btn btn-info btn-sm text-light">بازگشت</a>
                </section>

                <section>
                    <form action="" method="post" id="form">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="name">port</label>
                                    <input type="text" class="form-control form-control-sm" name="port" id="name"
                                        value="{{ old('port') }}">
                                </div>
                                @error('port')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="name">baud rate </label>
                                    <input type="text" class="form-control form-control-sm" name="baud_rate" id="baud_rate"
                                        value="{{ old('baud_rate') }}">
                                </div>
                                @error('baud_rate')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                        

                            <section class="col-12 my-3">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection


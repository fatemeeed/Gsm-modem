@extends('app.layouts.master')

@section('title')
    <title>ایجاد چک کد </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> دسترسی ها </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد چک کد </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ایجاد چک کد </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.check-code.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.check-code.store') }}" method="post">

                        @csrf

                        <section class="row">
                           
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""> نام چک کد </label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                        value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 mt-2">
                                <div class="form-group">
                                    <label for="">توضیحات </label>
                                    <input class="form-control form-control-sm" type="text" name="description"
                                        id="description" value="{{ old('description') }}">
                                </div>
                                @error('description')
                                    <span class="alert-danger text-white bg-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 mt-2 ">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                           

                        </section>

                    </form>

                </section>

            </section>

        </section>

    </section>
@endsection

@extends('app.layouts.master')

@section('head-tag')
    <title>ایجاد نقش </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> نقش ها </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد نقش </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ایجاد نقش </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.role.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.role.store') }}" method="post">

                        @csrf

                        <section class="row">

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">عنوان نقش </label>
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

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">توضیح نقش </label>
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

                            <section class="col-12 col-md-2 mt-md-4">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>


                        </section>

                    </form>

                </section>

            </section>

        </section>

    </section>
@endsection

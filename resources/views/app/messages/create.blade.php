@extends('app.layouts.master')
@section('title')
    <title >ارسال پیام جدید</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb" dir="rtl">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">پیام ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">  ارسال پیام جدید</li>
        </ol>
    </nav>


    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                             ارسال پیام جدید
                        </h5>
                    </section>
    
                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('app.Message.send-box') }}" class="btn btn-info btn-sm text-light">بازگشت</a>
                    </section>
    
                    <section>
                        <form action="{{ route('admin.Message.post-message') }}" method="post" id="form">
                            @csrf
                            <section class="row">
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for=""> دیتالاگر</label>
                                        <select name="datalogger_id" id="datalogger_id" class="form-control form-control-sm">
                                            <option value="">دیتالاگر را انتخاب کنید</option>
                                            @foreach ($dataLoggers as $dataLogger)
                                                <option value="{{ $dataLogger->id }}" @if (old('datalogger_id')== $dataLogger->id ) selected @endif > {{ $dataLogger->name }}</option>
                                            @endforeach
    
    
                                        </select>
                                        @error('datalogger_id')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </div>
    
                                </section>
    
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="content">پیام </label>
                                        <input type="text" class="form-control form-control-sm" name="content" id="content"
                                            value="{{ old('content') }}">
                                    </div>
                                    @error('content')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>
                                
                                <section class="col-12 my-3">
                                    <button class="btn btn-primary ">ثبت</button>
                                </section>
                            </section>
                        </form>
                    </section>
    
                </section>
            </section>
        </section>
    </main>
@endsection
@section('script')
@endsection


@include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])

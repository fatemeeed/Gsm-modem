@extends('app.layouts.master')

@section('title')
    <title> کدهای کنترل </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">تجهیزات</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('app.data-logger.order-code', $device) }}">کدهای کنترل </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">افزودن کد جدید </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> کدهای کنترل</h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.data-logger.order-code', $device) }}">بازگشت </a>


                </section>

                <section>

                    {{-- <form action="{{ route('app.data-logger.order-code.store', $device) }}" method="POST">
                        @csrf

                        <section class="col-12   border-bottom py-3 mb-3">

                            <section class="row mb-2 dynamic-fields">

                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <select class=" form-control form-control-sm" name="orderCode[]">

                                            @foreach ($orderCodes as $orderCode)
                                                <option value="{{ $orderCode->id }}">{{ $orderCode->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                    @error('orderCode.*')
                                        <span class="alert-danger rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror

                                </section>

                                <section class="col-5 col-md-3">
                                    <div class="form-group">

                                        <input class="form-control form-control-sm" name="time[]" type="text"
                                            placeholder="بازه زمانی ارسال">
                                    </div>
                                    @error('time.*')
                                        <span class="alert-danger rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                    
                                </section>
                                <section class="col-1 col-md-1">
                                    
                                    <span class="btn btn-sm btn-danger remove-btn"><i class="fa fa-trash-alt"></i></span>
                                </section>
                                


                            </section>
                            <section>

                                <button type="button" id="btn-copy" class="btn btn-success btn-sm">افزودن</button>

                            </section>

                        </section>

                        <section class="col-12 col-md-6">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>


                    </form> --}}

                    <form action="{{ route('app.data-logger.order-code.store', $device) }}" method="POST">
                        @csrf

                        <section class="row   mb-3">

                            <section class="col-6 col-md-3">
                                <div class="form-group">
                                    <label for="">کد کنترل </label>

                                    <select class=" form-control form-control-sm" name="order_code_id">

                                        @foreach ($orderCodes as $orderCode)
                                            <option value="{{ $orderCode->id }}">{{ $orderCode->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                                @error('order_code_id')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror

                            </section>

                            {{-- <section class="col-6 col-md-3">

                                <div class="form-group">
                                    <label for="">بازه زمانی ارسال </label>

                                    <input class="form-control form-control-sm" name="time" type="text"
                                        placeholder=" به دقیقه">
                                </div>
                                @error('time')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section> --}}
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="time">بازه زمانی ارسال </label>
                                    <select name="time" id="time" class="form-control form-control-sm">
                                        <option value="">بازه زمانی را انتخاب کنید</option>
                                        <option value="60" @if (old('time') == '60') selected @endif>هر 1 ساعت
                                        </option>
                                        <option value="30" @if (old('time') == '30') selected @endif>هر 30دقیقه
                                        </option>
                                        <option value="15" @if (old('time') == '15') selected @endif>هر 15 دقیقه
                                        </option>
                                        <option value="10" @if (old('time') == '10') selected @endif>هر 10 دقیقه  
                                        </option>

                                    </select>
                                    @error('time')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>

                            </section>


                        </section>

                        <section class="col-12 col-md-6">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>


                    </form>


                </section>

            </section>

        </section>

    </section>
@endsection
@section('script')
    {{-- <script>
        $(function() {

            $('#btn-copy').on('click', function() {

                var ele = $(this).parent().prev().clone(true);
                $(this).before(ele);

            });



        });
    </script>

    <script>
         $(document).on('click', '.remove-btn', function() {
               

                if ($(this).closest('.dynamic-fields').index() >= 0) {
                    $(this).closest('.dynamic-fields').remove();
                } 
            });
    </script> --}}
@endsection

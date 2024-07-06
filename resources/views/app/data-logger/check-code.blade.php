@extends('app.layouts.master')

@section('title')
    <title>  چک کد </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">تجهیزات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> چک کد ها</li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> چک کد ها</h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.data-logger.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.data-logger.check-code.store', $device) }}" method="POST"
                       >
                        @csrf

                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tags">چک کد ها </label>

                                    <select class="select2 form-control form-control-sm" name="checkCode[]" id="select_checkCode"
                                        multiple>

                                        @foreach ($checkCodes as $checkCode)
                                            <option value="{{ $checkCode->id }}" 
                                                @foreach ($device->checkCodes as $datalogger_checkCode)

                                                @if ($datalogger_checkCode->id===$checkCode->id)
                                                selected
                                                    
                                                @endif
                                                    
                                                @endforeach>{{ $checkCode->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('checkCode')
                                    <span class="alert-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-4">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>


                    </form>


                </section>

            </section>

        </section>

    </section>
@endsection
@section('script')

<script>
    $('#select_checkCode').select2({
            placeholder : 'لطفا چک کد ها را انتخاب کنید',
            tags: true,
            dir: "rtl",
           
        });
</script>
    
@endsection

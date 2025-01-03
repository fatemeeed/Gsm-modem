@extends('app.layouts.master')

@section('head-tag')
    <title> شهرک جدید </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد شهرک جدید </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ایجاد شهرک جدید </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm" href="{{ route('app.industrial.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.industrial.store') }}" method="post" >
                        @csrf

                        <section class="row">

                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">نام شهرک </label>
                                    <input class="form-control form-control-sm" name="name" type="text"
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

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">استان</label>
                                    <select name="province_id" id="province" class="form-control form-control-sm">
                                        <option value="">استان مورد نظر را انتخاب کنید</option>
                                        @foreach ($provinces as $province)
                                            @if (old('province_id', $applicant->province ?? '') == $province->id)
                                                <option value="{{ $province->id }}" selected>{{ $province->name }}
                                                </option>
                                            @else
                                                <option value="{{ $province->id }}"> {{ $province->name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                @error('province')
                                    <span class="alert alert-danger p-0" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">شهر</label>
                                    <select name="city_id" id="city_id" class="form-control form-control-sm">


                                    </select>
                                </div>
                                @error('city_id')
                                    <span class="alert alert-danger p-0" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for=""> وضعیت </label>
                                    <select class="form-control  form-control-sm" name="status" id="status">
                                        <option>وضعیت را انتخاب کنید</option>
                                        <option value="1" @if (old('status') == 1) selected @endif>فعال
                                        </option>
                                        <option value="0" @if (old('status') == 0) selected @endif>غیر فعال
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
@section('script')
<script>
    $(document).ready(findCity);
    $('#province').on('change', findCity);

    function findCity() {


       
        var idProvince = $('#province').val();

        $("#city_id").html('');

        if (idProvince) {

            $.ajax({
                url: "{{ route('app.industrial.fetch-city') }}",
                type: "POST",
                data: {
                    province_id: idProvince,
                  
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {


                    $('#city_id').html('<option value="">شهر را انتخاب کنید</option>');
                    $.each(result.cities, function(key, value) {
                        $("#city_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });



                }
            });

        } else {

            if (city_id != '' && idProvince == '') {

                $('#city_id').html('<option value="' + city_id + '"> ' +
                    '{{ auth()->user()->city->name ?? '' }}' + '</option>');

            }

        }



    }
</script>
@endsection

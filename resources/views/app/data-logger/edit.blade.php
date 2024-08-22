@extends('app.layouts.master')

@section('head-tag')
    <title> ویرایش تجهیز</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> دیتالاگرها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تجهیز </li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش تجهیز
                    </h5>
                </section>

                @include('alerts.alert-section.error')

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('app.data-logger.index') }}" class="btn btn-info btn-sm text-light">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('app.data-logger.update', $device->id) }}" method="post" id="form">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="name">نام تجهیز</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name"
                                        value="{{ old('name', $device->name) }}">
                                </div>
                                @error('name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="mobile_number">شماره سیم کارت</label>
                                    <input type="text" class="form-control form-control-sm" name="mobile_number"
                                        id="mobile_number" value="{{ old('mobile_number', $device->mobile_number) }}">
                                </div>
                                @error('mobile_number')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for=""> نوع تجهیز</label>
                                    <select name="type" id="" class="form-control form-control-sm">
                                        <option value="">نوع را انتخاب کنید</option>
                                        <option value="0" @if (old('type', $device->type) == 0) selected @endif>پمپ
                                        </option>
                                        <option value="1" @if (old('type', $device->type) == 1) selected @endif>چاه
                                        </option>
                                        <option value="2" @if (old('type', $device->type) == 2) selected @endif>منبع
                                        </option>

                                    </select>
                                    @error('type')
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
                                    <label for="model"> مدل دیتالاگر</label>
                                    <select name="model" id="" class="form-control form-control-sm">
                                        <option value="">مدل را انتخاب کنید</option>
                                        <option value="Ps100" @if (old('model', $device->model) == 'Ps100') selected @endif>Ps100
                                        </option>
                                        <option value="Lm412" @if (old('model', $device->model) == 'Lm412') selected @endif>Lm412
                                        </option>

                                    </select>
                                    @error('model')
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
                                    <label for="key_type"> نوع کلید</label>
                                    <select name="key_type" id="key_type" class="form-control form-control-sm">
                                        <option>نوع را انتخاب کنید</option>
                                        <option value="1" @if (old('key_type', $device->key_type) ==1 ) selected @endif>تک کلید
                                        </option>
                                        <option value="2" @if (old('key_type', $device->key_type) ==2 ) selected @endif>دو کلید
                                        </option>

                                    </select>
                                    @error('key_type')
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
                                    <label for="sensor_type"> نوع سنسور</label>
                                    <select name="sensor_type" id="sensor_type" class="form-control form-control-sm">
                                        <option value="">نوع را انتخاب کنید</option>
                                        <option value="level" @if (old('sensor_type', $device->sensor_type) === 'level') selected @endif>level
                                        </option>
                                        <option value="metric" @if (old('sensor_type', $device->sensor_type) === 'metric') selected @endif>metric
                                        </option>
                                    </select>
                                    @error('sensor_type')
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
                                    <label for=""> استان</label>
                                    <select name="city_id" id="city_id" class="form-control form-control-sm">
                                        <option value="">نوع را انتخاب کنید</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                @if (old('city_id', $device->city_id) == $city->id) selected @endif> {{ $city->name }}
                                            </option>
                                        @endforeach


                                    </select>
                                    @error('city_id')
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
                                    <label for="status">وضعیت</label>
                                    <select name="status" id="" class="form-control form-control-sm"
                                        id="status">
                                        <option value="0" @if (old('status', $device->status) == 0) selected @endif>غیرفعال
                                        </option>
                                        <option value="1" @if (old('status', $device->status) == 1) selected @endif>فعال
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="fount_height">ارتفاع منبع </label>
                                    <input type="text" class="form-control form-control-sm" name="fount_height"
                                        id="fount_height" value="{{ old('fount_height', $device->fount_height) }}">
                                </div>
                                @error('fount_height')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="fount_bulk">حجم منبع </label>
                                    <input type="text" class="form-control form-control-sm" name="fount_bulk"
                                        id="fount_bulk" value="{{ old('fount_bulk', $device->fount_bulk) }}">
                                </div>
                                @error('fount_bulk')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="yearly_bulk">حجم برداشت سالانه </label>
                                    <input type="text" class="form-control form-control-sm" name="yearly_bulk"
                                        id="yearly_bulk" value="{{ old('yearly_bulk', $device->yearly_bulk) }}">
                                </div>
                                @error('yearly_bulk')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tags">چک کد ها </label>

                                    <select class="select2 form-control form-control-sm" name="checkCode[]"
                                        id="select_checkCode" multiple>

                                        @foreach ($checkCodes as $checkCode)
                                            <option value="{{ $checkCode->id }}"
                                                @foreach ($device->checkCodes as $datalogger_checkCode)

                                                @if ($datalogger_checkCode->id === $checkCode->id)
                                                selected
                                                    
                                                @endif @endforeach>
                                                {{ $checkCode->name }}</option>
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

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="power"> power </label>

                                    <select class=" form-control form-control-sm" name="power" id="power">
                                        <option value="">چک کد power  را انتخاب کنید</option>

                                        @foreach ($checkCodes as $checkCode)
                                            <option value="{{ $checkCode->id }}"
                                                @if (old('power', $device->power) === $checkCode->id) selected @endif>{{ $checkCode->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('power')
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
@endsection

@section('script')
    <script src="{{ asset('panel-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
    <script>
        $('#select_checkCode').select2({
            placeholder: 'لطفا چک کد ها را انتخاب کنید',
            tags: true,
            dir: "rtl",

        });
    </script>

    <script>
        $(document).ready(function() {
            var tags_input = $('#tags');
            var select_tags = $('#select_tags');
            var default_tags = tags_input.val();
            var default_data = null;

            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
            }

            select_tags.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data
            });
            select_tags.children('option').attr('selected', true).trigger('change');


            $('#form').submit(function(event) {
                if (select_tags.val() !== null && select_tags.val().length > 0) {
                    var selectedSource = select_tags.val().join(',');
                    tags_input.val(selectedSource)
                }
            })
        })
    </script>
@endsection

@extends('app.layouts.master')

@section('head-tag')
    <title> ویرایش تجهیز </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> دیتالاگرها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تجهیز </li>
        </ol>
    </nav>

    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            ویرایش تجهیز
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('app.data-logger.index') }}" class="btn btn-info btn-sm text-light">بازگشت</a>
                    </section>

                    <section>

                        <form action="{{ route('app.data-logger.update', $device) }}" method="post" id="form">
                            @csrf
                            @method('put')

                            <!-- فیلدهای مشترک -->
                            <div class="row">
                                <section class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="industrial_city_id">شهرک صنعتی </label>

                                        <select class=" form-control form-control-sm" name="industrial_city_id">

                                            <option value="">شهرک کاربر را انتخاب کنید</option>
                                            @foreach ($industrials as $industrial)
                                                <option value="{{ $industrial->id }}"
                                                    @if (old('industrial_city_id', $device->industrial_city_id) == $industrial->id) selected @endif>
                                                    {{ $industrial->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @error('industrial_city_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>


                                <section class="col-12 col-md-6 ">
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





                                <!-- Conditional fields based on dataloggerable_type -->
                                @if (class_basename($device->dataloggerable_type) == 'Pump')
                                    <input type="text" name="entity_type" value="pump">
                                    <section class="col-12 col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="name">نام تجهیز</label>
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                id="name" value="{{ old('name', $device->pump->name) }}">
                                        </div>
                                        @error('name')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="datalogger_model"> مدل دیتالاگر</label>
                                            <select name="datalogger_model" id=""
                                                class="form-control form-control-sm">
                                                <option value="">مدل را انتخاب کنید</option>
                                                <option value="Ps100" @if (old('datalogger_model', $device->pump->datalogger_model) == 'Ps100') selected @endif>
                                                    Ps100
                                                </option>
                                                <option value="Lm412" @if (old('datalogger_model', $device->pump->datalogger_model) == 'Lm412') selected @endif>
                                                    Lm412
                                                </option>

                                            </select>
                                            @error('datalogger_model')
                                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </section>
                                @elseif (class_basename($device->dataloggerable_type) == 'Well')
                                    <input type="text" name="entity_type" value="well">

                                    <section class="col-12 col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="name">نام تجهیز</label>
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                id="name" value="{{ old('name', $device->well->name) }}">
                                        </div>
                                        @error('name')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="datalogger_model"> مدل دیتالاگر</label>
                                            <select name="datalogger_model" id=""
                                                class="form-control form-control-sm">
                                                <option value="">مدل را انتخاب کنید</option>
                                                <option value="Ps100" @if (old('datalogger_model', $device->well->datalogger_model) == 'Ps100') selected @endif>
                                                    Ps100
                                                </option>
                                                <option value="Lm412" @if (old('datalogger_model', $device->well->datalogger_model) == 'Lm412') selected @endif>
                                                    Lm412
                                                </option>

                                            </select>
                                            @error('datalogger_model')
                                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </section>
                                    <section class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="flow_rate">دبی</label>
                                            <input type="text" class="form-control form-control-sm" name="flow_rate"
                                                id="flow_rate" value="{{ old('flow_rate', $device->well->flow_rate) }}">
                                        </div>
                                        @error('flow_rate')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="yearly_bulk">حجم برداشت سالانه </label>
                                            <input type="text" class="form-control form-control-sm" name="yearly_bulk"
                                                id="yearly_bulk"
                                                value="{{ old('yearly_bulk', $device->well->yearly_bulk) }}">
                                        </div>
                                        @error('yearly_bulk')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                @elseif (class_basename($device->dataloggerable_type) == 'Source')
                                    <input type="hidden" name="entity_type" value="source" >

                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="name">نام تجهیز</label>
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                id="name" value="{{ old('name', $device->dataloggerable->name) }}">
                                        </div>
                                        @error('name')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="datalogger_model"> مدل دیتالاگر</label>
                                            <select name="datalogger_model" id=""
                                                class="form-control form-control-sm">
                                                <option value="">مدل را انتخاب کنید</option>
                                                <option value="Ps100" @if (old('datalogger_model', $device->dataloggerable->datalogger_model) == 'Ps100') selected @endif>
                                                    Ps100
                                                </option>
                                                <option value="Lm412" @if (old('datalogger_model', $device->dataloggerable->datalogger_model) == 'Lm412') selected @endif>
                                                    Lm412
                                                </option>

                                            </select>
                                            @error('datalogger_model')
                                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </section>
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="sensor_type"> نوع سنسور</label>
                                            <select name="sensor_type" id="sensor_type"
                                                class="form-control form-control-sm">
                                                <option value="">نوع را انتخاب کنید</option>
                                                <option value="level" @if (old('sensor_type', $device->dataloggerable->sensor_type) == 'level') selected @endif>
                                                    level
                                                </option>
                                                <option value="metric" @if (old('sensor_type', $device->dataloggerable->sensor_type) == 'metric') selected @endif>
                                                    metric
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
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="fount_height">ارتفاع منبع </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="fount_height" id="fount_height"
                                                value="{{ old('fount_height', $device->dataloggerable->fount_height) }}">
                                        </div>
                                        @error('fount_height')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-6 ">
                                        <div class="form-group">
                                            <label for="fount_bulk">حجم منبع </label>
                                            <input type="text" class="form-control form-control-sm" name="fount_bulk"
                                                id="fount_bulk"
                                                value="{{ old('fount_bulk', $device->dataloggerable->fount_bulk) }}">
                                        </div>
                                        @error('fount_bulk')
                                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>

                                    <section class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="tags"> چاه ها </label>

                                            <select class="select2 form-control form-control-sm" name="wells[]"
                                                id="select_wells" multiple>

                                                @foreach ($wells as $well)
                                                    <option value="{{ $well->id }}"
                                                        @foreach ($device->dataloggerable->wells as $datalogger_wells)
        
                                                        @if ($datalogger_wells->id === $well->id)
                                                        selected
                                                            
                                                        @endif @endforeach>
                                                        {{ $well->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('wells.*')
                                            <span class="alert-danger rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>

                                    <section class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="tags"> پمپ ها </label>

                                            <select class="select2 form-control form-control-sm" name="pumps[]"
                                                id="select_pumps" multiple>

                                                @foreach ($pumps as $pump)
                                                    <option value="{{ $pump->id }}"
                                                        @foreach ($device->dataloggerable->pumps as $datalogger_pump)
        
                                                        @if ($datalogger_pump->id === $pump->id)
                                                        selected
                                                            
                                                        @endif @endforeach>
                                                        {{ $pump->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('pumps.*')
                                            <span class="alert-danger rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                @endif

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
                                    @error('checkCode.*')
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
                                            <option value="">چک کد power را انتخاب کنید</option>

                                            @foreach ($checkCodes as $checkCode)
                                                <option value="{{ $checkCode->id }}"
                                                    @if (old('power', $device->power) === $checkCode->id) selected @endif>
                                                    {{ $checkCode->name }}
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
                            </div>



                            <section class="col-12 my-3">
                                <button class="btn btn-primary ">ثبت</button>
                            </section>
                        </form>

                    </section>

                </section>
            </section>
        </section>
    </main>
@endsection

@section('script')
    <script>
        $('#select_checkCode').select2({
            placeholder: 'لطفا چک کد ها را انتخاب کنید',
            tags: true,
            dir: "rtl",

        });
    </script>
    <script>
        $('#select_pumps').select2({
            placeholder: 'لطفا  پمپ ها را انتخاب کنید',
            tags: true,
            dir: "rtl",

        });
    </script>
    <script>
        $('#select_wells').select2({
            placeholder: 'لطفا  چاه ها را انتخاب کنید',
            tags: true,
            dir: "rtl",

        });
    </script>

   
@endsection

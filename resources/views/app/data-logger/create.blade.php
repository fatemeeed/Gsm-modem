@extends('app.layouts.master')

@section('head-tag')
    <title> افزودن تجهیز جدید</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> دیتالاگرها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> افزودن تجهیز جدید</li>
        </ol>
    </nav>

    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            افزودن تجهیز جدید
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('app.data-logger.index') }}" class="btn btn-info btn-sm text-light">بازگشت</a>
                    </section>

                    <section>

                        <form action="{{ route('app.data-logger.store') }}" method="post" id="form">
                            @csrf

                            <!-- فیلدهای مشترک -->
                            <div class="row">
                                <section class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="industrial_city_id">شهرک صنعتی </label>

                                        <select class=" form-control form-control-sm" name="industrial_city_id">

                                            <option value="">شهرک کاربر را انتخاب کنید</option>
                                            @foreach ($industrials as $industrial)
                                                <option value="{{ $industrial->id }}">
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
                                <section class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for=""> نوع تجهیز</label>
                                        <select name="entity_type" id="" class="form-control form-control-sm"
                                            onchange="handleEntityTypeChange(this.value)">
                                            <option value="">نوع را انتخاب کنید</option>
                                            <option value="pump" @if (old('entity_type') == 'pump') selected @endif>پمپ
                                            </option>
                                            <option value="well" @if (old('entity_type') == 'well') selected @endif>چاه
                                            </option>
                                            <option value="source" @if (old('entity_type') == 'source') selected @endif>منبع
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
                                        <label for="name">نام تجهیز</label>
                                        <input type="text" class="form-control form-control-sm" name="name"
                                            id="name" value="{{ old('name') }}">
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
                                            id="mobile_number" value="{{ old('mobile_number') }}">
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
                                        <label for="datalogger_model"> مدل دیتالاگر</label>
                                        <select name="datalogger_model" id="" class="form-control form-control-sm">
                                            <option value="">مدل را انتخاب کنید</option>
                                            <option value="Ps100" @if (old('datalogger_model') == 'Ps100') selected @endif>Ps100
                                            </option>
                                            <option value="Lm412" @if (old('datalogger_model') == 'Lm412') selected @endif>Lm412
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
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="status">وضعیت</label>
                                        <select name="status" id="" class="form-control form-control-sm"
                                            id="status">
                                            <option value="0" @if (old('status') == 0) selected @endif>
                                                غیرفعال
                                            </option>
                                            <option value="1" @if (old('status') == 1) selected @endif>فعال
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
                            </div>

                            <!-- فیلدهای خاص -->
                            <div id="dynamic-fields" class="row"></div>

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
        function handleEntityTypeChange(type) {
            const dynamicFields = document.getElementById('dynamic-fields');
            dynamicFields.innerHTML = '';

            if (type === 'source') {
                dynamicFields.innerHTML = `
                 <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="sensor_type"> نوع سنسور</label>
                                        <select name="sensor_type" id="sensor_type" class="form-control form-control-sm">
                                            <option value="">نوع را انتخاب کنید</option>
                                            <option value="level" @if (old('sensor_type') == 'level') selected @endif>
                                                level
                                            </option>
                                            <option value="metric" @if (old('sensor_type') == 'metric') selected @endif>
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
                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="fount_height">ارتفاع منبع </label>
                                        <input type="text" class="form-control form-control-sm" name="fount_height"
                                            id="fount_height" value="{{ old('fount_height') }}">
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
                                            id="fount_bulk" value="{{ old('fount_bulk') }}">
                                    </div>
                                    @error('fount_bulk')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>
            `;
            } else if (type === 'well') {
                dynamicFields.innerHTML = `
                
                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="flow_rate">دبی</label>
                                        <input type="text" class="form-control form-control-sm" name="flow_rate"
                                            id="flow_rate" value="{{ old('flow_rate') }}">
                                    </div>
                                    @error('flow_rate')
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
                                            id="yearly_bulk" value="{{ old('yearly_bulk') }}">
                                    </div>
                                    @error('yearly_bulk')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>
            `;
            } else if (type === 'pump') {
                dynamicFields.innerHTML = `
                
            `;
            }
        }
    </script>
@endsection

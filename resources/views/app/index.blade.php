@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
    <section class="container">
        

        @foreach ($dataloggers as $datalogger)
            @php
                $componentName = 'dataloggers.' . $datalogger->deviceSahpe;
            @endphp


            {{-- <livewire:{{ 'dataloggers.'. $datalogger->deviceSahpe }} /> --}}



            <section class="shape">
                <section class="d-flex justify-content-between w-100">
                    <section class="status">



                        {{ $datalogger->dataloggerLastStatus() }}
                        <span class="{{ $datalogger->dataloggerLastStatus() }}">

                        </span>


                    </section>

                    @livewire('datalogger-toggle', ['datalogger' => $datalogger], key($datalogger->id))



                </section>
                @livewire($componentName, ['datalogger' => $datalogger], key($datalogger->id))



                <div class="d-flex pt-3 flex-column w-100">

                    <h5 class="d-flex ">{{ $datalogger->name ?? ' ' }}</h5>
                    <section class="d-flex justify-content-between">
                        <p class="text-secondary">{{ jalaliDate($datalogger->lastRecieveMessage()->time) ?? ' ' }}</p>
                        <a href=""><i class="fas fa-reply text-secondary"></i></a>
                    </section>

                </div>


            </section>
        @endforeach
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.source').each(function() {
                var level = $(this).data('level'); // دریافت مقدار level از ویژگی data-level
                var height = 0; // مقدار پیش‌فرض ارتفاع

                // تبدیل سطح به درصد
                switch (level) {
                    case 'level-0':
                        height = 0; // منبع خالی
                        break;
                    case 'level-1':
                        height = 25; // 25 درصد پر
                        break;
                    case 'level-2':
                        height = 50; // 50 درصد پر
                        break;
                    case 'level-3':
                        height = 75; // 75 درصد پر
                        break;
                    case 'level-4':
                        height = 100; // کاملاً پر
                        break;
                    default:
                        height = 0; // مقدار پیش‌فرض برای مقادیر نامعتبر
                }

                // تنظیم ارتفاع سطح آب
                $(this).find('.source-level').css('height', height + '%');
            });
        });
    </script>
@endsection

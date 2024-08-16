@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
    <section class="container">
        @foreach ($dataloggers as $datalogger)
            <section class="shape">
                <section class="d-flex justify-content-between w-100">
                    <section class="status">
                        @if (empty($datalogger->dataloggerLastStatus()))
                            {{ 'disconnect' }}
                        @else
                            {{ $datalogger->dataloggerLastStatus() }}
                            <span class="@if ($datalogger->dataloggerLastStatus() && $datalogger->power) {{ $datalogger->dataloggerLastStatus() }} @endif">

                            </span>
                        @endif

                    </section>

                    @livewire('dataloggerToggle', ['dataloggerStatus' => $datalogger->dataloggerLastStatus()])

                </section>
                <section class=" {{ $datalogger->deviceSahpe ?? ' ' }}  ">
                    @if ($datalogger->deviceSahpe == 'source')
                        {{-- <div class="volume-label">Current Volume: 70%</div> --}}

                        <span class="volume-label">11230</span>
                    @endif
                </section>

                <div class="d-flex pt-3 flex-column w-100">




                    <h5 class="d-flex ">{{ $datalogger->name ?? ' ' }}</h5>
                    <section class="d-flex justify-content-between">
                        <p class="text-secondary">{{ jalaliDate($datalogger->lastRecieveMessage()->time) }}</p>
                        <a href=""><i class="fas fa-reply text-secondary"></i></a>
                    </section>







                </div>







            </section>
        @endforeach
    </section>
@endsection

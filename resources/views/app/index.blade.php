@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
    @foreach ($dataloggers as $datalogger)
        <section
            class="shape {{ $datalogger->deviceSahpe ?? ' ' }}   @if ($datalogger->dataloggerLastStatus() && $datalogger->power) {{ $datalogger->dataloggerLastStatus() }} @endif   
            
        ">
            <h5 class="d-flex text-center ">{{ $datalogger->name ?? ' ' }}</h5>
            <h6>
                @if (empty($datalogger->dataloggerLastStatus()))
                    {{ 'disconnect' }}
                @else
                    {{ $datalogger->dataloggerLastStatus() }}
                @endif
            </h6>

        </section>
    @endforeach
@endsection

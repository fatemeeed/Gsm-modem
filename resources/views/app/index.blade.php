@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
    @foreach ($dataloggers as $datalogger)

    {{ var_dump($datalogger->lastRecieveMessage()) }}
        <section
            class="{{ $datalogger->deviceSahpe ?? ' ' }}   @if ($datalogger->dataloggerLastStatus() && $datalogger->power) {{ $datalogger->dataloggerLastStatus() }} @endif   
            
        ">
            <h6 class="d-flex text-center ">{{ $datalogger->name ?? ' ' }}</h6>





        </section>
    @endforeach
@endsection

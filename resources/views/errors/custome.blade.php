@extends('errors.minimal')

@section('title')
    {{ 'GSM connection Error' }}
@endsection
@section('code')
    {{ $code }}
@endsection
@section('message')
    {{ $message }}
@endsection

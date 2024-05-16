@extends('app.layouts.master')
@section('title')
    <title >ارسال پیام جدید</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb" dir="rtl">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">پیام ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">  ارسال پیام جدید</li>
        </ol>
    </nav>


    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                             ارسال پیام جدید
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('admin.Message.index') }}"  class="disabled btn btn-info btn-sm text-light">
                             بازگشت</a>
                        
                    </section>

                   

                </section>
            </section>
        </section>
    </main>
@endsection
@section('script')
@endsection


@include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])

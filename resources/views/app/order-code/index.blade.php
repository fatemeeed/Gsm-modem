@extends('app.layouts.master')

@section('title')
    <title>کد های کنترل</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">  کدهای کنترل </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>کدهای کنترل   </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.order-code.create') }}">ایجاد کد کنترل جدید</a>

                    <div class="max-width-16-rem">

                        <input type="text" placeholder="جستجو" class="form-control form-control-sm form-text">


                    </div>

                </section>

                <section class="table-responsive">

                    <table class="table table-striped font-size-14 table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>order</th>
                                <th>نام کد</th>
                                <th>توضیحات کد</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $order->order }}</th>
                                    <th>{{ $order->name }}</th>
                                    <th>{{ $order->description }}</th>
                                    <th>{{ $order->status == 1 ? 'فعال' : 'غیرفعال'}}</th>
                                    <td class=" text-left">
                                        
                                        <a href="{{ route('app.order-code.edit', $order->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i>
                                            حذف</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                </section>






            </section>

        </section>




    </section>
@endsection

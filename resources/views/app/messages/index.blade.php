@extends('app.layouts.master')
@section('title')
    <title>پیام ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb" dir="rtl">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> پیام ها</li>
        </ol>
    </nav>


    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            پیام ها
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('admin.Message.send-message') }}"  class="disabled btn btn-info btn-sm text-light">
                            ارسال پیام</a>
                        <div class="max-width-16-rem">
                            <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                        </div>
                    </section>

                    <section class="table-responsive">
                        <table class="table table-striped table-hover font-size-14 table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>شماره سرخط </th>
                                    <th>تاریخ </th>
                                    <th>نام تجهیز </th>
                                    <th>پیام </th>
                                    <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($messages as $message)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $message->from }}</td>
                                        <td>{{ $message->date_time }}</td>
                                        <td></td>
                                        <td>{{ $message->content }}</td>
                                        <td>

                                        </td>
                                        <td class="width-16-rem text-center ">


                                            {{-- <form action="{{ route('admin.content.category.destroy', $category) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit"><i
                                                        class="fa fa-trash-alt"></i> حذف</button>
                                            </form> --}}

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </section>

                </section>
            </section>
        </section>
    </main>
@endsection
@section('script')
@endsection


@include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])

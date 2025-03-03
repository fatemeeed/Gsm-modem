@extends('app.layouts.master')

@section('title')
    <title>کد های کنترل</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> کدهای کنترل </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>کدهای کنترل </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.order-code.create') }}">ایجاد کد کنترل
                        جدید</a>

                    <div class="max-width-16-rem">

                        {{-- <input type="text" placeholder="جستجو" class="form-control form-control-sm form-text"> --}}


                    </div>

                </section>

                <section class="table-responsive">

                    <table class="table table-striped font-size-14 table-bordered table-hover text-center" id="datatable">
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
                                    <th>
                                        <label>
                                            <input id="{{ $order->id }}" onchange="changeStatus({{ $order->id }})"
                                                data-url="{{ route('app.order-code.status', $order->id) }}" type="checkbox"
                                                @if ($order->status === 1) checked @endif>
                                        </label>
                                    </th>
                                    <td class=" text-left">

                                        <a href="{{ route('app.order-code.edit', $order->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
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

@section('script')
    <script>
        $(document).ready(function() {


            new DataTable('#datatable', {
                fixedColumns: true,
                paging: false,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 400
            });
        });
    </script>
    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast(' کد فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast(' کد غیرفعال شد')
                        }
                    } else {
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message) {

                var successToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(successToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }

            function errorToast(message) {

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }
        }
    </script>

    @include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection

@extends('app.layouts.master')
@section('title')
    <title>کدهای کنترل</title>
    <link rel="stylesheet" href="{{ asset('assets/css/toggle-switch.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb" dir="rtl">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">تجهیزات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> کدهای کنترل</li>
        </ol>
    </nav>


    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            کدهای کنترل
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('app.data-logger.order-code.create',$device->id) }}" class="btn btn-info btn-sm text-light">
                            افزودن کد جدید</a>
                        <div class="max-width-16-rem">
                            <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                        </div>
                    </section>

                    <section class="table-responsive">
                        <table class="table table-striped font-size-14 table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام </th>
                                    <th>بازه زمانی </th>
                                    <th>وضعیت</th>

                                    <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody>

                                
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>
                                            {{-- <label>
                                                <input id="{{ $device->id }}"
                                                    onchange="changeStatus({{ $device->id }})"
                                                    data-url="{{ route('app.data-logger.status', $device->id) }}"
                                                    type="checkbox" @if ($device->status === 1) checked @endif>
                                            </label> --}}

                                            {{-- <label class="switch">
                                                @if ($device->power && $device->dataloggerLastStatus())
                                                    <input type="checkbox" id="{{ $device->id }}"
                                                        onchange="changeStatus({{ $device->id }})"
                                                        data-url="{{ route('app.data-logger.status', $device->id) }}"
                                                        @if ($device->dataloggerLastStatus() === 'ON') checked @endif>



                                                    <span class="slider round"></span>
                                                @else
                                                    <span class="text-danger">نامشخص</span>
                                                @endif

                                            </label> --}}
                                        </td>
                                        
                                        <td class="width-13-rem text-right font-size-2 ">
                                            <div class="dropdown" dir="rtl">
                                                <a href="" class="btn btn-success btn-sm btn-block dropdown-toggle"
                                                    role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                    aria-expanded="false">

                                                    <i class="fa fa-tools"></i> عملیات

                                                </a>
                                                <div class="dropdown-menu  text-right" aria-labelledby="dropdownMenuLink">

                                                    {{-- <a class="dropdown-item" href="{{ route('app.data-logger.check-code', $device->id) }}"><i class="fa fa-key"></i> چک کد
                                                    </a> --}}
                                                    <a href="{{ route('app.data-logger.edit', $device->id) }}"
                                                        class="dropdown-item"><i class="fa fa-edit"></i>
                                                        ویرایش</a>

                                                    

                                                    <form action="{{ route('app.data-logger.destroy', $device->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item" type="submit"><i
                                                                class="fa fa-trash-alt"></i>
                                                            حذف</button>
                                                    </form>

                                                </div>


                                            </div>


                                        </td>
                                    </tr>
                                

                            </tbody>
                        </table>
                    </section>
                </section>
            </section>
        </section>
    </main>
@endsection
@section('script')
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
                            successToast('تجهیز  فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast(' تجهیز غیرفعال شد')
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

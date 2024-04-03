@extends('app.layouts.master')
@section('title')
    <title>تجهیزات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb" dir="rtl">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> تجهیزات</li>
        </ol>
    </nav>


    <main>
        <section class="row">
            <section class="col-12">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            تجهیزات
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('app.data-logger.create') }}" class="btn btn-info btn-sm text-light">ایجاد
                        افزودن تجهیز جدید</a>
                        <div class="max-width-16-rem">
                            <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                        </div>
                    </section>

                    <section class="table-responsive">
                        <table class="table table-striped font-size-14 table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام  </th>
                                    <th>نوع تجهیز</th>
                                    <th> شماره خط</th>
                                    <th>مدل  </th>
                                    <th>نوع سنسور  </th>
                                    <th>نوع کلید  </th>
                                    <th>محل تجهیز  </th>
                                    <th>ارتفاع  </th>
                                    <th>حجم  </th>
                                    <th>حجم برداشت سالانه  </th>
                                    <th>وضعیت</th>
                                    <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody >

                                @foreach ($devices as $device)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $device->name }}</td>
                                    <td>{{ $device->dataLoggerType }}</td>
                                    <td>{{ $device->mobile_number}}</td>
                                    <td>{{ $device->model}}</td>
                                    <td>{{ $device->sensor_type}}</td>
                                    <td>{{ $device->key_type ==1 ? 'تک کلید' : 'دو کلید'}}</td>
                                    <td>{{ $device->city->name}}</td>
                                    <td>{{ $device->fount_height }}</td>
                                    <td>{{ $device->fount_bulk }}</td>
                                    <td>{{ $device->yearly_bulk }}</td>
                                    <td>
                                        <label>
                                            <input id="{{ $device->id }}" onchange="changeStatus({{ $device->id }})"
                                                data-url="{{ route('app.data-logger.status', $device->id) }}"
                                                type="checkbox" @if ($device->status === 1) checked @endif>
                                        </label>
                                    </td>
                                    <td class="width-16-rem text-center ">
                                        <a href="{{ route('app.data-logger.edit', $device->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>

                                        <form action="{{ route('app.data-logger.destroy', $device->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm" type="submit"><i
                                                    class="fa fa-trash-alt"></i> حذف</button>
                                        </form>

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
                            successToast('دسته بندی با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast('دسته بندی با موفقیت غیر فعال شد')
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

                var successToastTag = '<section class="toast-container">' +
                    '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +

                    '<div class="toast-body d-flex justify-content-between bg-success text-white">' + message +
                    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'
                '</div>' +
                '</div>';

                '</section>';


                $('.toast-wrapper').append(successToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }

            function errorToast(message) {

                var errorToastTag = '<section class="toast-container">' +
                    '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +

                    '<div class="toast-body d-flex justify-content-between bg-danger text-white">' + message +
                    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'
                '</div>' +
                '</div>';

                '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }
        }
    </script>
@endsection


@include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])

 @extends('app.layouts.master')
 @section('title')
     <title>تنظیمات مودم</title>
 @endsection

 @section('content')
     <nav aria-label="breadcrumb" dir="rtl">
         <ol class="breadcrumb">
             <li class="breadcrumb-item font-size-12"> <a href="#">داشبورد</a></li>
             <li class="breadcrumb-item font-size-12 active" aria-current="page"> تنظیمات مودم</li>
         </ol>
     </nav>


     <main>
         <section class="row">
             <section class="col-12">
                 <section class="main-body-container">
                     <section class="main-body-container-header">
                         <h5>
                             تنظیمات مودم
                         </h5>
                     </section>

                     @if (session('modem_error'))
                         <div class="alert alert-danger" role="alert">
                             {{ session('modem_error')['message'] }}
                         </div>
                     @endif


                     <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                         <a class="btn btn-info btn-sm text-light" href="{{ route('app.setting.create') }}">ایجاد تنظیمات
                             کنترل جدید</a>

                         <div class="max-width-16-rem">
                             {{-- <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو"> --}}
                         </div>
                     </section>

                     <section class="table-responsive">
                         <table class="table table-striped table-hover font-size-14 table-bordered">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>شهرک صنعتی</th>
                                     <th>port </th>
                                     <th>baud rate </th>
                                     <th> فعالسازی </th>
                                     <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                 </tr>
                             </thead>
                             <tbody>


                                 @foreach ($settings as $setting)
                                     <tr>
                                         <th>{{ $loop->iteration }}</th>
                                         <th>{{ $setting->industrialCity->name }}</th>
                                         <td>{{ $setting->port }}</td>
                                         <td>{{ $setting->baud_rate }}</td>
                                         <th>
                                             <label>
                                                 <input id="{{ $setting->id }}"
                                                     onchange="changeStatus({{ $setting->id }})"
                                                     data-url="{{ route('app.setting.status', $setting->id) }}" type="checkbox"
                                                     @if ($setting->status === 1) checked @endif>
                                             </label>
                                         </th>
                                         <td class="width-16-rem text-center ">
                                             <a href="{{ route('app.setting.edit', $setting->id) }}"
                                                 class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>
                                                 ویرایش</a>

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
                             successToast('تنظیمات فعال شد')
                         } else {
                             element.prop('checked', false);
                             successToast('تنظیمات غیرفعال شد')
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

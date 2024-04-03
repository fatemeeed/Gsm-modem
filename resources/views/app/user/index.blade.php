@extends('app.layouts.master')

@section('head-tag')
    <title> مدیریت کاربران </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('app.index') }}"> خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">مدیریت کاربران </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> کاربران </h5>
                    <p></p>

                </section>


                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.user.create') }}">ایجاد کاربر جدید</a>

                    <div class="max-width-16-rem">

                        <input type="text" placeholder="جستجو" class="form-control form-control-sm form-text">


                    </div>

                </section>

                <section class="table-responsive">

                    <table class="table table-striped font-size-14 table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام کاربری </th>
                               
                                <th>نام کاربر </th>
                                <th>نام خانودگی کاربر </th>
                                
                                <th> فعالسازی </th>
                                {{-- <th>وضعیت  </th> --}}
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $user->national_code }}</th>
                                    
                                    <th>{{ $user->first_name }}</th>
                                    <th>{{ $user->last_name }}</th>
                                   
                                    <th>
                                        <label>
                                            <input id="{{ $user->id }}"
                                                onchange="changeActivation({{ $user->id }})"
                                                data-url="{{ route('app.user.activation', $user->id) }}" type="checkbox"
                                                @if ($user->activation === 1) checked @endif>
                                        </label>
                                    </th>
                                    {{-- <th>
                                        <label>
                                            <input id="{{ $user->id }}" onchange="changeStatus({{ $user->id }})" data-url="{{ route('admin.user.status', $user->id) }}" type="checkbox" @if ($user->status === 1)
                                            checked
                                            @endif>
                                        </label>
                                    </th> --}}
                                    <th class="width-22-rem text-left">
                                        {{-- <a href="" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> نقش </a> --}}
                                        <a href="{{ route('app.user.reset-password', $user->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> ریست پسورد </a>
                                        <a href="{{ route('app.user.edit', $user->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                            {{-- <form action="{{ route('admin.user.destroy', $user->id) }}" class="d-inline" method="POST">

                                                @csrf
                                                {{ method_field('delete') }}

                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                        class="fa fa-trash-alt"></i> حذف</button>
                                            </form> --}}

                                    </th>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {!! $users->appends(['sort' => 'department'])->links() !!}

                </section>

            </section>

        </section>

    </section>
@endsection
@section('script')
    {{-- <script type="text/javascript">
        function changeStatus(id){
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url : url,
                type : "GET",
                success : function(response){
                    if(response.status){
                        if(response.checked){
                            element.prop('checked', true);
                            successToast('کاربر فعال شد')
                        }
                        else{
                            element.prop('checked', false);
                            successToast('کاربر غیرفعال شد')
                        }
                    }
                    else{
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error : function(){
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message){

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

            function errorToast(message){

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
    </script> --}}
    <script type="text/javascript">
        function changeActivation(id) {
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
                            successToast('وضعیت کاربر فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast('وضعیت کاربر غبرفعال شد')
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

@extends('app.layouts.master')

@section('title')
    <title> چک کدها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> چک کد ها </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> چک کد ها </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.check-code.create') }}">ایجاد چک کد
                        جدید</a>

                    <div class="max-width-16-rem">

                        <input type="text" placeholder="جستجو" class="form-control form-control-sm form-text">


                    </div>

                </section>

                <section class="table-responsive">

                    <table class="table table-striped font-size-12 table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام کد</th>
                                <th> دیتالاگر ها </th>
                                <th class="width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkCodes as $checkCode)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $checkCode->name }}</th>
                                    <th>
                                        @if (empty($checkCode->dataLoggers()->get()->toArray()))
                                            <span class="text-danger"> دیتالاگر تعریف نشده</span>
                                        @else
                                            @foreach ($checkCode->dataLoggers as $dataLogger)
                                                {{ $dataLogger->name }}</br>
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="width-22-rem text-left">

                                        <a href="{{ route('app.check-code.edit', $checkCode->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form action="{{ route('app.check-code.destroy', $checkCode->id) }}" method="POST"  class="d-inline">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-trash-alt"></i>
                                                حذف</button>

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
@endsection

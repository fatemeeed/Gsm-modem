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

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        
                        <div class="max-width-16-rem">
                            <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                        </div>
                    </section>

                    <section class="table-responsive">
                        <table class="table table-striped table-hover font-size-14 table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>port  </th>
                                    <th>baud rate  </th>
                                    <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settings as $setting)

                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $setting->port }}</td>
                                    <td>{{ $setting->baud_rate }}</td>
                                    <td class="width-16-rem text-center ">
                                        <a href="{{ route('admin.setting.edit', $setting->id) }}"
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


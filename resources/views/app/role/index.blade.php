@extends('app.layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('app.index') }}"> خانه</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نقش ها </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> نقش ها </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm text-light" href="{{ route('app.role.create') }}">ایجاد نقش جدید</a>

                    <div class="max-width-16-rem">

                        {{-- <input type="text" placeholder="جستجو" class="form-control form-control-sm form-text"> --}}


                    </div>

                </section>

                <section class="table-responsive">

                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام نقش</th>
                                <th> توضیح نقش</th>
                                
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $role->name }}</th>
                                    <th>{{ $role->description }}</th>
                                    
                                    <td class="width-22-rem text-center">
                                        
                                        <a href="{{ route('app.role.edit', $role->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>

                                        <form class="d-inline" action="{{ route('app.role.destroy', $role->id) }}" method="POST" >
                                            @csrf
                                            {{ method_field('delete') }}
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
    
@endsection

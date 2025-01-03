@extends('base::layouts.master')

@section('head-tag')
    <title> دسترسی شهرک ها </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی شهرک ها</li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5> شهرک ها</h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm" href="{{ route('app.user.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('app.user.industrial-store', $user) }}" method="post">
                        @csrf

                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tags">شهرک ها ها </label>

                                    <select class="select2 form-control form-control-sm" name="agency[]" id="select_tags"
                                    multiple>


                                    @foreach ($agencies as $agency)
                                        <option value="{{ $agency->id }}"
                                            @foreach ($user->agencies as $agency_user)

                                            @if ($agency_user->id === $agency->id)
                                            selected
                                                
                                            @endif @endforeach>
                                            {{ $agency->name }}</option>
                                    @endforeach

                                </select>
                                </div>
                                @error('agency')
                                    <span class="alert-danger rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-4">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>


                    </form>


                </section>

            </section>

        </section>

    </section>
@endsection
@section('script')
    <script>
        $('#select_tags').select2({
            placeholder: 'لطفا نمایندگی ها را انتخاب کنید',
            tags: true,

        });
    </script>
@endsection

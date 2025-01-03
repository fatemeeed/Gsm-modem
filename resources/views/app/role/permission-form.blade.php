@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش دسترسی ها </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> کاربران </a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> نقش ها </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش دسترسی ها </li>
        </ol>
    </nav>

    <section class="row">

        <section class="col-12">

            <section class="main-body-container">

                <section class="main-body-container-header">

                    <h5>ویرایش دسترسی ها </h5>
                    <p></p>

                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">

                    <a class="btn btn-info btn-sm" href="{{ route('admin.user.role.index') }}">بازگشت </a>


                </section>

                <section>

                    <form action="{{ route('admin.user.role.permission-update', $role->id) }}" method="post">

                        @csrf
                        @method('put')

                        <section class="row">

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">عنوان نقش : </label>
                                    <label for="">{{ $role->name}}</label>
                                </div>
                                
                            </section>

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">توضیح نقش: </label>
                                    <label for="">{{ $role->description }} </label>
                                </div>
                            </section>

                            <section class="col-12 col-md-2">

                                <button class="btn btn-primary btn-sm">ثبت</button>

                            </section>

                            <section class="col-12">

                                @php
                                    
                                    $rolePermissionArray=$role->permissions->pluck('id')->toArray();
                               
                                @endphp

                                
                                <section class="row border-top mt-3 py-3">

                                    @foreach ($permissions as $key => $permission)

                                        <section class="col-md-3">

                                            <div>

                                                <input type="checkbox" class="form-check-input"
                                                    value="{{ $permission->id }}" name="permission_id[]" id="check1"
                                                    @if (in_array($permission->id,$rolePermissionArray))  checked @endif>

                                                <label for="check1"  class="form-check-label mr-3 mt-1">{{ $permission->name }} </label>

                                            </div>

                                        </section>
                                    @endforeach

                                    <div class="mt-2">

                                        @error('permission'.$key)

                                            <span class="alert-danger text-white bg-danger rounded" role="alert">

                                                <strong>

                                                    {{ $message }}

                                                </strong>
                                            </span>

                                        @enderror
                                    </div>

                                </section>
                            </section>

                        </section>

                    </form>

                </section>

            </section>

        </section>

    </section>
@endsection

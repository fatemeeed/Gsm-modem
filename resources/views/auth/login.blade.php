<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('login-assets/css/bootstrap/bootstrap.min.css')}}  ">
    <link rel="stylesheet" href="{{ asset('login-assets/ontawesome/css/all.min.css')}} f">
    <link rel="stylesheet" href="{{ asset('login-assets/css/login.css')}} ">
    <title>ورود</title>
</head>

<body>

    <section class="login-container p-5">
        <section class="row">
            <section class="col-12 col-md-12">
                <section class="login-header">
                    <section class="header-logo">
                        

                    </section>

                    <section class="title text-center">
                        <h5>پرتال سهامداران</h5>
                    </section>
                </section>
            </section>
        </section>
        <section class="row">
            <section class="col-12 col-md-12">
                <form action="{{ route('auth.login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <!-- <label for="exampleInputEmail1" class="form-label"> نام کاربری</label> -->
                        <input type="text" class="form-control" name="national_code" placeholder="نام کاربری" id="exampleInputEmail1" aria-describedby="emailHelp">
                        
                    </div>
                    <div class="mb-3">
                        <!-- <label for="exampleInputPassword1" class="form-label">رمز عبور</label> -->
                        <input type="password" class="form-control" placeholder="رمزعبور" name="password" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-success">ورود</button>
                </form>

            </section>
        </section>
    </section>


</body>

</html>
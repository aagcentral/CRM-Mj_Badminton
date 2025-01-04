<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-4 d-flex flex-column  justify-content-center">


                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="text-danger small">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success small">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="card mb-3 pb-3 shadow">

                            <div class="card-body">
                                <div class="text-center mt-3 mb-4">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" style="height:80px; width:200px;">
                                    <p class="card-title text-center p-0 m-0 small">Reset Password</p>
                                    <p class="text-center small p-0 m-0">Enter your New Password & password Confirm Password</p>
                                </div>

                                @include('auth.message')
                                <form action="{{ route('password.update') }}" method="POST">
                                    @csrf

                                    <!-- Email Field -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" required>
                                    </div>

                                    <!-- New Password Field -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
                                        <a href="{{ route('sign.out') }}" class="btn btn-primary">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </section>

    </div>


</body>

</html>
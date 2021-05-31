@extends('layouts.guest')
@section('content')
<main>
    <div class="container">
        <div class="row h-100">
            <div class="col-12 col-md-6 mx-auto my-auto">
                <div class="card auth-card">
                    <div class="card-body">
                        <a href="/" style="margin-bottom:10px">
                        <span class="logo d-none d-xs-block mb-4">
                            <img src="https://qrlogins.s3-ap-southeast-2.amazonaws.com/img/logo-black.svg" alt="" class="">
                        </span>
                        </a>
                        <h6 class="mb-4">Login</h6>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <label class="form-group has-float-label mb-4">
                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span>E-mail</span>
                            </label>

                            <label class="form-group has-float-label mb-4">
                                <input class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" type="password" placeholder="" />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span>Password</span>
                            </label>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('password.request') }}">Forget password?</a>
                                <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
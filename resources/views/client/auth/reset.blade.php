@extends('client.master')
@section('content')
    <section class="normal-breadcrumb set-bg" data-setbg="{{ asset('assets/client/img/normal-breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Forgot password</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Forgot password</h3>
                        <form action="{{ route('check-reset') }}" method="post">
                            @csrf

                            <div class="input__item">
                                <input type="text" placeholder="Password" name="password">
                                <span class="icon_lock"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" placeholder="Confirm Password" name="confirm-password">
                                <span class="icon_lock"></span>
                            </div>





                            <button type="submit" class="site-btn">Send Now</button>
                        </form>
                        <a href="{{ route('login') }}" class="forget_pass">Login</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Dont’t Have An Account?</h3>
                        <a href="{{ route('showRegister') }}" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="login__social">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="login__social__links">
                            <span>or</span>
                            <ul>
                                {{-- <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With
                                        Facebook</a></li> --}}
                                <li><a href="{{ route('google.redirect') }}" class="google"><i class="fa fa-google"></i>
                                        Sign in With Google</a>
                                </li>
                                {{-- <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Sign in With Twitter</a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

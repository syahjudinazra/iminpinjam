@extends('layouts.app')

@section('container')
    <section class="vh-100" style="background-color: #333333;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="{{ asset('img/screen-test.png') }}" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem; height:100%" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="/login" method="POST">
                                        @csrf

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <img src="{{ asset('img/iminlogo.png') }}" alt="imin logo" height="50px">
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account
                                        </h5>

                                        {{-- <div class="form-outline mb-4">
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-lg" style="color: black !important" />
                                            <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                        </div> --}}

                                        <div class="form-outline mb-4">
                                            <input type="name" name="name" id="name"
                                                class="form-control form-control-lg" style="color: black !important" />
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                        </div>

                                        <div>
                                            <div class="form-outline mb-4">
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-lg" style="color: black !important" />
                                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                            </div>
                                            <div>
                                                <a href="{{ route('forgot.password') }}" class="mb-2"
                                                    style="color:#393f81; float: right; margin-top: -20px; text-decoration:none">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block"
                                                type="submit">{{ __('Login') }}</button>
                                        </div>

                                        {{-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                                href="/register" style="color: #393f81;">Register here</a></p> --}}

                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                                href="/pinjam" style="color: #393f81; text-decoration:none">Login as
                                                guest</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

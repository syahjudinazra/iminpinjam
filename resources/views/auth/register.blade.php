@extends('layouts.app')

@section('container')
    <section class="vh-100" style="background-color: #333333;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form class="mx-1 mx-md-4" method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                                <input id="name" type="text"
                                                    class="form-control shadow-none @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name') }}" required autocomplete="name"
                                                    autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control shadow-none @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                                <input id="password" type="password"
                                                    class="form-control shadow-none @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">


                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label"
                                                    for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password"
                                                    class="form-control shadow-none" name="password_confirmation" required
                                                    autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-check d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value=""
                                                id="checkRegister" required />
                                            <label class="form-check-label" for="form2Example3">
                                                I agree all statements in <a href="#!">Terms of service</a>
                                                <p class="pb-lg-2" style="color: #000000;">Already Registered? <a
                                                        href="/login" style="color: #3b71ca;">Login here</a></p>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit"
                                                class="btn btn-dark btn-lg">{{ __('Register') }}</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="{{ asset('img/Swan-1-dual-screen.png') }}" class="img-fluid" alt="Swan1">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('container')
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center
        min-vh-100">

            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>Forgot Password?</h5>
                            <p class="mb-2">Enter your registered email ID to reset the password
                            </p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control shadow-none" name="email"
                                    placeholder="Enter Your Email" required="">
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-danger" value="Request Password Reset">
                                    Reset Password
                                </button>
                            </div>
                            {{-- <span>Don't have an account? <a href="/login">sign in</a></span> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

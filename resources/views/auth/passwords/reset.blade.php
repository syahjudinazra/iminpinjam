@extends('layouts.app')

@section('container')
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center
        min-vh-100">

            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>Reset Password</h5>
                            <p class="mb-2">Note: Jika berhasil akan kembali ke menu login
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
                        <form action="{{ route('update.password') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="token" value="{{ request()->token }}">
                                <input type="hidden" name="email" value="{{ request()->email }}">
                                <label for="password" class="form-label"><b>Password</b></label>
                                <input type="password" id="password" class="form-control mb-2" name="password"
                                    placeholder="Enter Your New Password">
                                <label for="password_confirmation" class="form-label"><b>Password Confirmation</b></label>
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation" placeholder="Enter Your Password Confirmation">
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary" value="Update Password">
                                    Update Password
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

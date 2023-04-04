@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/1.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/2.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/3.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/4.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/5.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/6.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/7.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/8.jpg') }}" class="img-product">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/9.jpg') }}" class="img-product">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection

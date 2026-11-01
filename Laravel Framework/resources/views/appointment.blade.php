@extends('layout.app') 


@section('title')
<title>Appointment</title>


@endsection


@section('content')


<!-- Page Header End -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">appointment</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Appointment</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
        <!-- Appointment Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded">
                    <div class="row g-0">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="h-100 d-flex flex-column justify-content-center p-5">
                                <h1 class="mb-4">Make Appointment</h1>
                                @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                                <form action="{{ route('appointment.store') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="name" id="name" placeholder="Gurdian Name">
                                                <label for="name">Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control border-0" name="email" id="email" placeholder="Gurdian Email">
                                                <label for="email"> Email</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control border-0" name="number" id="number" placeholder="Gurdian Email">
                                                <label for="number"> Mobile Number</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="mname" id="mname" placeholder="Child Name">
                                                <label for="mname">Monther Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="fname" id="fname" placeholder="Child Name">
                                                <label for="fname">Father Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="cage" id="cage" placeholder="Child Age">
                                                <label for="cage">Child Age</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control border-0" placeholder="Leave a message here" name='message' id="message" style="height: 100px"></textarea>
                                                <label for="message">Message</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                            <div class="position-relative h-100">
                                <img class="position-absolute w-100 h-100 rounded" src="{{ asset('website/img/appointment.jpg')}}" style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Appointment End -->
 @endsection
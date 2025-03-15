{{-- @include('layouts.bookapp.admin_template') --}}
@extends('layouts.bookapp.admin_template')
@section('main')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

    <!-- <div class="widgets-scrollspy-nav mt-n5 bg-body-emphasis z-5 mx-n4 mx-lg-n6 border-bottom">
                        <nav class="simplebar-scrollspy navbar py-0 scrollbar-overlay" id="widgets-scrollspy">
                            <ul class="nav flex-nowrap">
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyStats">Number Stats and Charts</a></li>
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyTables">Tables, Files, and Lists</a></li>
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyEcommerce">E-commerce</a></li>
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyUsers">Users & Feed</a></li>
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyForms">Forms</a></li>
                                <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap"
                                        href="#scrollspyOthers">Others</a></li>
                            </ul>
                        </nav>
                    </div> -->
    <div class="mb-9" data-bs-spy="scroll" data-bs-target="#widgets-scrollspy">

        <div class="d-flex mb-4" id="scrollspyOthers"><span class="fa-stack me-2 ms-n1"><i
                    class="fas fa-circle fa-stack-2x text-primary"></i><i
                    class="fa-inverse fa-stack-1x text-primary-subtle fas fa-calendar-plus"
                    data-fa-transform="shrink-2"></i></span>
            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold"><span class="bg-body pe-2"></span><span
                        class="border border-primary position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span>
                </h3>
                {{-- <p class="mb-0">Get more awesome cards for showing your different types of content..</p> --}}
            </div>
        </div>
        {{-- <div class="row g-3 mb-3">
        </div> --}}
        <div class="row g-3">
            {{-- Team and Destination selection --}}
            {{-- // 1st column --}}
            <div class="col-xl-3">
                <div class="row gy-3 h-100">
                    <div class="col-12">
                        <div class="card mb-3 h-100">
                            <div class="card-body">
                                <h3 class="mb-4">Select a Team</h3>
                                <ul class="list-group mb-5" id="myTab" role="tablist">
                                    @foreach ($teams as $team)
                                        <li class="list-group-item list-group-item-action team-list"
                                            data-team-id="{{ $team->id }}" href="#!">{{ $team->title }}</li>
                                    @endforeach
                                </ul>
                                <h3 class="mb-4">Select a Destination</h3>
                                <ul class="list-group">
                                    @foreach ($destinations as $destination)
                                        <li class="list-group-item list-group-item-action destination-list"
                                            data-destination-id="{{ $destination->id }}">
                                            {{ $destination->title }}
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="team_id" id="bookapp_team_id">
                                <input type="hidden" name="destination_id" id="bookapp_destination_id">
                                {{-- <button type="submit" class="btn btn-primary mt-3">Book Appointment</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- // Calendar --}}
            <div class="col-xl-6">
                <div class="row gy-3 h-100">
                    <div class="col-12">
                        <div class="card mb-3 h-100">
                            <div class="card-body d-flex flex-column justify-content-between pb-3">
                                {{-- <div class="row align-items-center g-5 mb-3 text-center text-sm-start">
                                <div class="col-12 col-sm-auto mb-sm-2">
                                    <div class="avatar avatar-5xl"><img class="rounded-circle"
                                            src="assets/img/team/15.webp" alt="" /></div>
                                </div>
                                <div class="col-12 col-sm-auto flex-1">
                                    <h3>Ansolo Lazinatov</h3>
                                    <p class="text-body-secondary">Joined 3 months ago</p>
                                    <div><a class="me-2" href="#!"><span
                                                class="fab fa-linkedin-in text-body-quaternary text-opacity-75 text-primary-hover"></span></a><a
                                            class="me-2" href="#!"><span
                                                class="fab fa-facebook text-body-quaternary text-opacity-75 text-primary-hover"></span></a><a
                                            href="#!"><span
                                                class="fab fa-twitter text-body-quaternary text-opacity-75 text-primary-hover"></span></a>
                                    </div>
                                </div> 
                            </div> --}}
                                <div class="modal-body text-center mb-3">
                                    <div id="calendar"></div>
                                    <div class="spinner-border text-primary" id="loading" style="display:none;"></div>
                                </div>
                                <div class="d-flex flex-between-center border-top border-dashed pt-4">
                                    <div>
                                        <h6>Available</h6>
                                        <p class="fs-7 text-body-secondary mb-0">297</p>
                                    </div>
                                    <div>
                                        <h6>Booked</h6>
                                        <p class="fs-7 text-body-secondary mb-0">56</p>
                                    </div>
                                    <div>
                                        <h6>Completed</h6>
                                        <p class="fs-7 text-body-secondary mb-0">97</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- // 3rd column --}}
            <div class="col-xl-3">
                <div class="row gy-3 h-100">
                    <div class="col-12">
                        <div class="card mb-3 h-100">
                            <div class="card-body">
                                <div id="div3_title">
                                    <h3 class="mb-4" id="div3_title">Select a date to see available times</h3>
                                </div>
                                <form id="bookapp_form" action="" method="post" class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="team_id" id="bookapp_team_id">
                                    <input type="hidden" name="destination_id" id="bookapp_destination_id">
                                    <input type="hidden" name="date" id="bookapp_date">

                                    <div id="show_schedule_times"></div>

                                    {{-- <button type="submit" class="btn btn-primary mt-3">Book Appointment</button> --}}
                                    <button type="submit" class="btn btn-primary mt-3" id="submit_booking" disabled>Book Appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @push('css')
    <link rel="stylesheet" href="{{ asset('css/bookapp/index.css') }}"> --}}
@push('script')
    <script src="{{ asset('assets/js/pages/bookapp/index.js') }}"></script>
@endpush

@extends('mds.admin.layout.admin_template')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<!-- <div class="content"> -->
    <!-- <div class="container-fluid"> -->
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('bookings', 'Bookings') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{route('mds.admin.booking.create')}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_vehicle_type', 'Create Vehicle Type') ?>"><i class="bx bx-plus"></i></button></a>
            </div>
        </div>
        <div class="col-12 col-sm-auto">
                <div class="btn-group position-static" role="group">
                    <div class="py-0 me-2">
                        <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                            id="mds_schedule_event_filter">
                            <option value="" selected>Filter by Event .... </option>
                            @foreach ($events as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="py-0 me-2">
                        <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                            id="mds_schedule_venue_filter">
                            <option value="" selected>Filter by Venue .... </option>
                            @foreach ($venues as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="py-0 me-2">
                        <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                            id="mds_schedule_rsp_filter">
                            <option value="" selected>Filter by RSP .... </option>
                            @foreach ($rsps as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div> -->

                    <!-- <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters</button> -->
                </div>
            </div>
        <x-mds.admin.booking-card :bookings="$bookings" />
    <!-- </div> -->

    @include('mds.admin.partials.booking_modals')

    <script src="{{asset('assets/js/pages/mds/booking.js')}}"></script>
    @endsection

    @push('script')


    @endpush

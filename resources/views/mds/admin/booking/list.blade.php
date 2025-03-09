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
        <x-mds.admin.booking-card :bookings="$bookings" />
    <!-- </div> -->

    @include('mds.admin.partials.booking_modals')

    <script src="{{asset('assets/js/pages/mds/booking.js')}}"></script>
    @endsection

    @push('script')


    @endpush

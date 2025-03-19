@extends('layouts.tms.admin_template')
@section('main')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    {{-- <div class="content"> --}}
    {{-- <div class="container-fluid"> --}}
    <div class="d-flex justify-content-between m-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= get_label('schedules', 'schedules') ?>
                    </li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="javascript:void(0)" data-table="schedule_table" id="offcanvas-add-booking-slot" data-id="0">
                <button type="button" class="btn btn-primary px-5" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="Create new booking slot">
                    <i class="fa-solid fa-plus me-2"></i>New Booking Schedule
                </button>
            </a>
        </div>
    </div>
    <div class="col col-md-auto">
        <nav class="nav nav-underline justify-content-start doc-tab-nav align-items-center" role="tablist">
            <!-- <button class="btn btn-primary me-4" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop" aria-haspopup="true" aria-expanded="false"
                                                    data-bs-reference="parent"><span class="fas fa-plus me-2"></span>Add
                                                    Deal</button> -->
            <a class="btn btn-sm btn-phoenix-warning preview-btn ms-2"
                href="{{ route('tms.setting.schedule.import') }}"><span class="fa-solid fa-add"></span>Import</a>

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
                    <div class="py-0 me-2">
                        <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                            id="mds_schedule_rsp_filter">
                            <option value="" selected>Filter by RSP .... </option>
                            @foreach ($rsps as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters</button> -->
                </div>
            </div>
        </nav>
    </div>

    @include('modals.tms.schedule_modals')
    
    <x-setting.schedule-card :schedules="$schedules" />

    

    <script src="{{ asset('assets/js/pages/tms/schedule.js') }}"></script>
@endsection

@push('script')
@endpush

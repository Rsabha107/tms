@extends('mds.admin.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('schedules', 'schedules') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_schedules_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_vehicle_type', 'Create Vehicle Type') ?>"><i class="bx bx-plus"></i></button></a>
            </div>
        </div>
        <x-setting.schedule-card :schedules="$schedules" />
    </div>

    @include('mds.admin.partials.schedule_modals')
    
    <script>
        var label_update = '<?= get_label('update', 'Update') ?>';
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
        var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
        var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
        var label_intervals = '<?= get_label('intervals', 'Intervals') ?>';
    </script>
    <script src="{{asset('assets/js/pages/mds/schedule.js')}}"></script>
    @endsection

    @push('script')


    @endpush

@extends('mds.layout.dashboard')
@section('main')


<!-- ***************************************************************************** */ -->
<div class="content">

    <!-- <div class="pb-9"> -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('mds.setting.schedule')}}"><?= get_label('schedule', 'Schedules') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Intervals
            </li>
        </ol>
    </nav>


    <div class="col-xl-12 col-xxl-12">

        <div class="card">
            <div class="card-body">
                <!-- <div class="tab-content" id="myTabContent"> -->
                <!-- <div class="tab-pane fade active show" id="tab-project" role="tabpanel" aria-labelledby="project-tab"> -->
                <div class="pb-9">
                    <div class="row align-items-center justify-content-between g-3 mb-2">
                        <div class="col-12 col-md-auto">
                            <h3 class="mb-0">{{$schedule->venue->title}} ({{$schedule->venue->short_name}})</h3>


                        </div>
                        <div class="col-12 col-md-auto d-flex">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_intervalss_modal"><button class="btn btn-phoenix-primary px-3 px-sm-5 me-2"><span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Add </span></button></a>
                            <button class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Edit </span></button>
                            <button class="btn btn-phoenix-danger me-2"><span class="fa-solid fa-trash me-2"></span><span>Delete</span></button>
                            <div>
                                <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-ellipsis"></span></button>
                                <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                                    <li><a class="dropdown-item" href="#!">View profile</a></li>
                                    <li><a class="dropdown-item" href="#!">Report</a></li>
                                    <li><a class="dropdown-item" href="#!">Manage notifications</a></li>
                                    <li><a class="dropdown-item text-danger" href="#!">Delete Lead</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <span class="mb-3"><h4 class="mb-0">{{format_date($schedule->regime_start_date)}} to {{format_date($schedule->regime_end_date)}}</h4></span>
                    <span class="mb-3"><h4 class="mb-0">{{$schedule->rsp->title}} Timeslots: {{$schedule->time_slots}}</h4></span>

                    <!-- <div class="col-xl-7 col-xxl-12 mt-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="card-text text-body-secondary mb-4">{{$schedule->regime_start_date}}</p>
                            </div>
                        </div>
                    </div> -->

                    <div class="mb-0 mt-4">
                        <x-interval-card :intervals="$intervals" :schedule="$schedule"/>
                    </div>
                </div>
            </div>


            <div class="row g-4 g-xl-0 mt-3">
            </div>
            <!-- </div> -->
            <!-- </div> -->
        </div>
        <!-- </div> -->
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->
        <!-- modal land -->


        <!-- this is the Add Attachement Modal for events -->


        <!-- Modal to show the overview of the task and notes and attachment with tasks and  -->
        <script>
        var label_update = '<?= get_label('update', 'Update') ?>';
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
        var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
        var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
        var label_intervals = '<?= get_label('intervals', 'Intervals') ?>';
    </script>
    <script src="{{asset('assets/js/pages/interval.js')}}"></script>

        @endsection

        @push('script')


        @include('mds.partials.event-js')

        @endpush

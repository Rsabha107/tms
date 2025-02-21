@extends('main.layout.dashboard')
@section('main')


<!-- ***************************************************************************** */ -->
<div class="content">

    <div class="container pb-1 mt-3">

        <div class="row align-items-center justify-content-between g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">{{ucfirst(Session::get('record_type'))}} Details</h2>
            </div>
            <div class="col-12 col-md-auto d-flex">
                @if (Session::get('record_type') == 'event')
                @if (Auth::user()->can('task.edit'))
                <a href="{{ route('main.event.show.edit', $eventData->id) }}" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Edit this event </span></a>
                @endif

                <a class="btn btn-phoenix-primary me-2 px-6" href="{{ route('main.event.show.card') }}">Go back to events</a>
                @else
                @if (Auth::user()->can('task.edit'))
                <a href="{{ route('main.project.edit', $eventData->id) }}" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Edit this project </span></a>
                @endif
                <a class="btn btn-phoenix-primary me-2 px-6" href="{{ route('main.project.show.card') }}">Go back to projects</a>
                @endif
                <div>
                    <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-ellipsis"></span></button>
                    <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                        <li><a href="{{ route('gantt') }}" target="_blank" class="dropdown-item">Gantt </a></li>
                        <li><a href="{{ route('main.task.pdf', $eventData->id) }}" target="_blank" class="dropdown-item">PDF </a></li>
                        <li><a class="dropdown-item" href="#!">Report</a></li>
                        <!-- <li><a class="dropdown-item text-danger" href="#!">Delete this event</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        @if ($eventData->event_status == config('tracki.project_status.completed'))
        @php
        $badge = 'badge-phoenix-success';
        $badge_name = 'Completed';
        @endphp
        @else
        @php
        $badge = 'badge-phoenix-warning';
        $badge_name = 'In-progress';
        @endphp
        @endif
        @if ($FundCategory == 'Budgeted')
        @php
        $fund_badge = 'badge-phoenix-success';
        @endphp
        @else
        @php
        $fund_badge = 'badge-phoenix-danger';
        @endphp
        @endif
        <div class="row g-3 mb-6">
            <div class="col-12 col-lg-8">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="border-bottom border-dashed border-300 pb-6">

                            <div class="row align-items-center g-3 g-sm-5 text-center text-sm-start">
                                <div class="col-12 col-sm-auto flex-1">
                                    <h3 class="fw-bolder mb-2 line-clamp-1">{{$eventData->name}}</h3>
                                    <h5 class="fw-bolder text-nowrap text-right mt-3 mb-3"><span class="badge badge-phoenix {{$badge}}">{{$badge_name}}</span>
                                        <span class="badge badge-phoenix {{$fund_badge}}">{{$FundCategory}}</span>
                                    </h5>
                                    <div class="col-12 col-lg-4">
                                    </div>
                                    <!-- <p class="text-800">Public / VIC / Mark Spencer</p> -->
                                    <div class="col-sm-auto">
                                        <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                            <div class="d-flex bg-info-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-info-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                            <div>
                                                <h4 class="fw-bolder text-nowrap">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-warning-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                            <div>
                                                <h4 class="fw-bolder text-nowrap">{{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div><a class="me-2" href="#!"><span class="fab fa-linkedin-in text-400 hover-primary"></span></a><a class="me-2" href="#!"><span class="fab fa-facebook text-400 hover-primary"></span></a><a href="#!"><span class="fab fa-twitter text-400 hover-primary"></span></a></div> -->
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->can('task.funds.show'))
                        <div class="px-6 mb-0 pt-3">
                            <div class="row justify-content-between">
                                <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-md border-top-md border-top-xxl border-end-xxl border-bottom border-bottom-md  pb-4 pb-xxl-0">
                                    <div>
                                        <p class="fs-9 text-body-tertiary mb-1">Budget</p>
                                        <h4 class="mb-3">{{number_format($eventData->budget_allocation)}}</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-md border-top-md border-top-xxl border-end-xxl border-bottom border-bottom-md pb-4 pb-xxl-0">
                                    <div>
                                        <p class="fs-9 text-body-tertiary mb-1">Spent</p>
                                        <h4 class="mb-3">{{number_format($eventData->budget_allocation - $remainingBudget)}}</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-md border-top-md border-top-xxl border-end-xxl border-bottom border-bottom-md pb-4 pb-xxl-0 pt-4 pt-md-0">
                                    <div>
                                        <p class="fs-9 text-body-tertiary mb-1">Sales</p>
                                        <h4 class="mb-3">{{number_format($eventData->total_sales)}}</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-md border-top-md border-top-xxl border-end-xxl border-bottom border-bottom-md pb-4 pb-xxl-0 pt-4 pt-xxl-0">
                                    <div>
                                        <p class="fs-9 text-body-tertiary mb-1">Attendance</p>
                                        <h4 class="mb-3">{{number_format($eventData->attendance_forcast)}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="border-bottom border-dashed border-300 pb-4">
                            <div class="row align-items-center g-3 g-sm-5 text-center text-sm-start">
                                <div class="col-12 col-sm-auto flex-1">
                                    <h3 class="fw-bolder mb-2 line-clamp-1">{{$eventData->name}}</h3>
                                    <h5 class="fw-bolder text-nowrap text-right mt-3 mb-3"><span class="badge badge-phoenix {{$badge}}">{{$badge_name}}</span></h5>

                                    <div class="col-sm-auto">
                                        <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                            <div class="d-flex bg-info-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-info-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                            <div>
                                                <h4 class="fw-bolder text-nowrap">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-warning-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                            <div>
                                                <h4 class="fw-bolder text-nowrap">{{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-between-center pt-4">
                            @if (Auth::user()->can('task.funds.show'))
                            <div>
                                <h6 class="fw-bold mb-1">Budget</h6>
                                <h4 class="fw-bolder text-nowrap">{{$eventData->budget_allocation}}</h4>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold mb-1">Total Spent</h6>
                                <h4 class="fw-bolder text-nowrap"> {{$eventData->budget_allocation - $remainingBudget }}</h4>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold mb-1">Total Sales</h6>
                                <h4 class="fw-bolder text-nowrap"> {{$eventData->total_sales }}</h4>
                            </div>
                            @else
                            <div>
                                <h6 class="fw-bold mb-1">Budget</h6>
                                <h4 class="fw-bolder text-nowrap">XXXX</h4>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold mb-1">Total Spent</h6>
                                <h4 class="fw-bolder text-nowrap">XXXX</h4>
                            </div>
                            @endif
                            <div class="text-end">
                                <h6 class="fw-bold mb-1">Expected Attendance</h6>
                                <h4 class="fw-bolder text-nowrap">{{$eventData->attendance_forcast}} </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-success-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="share-2" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$projectType}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-info-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="eye" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$eventCategoryName}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-info-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="award" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$audienceName}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-warning-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="smile" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$plannerName}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-primary-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="globe" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$venueName}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-white-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="compass" style="width:24px; height:24px"></span></div>
                                <div>
                                    <h4 class="fw-bolder text-nowrap">{{$locationName}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xxl-12 border-bottom border-bottom-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <table class="w-100 table-stats">
                            <tr span=2>
                                <!-- <td class="py-2 d-none d-sm-block pe-sm-2">:</td> -->
                                <td class="py-2">
                                    <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0">
                                        <h4>{{$eventData->description}}</h4>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>




    <!-- <div class="pb-9"> -->

    <div class="row g-4 g-xl-0">
        <!-- <div class="col-xl-5 col-xxl-4">
                <div class="sticky-leads-sidebar">


                </div>
            </div> -->
        <div class="col-xl-12 col-xxl-12">
            <ul class="nav nav-underline deal-details scrollbar flex-nowrap w-100 pb-1 mb-6 mx-3" id="myTab" role="tablist" style="overflow-y: hidden;">
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link active" id="activity-tab" data-bs-toggle="tab" href="#tab-activity" role="tab" aria-controls="tab-activity" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Activity</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#tab-notes" role="tab" aria-controls="tab-notes" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#tab-attachments" role="tab" aria-controls="tab-attachments" aria-selected="true"> <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments</a>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attendees-tab" data-bs-toggle="tab" href="#tab-attendees" role="tab" aria-controls="tab-attendees" aria-selected="true"> <span class="fas fa-person-booth me-2 tab-icon-color"></span>Attendance</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="tab-activity" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="card">
                        <div class="mb-9">
                            <div id="orderTable" data-list='{"valueNames":["name","start_date","due_date","department","assigned_to","status","description"]}'>
                                <div class="mb-4">
                                    <div class="row g-1 mx-2">
                                        <div class="col-auto px-2 pt-4">
                                            @if (Auth::user()->can('task.funds.show'))
                                            <div>
                                                <h5 class="text-dark"><span class="fas fa-file-invoice-dollar me-2"></span>Remaining budget: {{ $remainingBudget }}</h5>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-auto scrollbar overflow-hidden-y flex-grow-1">
                                        </div>
                                        @if (Auth::user()->can('task.create'))
                                        <div class="col-auto pt-3">
                                            <!-- <button class="btn btn-link text-900 me-4 px-0"><span
                                    class="fa-solid fa-file-export fs--1 me-2"></span>Export</button> -->
                                            <a href="{{ route('main.task.add', $eventData->id) }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2">
                                                <span class="fas fa-plus me-2"></span>Add tasks</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 position-relative top-1">
                                    <div class="table-responsive ms-n1 px-2 scrollbar">
                                        <table class="table fs-8 mb-0 border-top border-translucent">
                                            <thead>
                                                <tr>
                                                    <th class="sort align-middle text-end" scope="col" style="width:1%;"></th>
                                                    <th class="sort white-space-nowrap align-middle ps-2" scope="col" data-sort="name" style="width:10%;">NAME</th>
                                                    <th class="sort white-space-nowrap align-middle ps-5" scope="col" data-sort="department" style="width:15%;">DEPARTMENT</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNED BY</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNED TO</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:10%;">DEADLINE</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:10%;">EXPENSE</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:1%;">PROGRESS</th>
                                                    <th class="sort align-middle text-center" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                                                    <th class="sort align-middle text-start ps-4" scope="col" data-sort="description" style="width:52%; max-width: 100px;">Description</th>
                                                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="order-table-body">
                                                @foreach ($taskData as $key => $item )
                                                @php
                                                $assigntonames = App\Http\Controllers\UtilController::getAssignedToName($item->assignment_to_id);
                                                $taskNoteExists = App\Http\Controllers\UtilController::taskNotesExists($item->id);
                                                $taskFileExists = App\Http\Controllers\UtilController::taskFilesExists($item->id);
                                                $asg_to_names = '';
                                                foreach($assigntonames as $key1 => $item1){
                                                $asg_to_names = $asg_to_names.', '. $item1->assigned_to_name;
                                                }
                                                $asg_to_names = ltrim($asg_to_names, ',');
                                                @endphp
                                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0">
                                                        <a href="#!">
                                                            @if ($taskFileExists)
                                                                <span class="fas fa-paperclip me-1">
                                                            @endif
                                                            @if ($taskNoteExists)
                                                                </span><span class="fas fa-file-alt me-1"></span>
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0"><a href="javascript:void(0)" id="taskCardView" data-id="{{$item->id}}" data-assignees="{{ $asg_to_names }}"> {{$item->name}}</a>
                                                    </td>
                                                    <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0 ms-5">{{$item->department_name}}</a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-2"><a class="d-flex align-items-center text-900" href="#!">
                                                            <!-- <div class="avatar avatar-m">
                                                                <div class="avatar-name rounded-circle"><span>{{substr($item->person_name, 0, 1)}}</span></div>
                                                            </div> -->
                                                            <p class="mb-0 ms-3 text-900"> {{$item->person_name}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-wrap ps-2"><a class="d-flex align-items-center text-900" href="#!">
                                                            <!-- <div class="avatar avatar-m">
                                                                <div class="avatar-name rounded-circle"><span>{{substr($asg_to_names, 1, 1)}}</span></div>
                                                            </div> -->
                                                            <p class="mb-0 ms-3 text-900"> {{$asg_to_names}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-1">
                                                        <p class="mb-0 ms-3 fs--1 text-900"> {{\Carbon\Carbon::parse($item->start_date)->format('d-M-Y')}}</p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-0 text-900"> {{\Carbon\Carbon::parse($item->due_date)->format('d-M-Y')}} </p>
                                                        </a>
                                                    </td>
                                                    @if (Auth::user()->can('project.funds.show'))
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900"> {{$item->actual_budget_allocated}}</p>
                                                        </a>
                                                    </td>
                                                    @else
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900"> XXXX</p>
                                                        </a>
                                                    </td>
                                                    @endif
                                                    <td class="align-middle white-space-nowrap ps-3 projectprogress">
                                                        <p class="text-800 fs--2 mb-0">{{$item->progress*100}}%</p>
                                                        <div class="progress" style="height:3px;">
                                                            <div class="progress-bar bg-success" style="width: {{$item->progress*100}}%" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$item->progress*100}}%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </td>
                                                    @if ($item->status_name === 'Completed')
                                                    @php
                                                    $badge_color = 'badge-phoenix-success'
                                                    @endphp
                                                    @else
                                                    @php
                                                    $badge_color = 'badge-phoenix-secondary'
                                                    @endphp
                                                    @endif
                                                    @php
                                                    $taskDateDiff = App\Http\Controllers\UtilController::getDateDiff($item->start_date, $item->due_date);
                                                    if (($item->status_name != 'Completed') && ($taskDateDiff <= 3)){ $badge_color='badge-phoenix-danger' ; } @endphp <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-700">
                                                        <span class="badge badge-phoenix fs--2 {{$badge_color}} ms-5"><span class="badge-label">{{$item->status_name}}</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>
                                                        </td>

                                                        <td class="align-middle white-space-wrap text-700 fs--1 ps-4 text-start">
                                                            <p class="longname">{{ $item->description }}</p>
                                                        </td>
                                                        <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                                            <div class="font-sans-serif btn-reveal-trigger position-static">
                                                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>

                                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                                    @if (Auth::user()->can('task.edit'))
                                                                    <a class="dropdown-item" href="{{ route('main.task.edit',$item->id) }}">Edit</a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#progressModal" id="editTaskProgress" data-id="{{ $item->id }}" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Progress</a>
                                                                    <a href="#!" id="addTaskNote" data-id="{{ $item->id }}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addTaskNoteModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Add a note</a>
                                                                    <a href="#!" id="addTaskAttch" data-id="{{ $item->id }}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addAttachementTaskModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Upload a file</a>
                                                                    @if (Auth::user()->can('task.delete'))
                                                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="{{ route('main.task.delete',$item->id)}}" id="delete">Remove</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                                        <div class="col-auto d-flex">
                                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                        </div>
                                        <!-- <div class="col-auto d-flex">
                            <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                          </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-notes" role="tabpanel" aria-labelledby="notes-tab">
                    <div class="row align-items-center justify-content-between g-3 mb-4">
                        <div class="col-12 col-md-auto">
                            <h2 class="fw-bolder mb-0">Notes</h2>
                        </div>
                        <div class="col-12 col-md-auto d-flex">
                            @if (Auth::user()->can('project.note.create'))
                            <a href="#!" class="btn btn-phoenix-primary px-3 px-sm-5 me-2" data-bs-toggle="modal" data-bs-target="#addEventNoteModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-plus me-sm-2"></span><span class="d-none d-sm-inline">Add a new note</span></a>
                            @endif
                            <div>
                                <!-- <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-ellipsis"></span></button> -->
                                <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                                    <li><a href="{{ route('gantt') }}" target="_blank" class="dropdown-item">Gantt </a></li>
                                    <li><a class="dropdown-item" href="#!">View profile</a></li>
                                    <li><a class="dropdown-item" href="#!">Report</a></li>
                                    <li><a class="dropdown-item" href="#!">Manage notifications</a></li>
                                    <!-- <li><a class="dropdown-item text-danger" href="#!">Delete this event</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- <textarea class="form-control mb-3" id="notes" rows="4"> </textarea> -->
                    <div class="row gy-4">
                        <div class="col-12 col-xl-auto flex-1">
                            @foreach ($eventNote as $key => $item )
                            <div class="border-top border-dashed border-300 pt-3 pb-4">
                                <div class="d-flex flex-between-center">
                                    <div class="d-flex mb-1"><span class="fa-solid fa-file-lines me-2 text-700 fs--1"></span>
                                        <p class="text-1000 mb-0 lh-1">{{$item->event_note_text}}</p>
                                    </div>
                                    @if (Auth::user()->can('project.note.delete'))
                                    <div class="font-sans-serif btn-reveal-trigger">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <!-- <a class="dropdown-item" href="#!">Edit</a> -->
                                            <a class="dropdown-item text-danger" href="{{ route('main.event.delete.note',$item->event_note_id)}}" id="delete">Delete</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <p class="fs--1 text-700 mb-2"><span class="text-400 mx-1">| </span><a href="#!">{{ $item->event_note_user_name }} </a><span class="text-400 mx-1">| </span><span class="text-nowrap">{{ $item->event_note_file_created_at }}</span>
                                    <!-- </p><img class="rounded-2" src="{{ asset ('assets/img/generic/40.png') }}" alt="" /> -->
                            </div>

                            <!-- <div class="border-2 border-dashed mb-4 pb-4 border-bottom">
                                    <p class="mb-1 text-1000">{{ $item->event_note_text}}</p>
                                    <div class="d-flex">
                                        <div class="fs--1 text-600"><span class="fa-solid fa-clock me-2"></span><span class="fw-semi-bold me-1">{{ $item->event_note_file_created_at }}</span></div>
                                        <p class="fs--1 mb-0 text-600">by<a class="ms-1 fw-semi-bold" href="#!">{{ $item->event_note_user_name}}</a></p>
                                    </div>
                                </div> -->
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-attachments" role="tabpanel" aria-labelledby="attachments-tab">
                    <div class="row align-items-center justify-content-between g-3 mb-4">
                        <div class="col-12 col-md-auto">
                            <h2 class="fw-bolder mb-0">Attachments</h2>
                        </div>
                        <div class="col-12 col-md-auto d-flex">
                            @if (Auth::user()->can('project.file.create'))
                            <a href="#!" data-id="{{ $eventData->id }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2" data-bs-toggle="modal" data-bs-target="#addAttachementModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-file-upload me-sm-2"></span><span class="d-none d-sm-inline">Upload a new file</span></a>
                            @endif
                            <!-- <div>
                                <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-ellipsis"></span></button>
                                <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                                    <li><a href="{{ route('gantt') }}" target="_blank" class="dropdown-item">Gantt </a></li>
                                    <li><a class="dropdown-item" href="#!">View profile</a></li>
                                    <li><a class="dropdown-item" href="#!">Report</a></li>
                                    <li><a class="dropdown-item" href="#!">Manage notifications</a></li>
                                    <li><a class="dropdown-item text-danger" href="#!">Delete this event</a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h2 class="mb-4">Attachments</h2> -->

                    @foreach ($fileName as $key => $item )
                    <div class="border-top border-dashed border-300 pt-3 pb-4">
                        <div class="d-flex flex-between-center">
                            <div class="d-flex mb-1"><span class="fa-solid fa-file-lines me-2 text-700 fs--1"></span>
                                <p class="text-1000 mb-0 lh-1"><a href="../../../upload/event_files/{{ $item->file_name }}" target="_blank">{{$item->original_file_name}}</a></p>
                            </div>
                            @if (Auth::user()->can('project.file.delete'))
                            <div class="font-sans-serif btn-reveal-trigger">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <!-- <a class="dropdown-item" href="#!">Edit</a> -->
                                    <a class="dropdown-item text-danger" href="{{ route('main.event.file.delete', $item->event_file_id) }}" id="delete">Delete</a>
                                    <!-- <a class="dropdown-item" href="#!">Download</a> -->
                                    <!-- <a class="dropdown-item" href="#!">Report abuse</a> -->
                                </div>
                            </div>
                            @endif
                        </div>
                        <p class="fs--1 text-700 mb-2"><span>{{$item->file_size/100}}kB</span><span class="text-400 mx-1">| </span><a href="#!">{{ $item->file_user_name }} </a><span class="text-400 mx-1">| </span><span class="text-nowrap">{{ $item->file_created_at }}</span></p>
                    </div>
                    @endforeach
                </div>

                <div class="tab-pane fade" id="tab-attendees" role="tabpanel" aria-labelledby="attendees-tab">
                    <div class="card">
                        <div class="mb-9">
                            <div id="orderTable" data-list='{"valueNames":["name","start_date","due_date","department","assigned_to","status","description"]}'>
                                @if (Auth::user()->can('project.attendance.assign'))
                                <div class="mb-4">
                                    <div class="row g-1 mx-2">
                                        <div class="col-auto px-2 pt-4">
                                            <div>
                                                <a href="{{ route('main.event.attendance.assignment', $eventData->id) }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2">
                                                    <span class="fas fa-plus me-2"></span>Add Attendees</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-top border-bottom border-translucent position-relative top-1">
                                    <div class="table-responsive scrollbar mx-n1 px-1">
                                        <table class="table fs--1 mb-0 border-top border-200" id="dataList">
                                            <thead>
                                                <tr>

                                                    <!-- <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="name" style="width:10%;">NAME</th> -->
                                                    <th class="sort align-middle ps-5" scope="col" data-sort="department" style="width:15%;">Name</th>
                                                    <!-- <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">Last name</th> -->
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">Email</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Phone</th>
                                                    <!-- <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:12%;">TASK</th> -->
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:1%;">Type</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:1%;">Attended</th>
                                                    <!-- <th class="sort align-middle text-center" scope="col" data-sort="statuses" style="width:10%;">STATUS</th> -->
                                                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                                                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>

                                                </tr>
                                            </thead>
                                            <tbody class="list" id="order-table-body">
                                                @foreach ($attendeez as $key => $item )

                                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                    <!-- <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0" href="#"> {{$item->name}}</a></td> -->
                                                    <!-- <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0 ms-5" href="#!">{{$item->first_name}}&nbsp;{{$item->last_name}}</a>
                                                        </td> -->
                                                    <td class="customer align-middle white-space-nowrap ps-2"><a class="d-flex align-items-center text-900" href="#!">
                                                            <div class="avatar avatar-m">
                                                                <div class="avatar-name rounded-circle"><span>{{substr($item->first_name, 0, 1)}}</span></div>
                                                            </div>
                                                            <p class="mb-0 ms-3 text-900 align-middle time white-space-nowrap fw-bold">{{$item->first_name}}&nbsp;{{$item->last_name}}</p>
                                                        </a></td>
                                                    <td class="customer align-middle white-space-nowrap ps-1">
                                                        <p class="mb-0 ms-3 fs--1 text-900"> {{$item->email_address}}</p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-0 text-900"> {{$item->phone_number}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900"> {{$item->name}}</p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900"> {{$item->guest_attended}}</p>
                                                        </a>
                                                    </td>
                                                    @php
                                                    $qr_code = App\Http\Controllers\UtilController::getQrCode($item->id);
                                                    @endphp
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900 zoom"> {{$qr_code}}</p>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                                        @if (Auth::user()->can('project.attendance.delete'))
                                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                                <a class="dropdown-item text-danger" href="{{ route('main.attendance.assignment.delete',$item->id, $item->event_id)}}" id="delete">Remove</a>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                                            <div class="col-auto d-flex">
                                                <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                            </div> -->
                                    <!-- <div class="col-auto d-flex">
                            <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                          </div> -->
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- this is the Add Attachement Modal for events -->
    <div class="modal fade" id="addAttachementModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Upload File</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form id="fileUploadForm" class="needs-validation" novalidate="" action="{{ route('main.event.file.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="addId" name="event_id" value="{{ $eventData->id }}">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <input class="form-control" type="file" name="file_name" id="fileupld" required />
                                    </div>
                                    <div class="form-group">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select class="form-select" name="active_flag" id="activeFlag" required>
                                            <option value="" >Select</option>
                                            <option value="1" selected>Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- this is the Add Attachement Modal for tasks -->
    <div class="modal fade" id="addAttachementTaskModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Upload Task File</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form id="taskFileUploadForm" class="needs-validation" novalidate="" action="{{ route('main.task.file.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="taskAttachId" name="task_id" value="">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <input class="form-control" type="file" name="file_name" id="fileupld" required />
                                    </div>
                                    <div class="form-group">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select class="form-select" name="active_flag" id="activeFlag" required>
                                            <option value="" >Select</option>
                                            <option value="1" selected>Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- this is the Add Event Notes Modal -->
    <div class="modal fade" id="addTaskNoteModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Add task note</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ route('main.task.note.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="taskNoteId" name="task_id" value="">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Note</label>
                                        <textarea class="form-control mb-3" id="notes" name="note_text" rows="4"> </textarea>

                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select class="form-select" name="active_flag" id="activeFlag" required>
                                            <option value="" >Select</option>
                                            <option value="1" selected>Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="progressModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Propgress %</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ route('main.task.progress.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="editId" name="id">
                                    <input type="hidden" id="editEventId" name="event_id">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <input class="form-control" type="number" max="100" min="0" name="prorgress_number" id="editPoregessNumber" required />
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select class="form-select" name="active_flag" id="activeFlag" required>
                                            <option value="" >Select</option>
                                            <option value="1" selected>Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- this is the Add Event Notes Modal -->
    <div class="modal fade" id="addEventNoteModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Add note</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ route('main.event.note.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="addId" name="event_id" value="{{ $eventData->id }}">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <textarea class="form-control mb-3" id="notes" name="note_text" rows="4"> </textarea>

                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select class="form-select" name="active_flag" id="activeFlag" required>
                                            <option value="" >Select</option>
                                            <option value="1" selected>Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal to show the overview of the task and notes and attachment with tasks and  -->

    <div class="modal fade" id="taskCardViewModal" tabindex="-1" aria-labelledby="taskCardViewModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content overflow-hidden">
                <div class="modal-header position-relative p-0">
                    <!-- <input class="d-none" id="projectCoverInput" type="file" /> -->
                    <!-- <label class="position-absolute top-0 start-0" for="projectCoverInput"><span class="project-modal-btn d-inline-block bg-body-emphasis rounded-2 py-2 px-3 fs-9 fw-bolder mt-3 ms-3 cursor-pointer"><span class="fa-solid fa-image me-1"></span>Change</span></label> -->
                    <button class="btn btn-circle project-modal-btn position-absolute end-0 top-0 mt-3 me-3 bg-body-emphasis" data-bs-dismiss="modal"><span class="fas fa-times fs-3 text-white"></span></button>
                    <img class="w-100" src="{{ asset ('assets/img/generic/43.png') }}" alt="" style="max-height: 50px;min-height: 20px;" />
                </div>
                <div class="modal-body p-5 px-md-6">
                    <div class="row g-5">
                        <div class="col-12 col-md-12">
                            <div class="row g-4 g-xl-6">

                                <div class="col-xl-5 col-xxl-12">
                                    <div class="card mb-1">
                                        <div class="card-body">
                                            <div class="row align-items-center g-3">
                                                <div class="col-12 col-sm-auto flex-1">
                                                    <h3 class="fw-bolder mb-2 line-clamp-1" id="overviewtaskTitle">Start-Up Growth Suite</h3>
                                                    <div class="d-md-flex d-xl-block align-items-center justify-content-between mb-5">
                                                        <div><span class="badge badge-phoenix badge-phoenix-success me-2">Active</span>
                                                        </div>
                                                        <div class="mt-3">
                                                            <h6 class="text-body-secondary mb-2" id="overviewtaskAssignees">Assignees</h6>
                                                        </div>
                                                    </div>
                                                    <div class="progress mb-2" style="height:5px">
                                                        <div class="progress-bar bg-primary-lighter" id="overviewtaskProgressStyle" data-bs-theme="light" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div><span class="d-inline-block lh-sm me-1" data-feather="clock" style="height:16px;width:16px;"></span><span class="d-inline-block lh-sm" id="overviewtaskStartDate"> Dec 15, 05:00AM</span></div>
                                                        <div><span class="d-inline-block lh-sm me-1" data-feather="clock" style="height:16px;width:16px;"></span><span class="d-inline-block lh-sm" id="overviewtaskEndDate"> Dec 15, 05:00AM</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <h4 class="me-3">Description</h4>
                                        @if (Auth::user()->can('task.edit'))
                                        <button class="btn btn-link p-0"><span class="fa-solid fa-pen"></span></button>
                                        @endif
                                    </div>
                                    <p class="text-body-highlight" id="overviewtaskDescription"> ...<a class="fw-semibold" href="#!">see more </a></p>
                                </div>
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="card mb-5">
                                        <div class="card-body">
                                            <div class="row g-4 g-xl-1 g-xxl-3 justify-content-between">
                                                <div class="col-sm-auto">
                                                    <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                                        <div class="d-flex bg-success-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-success-dark" data-feather="dollar-sign" style="width:24px; height:24px"></span></div>
                                                        <div>
                                                            <p class="fw-bold mb-1">Allocated Budget</p>
                                                            <h4 class="fw-bolder text-nowrap" id="overviewtaskAllocatedBudget">$12,000.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                                        <div class="d-flex bg-info-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-dark" data-feather="code" style="width:24px; height:24px"></span></div>
                                                        <div>
                                                            <p class="fw-bold mb-1">Actual Budget</p>
                                                            <h4 class="fw-bolder text-nowrap" id="overviewtaskActualBudget">PHO1234</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                                        <div class="d-flex bg-primary-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-primary-dark" data-feather="layout" style="width:24px; height:24px"></span></div>
                                                        <div>
                                                            <p class="fw-bold mb-1">Department</p>
                                                            <h4 class="fw-bolder text-nowrap" id="overviewtaskDepartment">New Business</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-underline fs-9 deal-details scrollbar flex-nowrap w-100 pb-1 mb-6" id="myTab" role="tablist" style="overflow-y: hidden;">
                                        <!-- <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link active" id="task-activity-tab" data-bs-toggle="tab" href="#task-tab-activity" role="tab" aria-controls="tab-activity" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Activity</a></li> -->
                                        <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link active" id="task-notes-tab" data-bs-toggle="tab" href="#task-tab-notes" role="tab" aria-controls="tab-notes" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes</a></li>
                                        <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="task-attachments-tab" data-bs-toggle="tab" href="#task-tab-attachments" role="tab" aria-controls="tab-attachments" aria-selected="true"> <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments</a></li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade  active show" id="task-tab-notes" role="tabpanel" aria-labelledby="notes-tab">
                                            <h2 class="mb-4">Notes</h2>
                                            <!-- <textarea class="form-control mb-3" id="notes" rows="4"> </textarea> -->
                                            <div class="row gy-4">
                                                <div class="col-12 col-xl-auto flex-1">
                                                    <div id="taskTabNotes"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="task-tab-attachments" role="tabpanel" aria-labelledby="attachments-tab">
                                            <div class="row align-items-center justify-content-between g-3 mb-4">
                                                <div class="col-12 col-md-auto">
                                                    <h2 class="mb-2">Attachments</h2>
                                                </div>
                                                <!-- <div class="col-12 col-md-auto d-flex mb-2">
                                                    <a href="#!" data-id="{{ $eventData->id }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2" data-bs-toggle="modal" data-bs-target="#addAttachementModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-file-upload me-sm-2"></span><span class="d-none d-sm-inline">Upload a new file</span></a>
                                                </div> -->
                                            </div>
                                            <div id="taskTabFiles"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('script')

    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // var id = $('#addId').val();
            $('#fileUploadForm').ajaxForm({
                beforeSend: function() {
                    var percentage = '0';
                    console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");

                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                complete: function(xhr) {
                    console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");
                    window.location.href = "{{ route('main.task.list',$eventData->id) }}";
                }
            });

            $('#taskFileUploadForm').ajaxForm({
                beforeSend: function() {
                    var percentage = '0';
                    console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");

                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                complete: function(xhr) {
                    console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");
                    window.location.href = "{{ route('main.task.list',$eventData->id) }}";
                }
            });

            $('#dataList').DataTable({
                "lengthChange": false,
                "paging": false,
                // "order": [
                //     [0, "asc"]
                // ],
                // dom: 'Bfrtip',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdf',
                //     // 'colvis'
                // ]
                // buttons: [{
                //     extend: 'collection',
                //     text: 'Export',
                //     buttons: [{
                //             extend: 'copyHtml5',
                //             exportOptions: {
                //                 columns: [0, ':visible']
                //             }
                //         },
                //         {
                //             extend: 'excelHtml5',
                //             exportOptions: {
                //                 columns: ':visible'
                //             }
                //         },
                //         {
                //             extend: 'csvHtml5',
                //             exportOptions: {
                //                 columns: ':visible'
                //             }
                //         },
                //         {
                //             extend: 'pdfHtml5',
                //             exportOptions: {
                //                 columns: [0, 1, 2, 5]
                //             }
                //         },
                //         'colvis'
                //     ],
                // }]
            });

        });
    </script>
    @include('main.partials.event-js')
    @endpush

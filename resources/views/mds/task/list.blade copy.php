@extends('main.layout.dashboard')
@section('main')


<!-- ***************************************************************************** */ -->
<div class="content">

    <!-- <div class="pb-9"> -->

    <div class="row g-4 g-xl-0 mt-3">
        <nav class="mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('main.project.show.card') }}">Projects</a></li>
                <li class="breadcrumb-item active"><a href="#!">{{$eventData->name}}</a></li>
            </ol>
        </nav>
        <div class="col-xl-12 col-xxl-12">
            <ul class="nav nav-underline deal-details scrollbar flex-nowrap w-100 pb-1 mb-6 mx-3" id="myTab" role="tablist" style="overflow-y: hidden;">
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link active" id="project-tab" data-bs-toggle="tab" href="#tab-project" role="tab" aria-controls="tab-project" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Project</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="activity-tab" data-bs-toggle="tab" href="#tab-activity" role="tab" aria-controls="tab-activity" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Activity</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#tab-notes" role="tab" aria-controls="tab-notes" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#tab-attachments" role="tab" aria-controls="tab-attachments" aria-selected="true"> <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments</a>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attendees-tab" data-bs-toggle="tab" href="#tab-attendees" role="tab" aria-controls="tab-attendees" aria-selected="true"> <span class="fas fa-person-booth me-2 tab-icon-color"></span>Attendance</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="tab-project" role="tabpanel" aria-labelledby="project-tab">
                    <div class="card">
                        <div class="mb-2">
                            <div class="container pb-1 mt-3">

                                <div class="row align-items-center justify-content-between g-3 mb-4">
                                    <div class="col-auto">
                                        <h2 class="mb-0">{{ucfirst(Session::get('record_type'))}} {{$eventData->name}}</h2>
                                    </div>
                                    <div class="col-12 col-md-auto d-flex">
                                        @if (Session::get('record_type') == 'event')
                                        @if (Auth::user()->can('task.edit'))
                                        <a href="{{ route('main.event.show.edit', $eventData->id) }}" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Edit this event </span></a>
                                        @endif

                                        <a class="btn btn-phoenix-primary me-2 px-6" href="{{ route('main.project.show.card') }}">Go back to events</a>
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
                                <div class="mb-3" id="collapseExample">
                                    <div class="border border-translucent p-3 rounded">{{$eventData->description}}</div>
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

                                @if ($event_progress < 100) @php $bg='bg-warning' ; @endphp @elseif ($event_progress*100>= 100)
                                    @php
                                    $bg = 'bg-success';
                                    @endphp
                                    @endif

                                    @if (Auth::user()->can('task.funds.show'))
                                    @php
                                    $visible='';
                                    @endphp
                                    @else
                                    @php
                                    $visible='placeholder';
                                    @endphp
                                    @endif


                                    <div class="row g-3 mb-6">
                                        <div class="col-12 col-lg-12">
                                            <div class="card h-90">
                                                <div class="card-body">
                                                    <div class="pb-3">
                                                        <div class="row align-items-center g-3 g-sm-5 text-center text-sm-start">
                                                            <div class="col-12 col-sm-auto flex-1">
                                                                <!-- <h3 class="fw-bolder mb-2 line-clamp-1">{{$eventData->name}}</h3> -->
                                                                <h5 class="fw-bolder text-nowrap text-right mt-3 mb-3"><span class="badge badge-phoenix {{$badge}}">{{$badge_name}}</span>
                                                                    <span class="badge badge-phoenix {{$fund_badge}}">{{$FundCategory}}</span>
                                                                </h5>
                                                                <div class="d-flex justify-content-between text-700 fw-semi-bold">
                                                                    <p class="mb-2"> Progress</p>
                                                                    <p class="mb-2 text-1100">{{$event_progress}}%</p>
                                                                </div>
                                                                <div class="progress bg-success-100">
                                                                    <div class="progress-bar rounded {{$bg}}" role="progressbar" aria-label="Success example" style="width: {{$event_progress}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                @if (Auth::user()->can('task.funds.show'))
                                                                <div class="px-xl-4 mb-0">
                                                                    <div class="row mx-0 mx-sm-3 pt-4 mx-lg-0 px-lg-0">
                                                                        <div class="col-sm-12 col-xxl-6 border-bottom border-end-xxl border-translucent py-3">
                                                                            <table class="w-100 table-stats table-stats">
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-success-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Start Date</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-danger-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-danger-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">End Date</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">{{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-info-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-info-dark" data-feather="trending-up" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Sales</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0">{{number_format($eventData->total_sales)}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-sm-12 col-xxl-6 border-bottom border-translucent py-3">
                                                                            <table class="w-100 table-stats">
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-primary-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-primary-dark" data-feather="dollar-sign" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Budget</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">{{number_format($eventData->budget_allocation)}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-warning-dark" data-feather="archive" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Spent</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0 text-body">{{number_format($eventData->budget_allocation - $remainingBudget)}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-success-dark" data-feather="triangle" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Remaining</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0 ">{{ number_format($remainingBudget) }}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="px-xl-4 mb-0">
                                                                    <div class="row mx-0 mx-sm-3 pt-4 mx-lg-0 px-lg-0">
                                                                        <div class="col-sm-12 col-xxl-6 border-bottom border-end-xxl border-translucent py-3">
                                                                            <table class="w-100 table-stats table-stats">
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-success-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">Start Date</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-sm-12 col-xxl-6 border-bottom border-translucent py-3">
                                                                            <table class="w-100 table-stats">
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="py-2">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="d-flex bg-danger-subtle rounded-circle flex-center me-3" style="width:24px; height:24px"><span class="text-danger-dark" data-feather="clock" style="width:16px; height:16px"></span></div>
                                                                                            <p class="fw-bold mb-0">End Date</p>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                                                    <td class="py-2">
                                                                                        <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">{{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <!-- <div><a class="me-2" href="#!"><span class="fab fa-linkedin-in text-400 hover-primary"></span></a><a class="me-2" href="#!"><span class="fab fa-facebook text-400 hover-primary"></span></a><a href="#!"><span class="fab fa-twitter text-400 hover-primary"></span></a></div> -->
                                                            </div>
                                                            <div class="col-12 col-lg-3">
                                                                <div class="card h-90">
                                                                    <div class="card-body">
                                                                        <div class="mb-0">
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid far fa-folder-open"></span>{{$projectType}}</button>
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fas fa-eye"></span>{{$eventCategoryName}}</button>
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fas fa-user-tie"></span>{{$audienceName}} {{number_format($eventData->attendance_forcast)}}</button>
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fas fa-user-tag"></span>{{$plannerName}}</button>
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fas fa-globe"></span>{{$venueName}}</button>
                                                                            <button class="btn btn-sm btn-subtle-info rounded-3 mb d-flex align-items-center w-100"><span class="me-2 fa-solid fas fa-search-location"></span>{{$locationName}}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapseExample">
                                            <div class="border border-translucent p-3 rounded">{{$eventData->description}}</div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-activity" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="card">
                        <div class="mb-0">
                        <x-tasks-card :persons="$persons" :projects="$projects" :statuses="$statuses"  :departments="$departments"/>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-notes" role="tabpanel" aria-labelledby="notes-tab">
                    <div class="card mb-5">
                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between g-3 mt-2 ms-2">
                                <div class="col-12 col-md-auto">
                                    <h2 class="fw-bolder mb-1">Notes</h2>
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
                        </div>
                        <!-- <textarea class="form-control mb-3" id="notes" rows="4"> </textarea> -->
                        <div class="row gy-4">
                            <div class="col-12 col-xl-auto flex-1">
                                @foreach ($eventNote as $key => $item )
                                <div class="border-top border-dashed border-300 px-3 pt-3 pb-4">
                                    <div class="d-flex flex-between-center">
                                        <div class="d-flex mb-1"><span class="fa-solid fa-file-lines me-2 text-700 fs--1"></span>
                                            <p class="text-1000 mb-0 lh-1">{{$item->note_text}}</p>
                                        </div>
                                        @if (Auth::user()->can('project.note.delete'))
                                        <div class="font-sans-serif btn-reveal-trigger">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                <a class="dropdown-item text-danger" href="{{ route('main.event.delete.note',$item->id)}}" id="delete">Delete</a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <p class="fs--1 text-700 mb-2"><span class="text-400 mx-1">| </span><a href="#!">{{ $item->users->name }} </a><span class="text-400 mx-1">| </span><span class="text-nowrap">{{ $item->created_at }}</span>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-attachments" role="tabpanel" aria-labelledby="attachments-tab">
                    <div class="card mb-5">
                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between g-3 mt-2 ms-2">
                                <div class="col-12 col-md-auto">
                                    <h2 class="fw-bolder mb-0">Attachments</h2>
                                </div>
                                <div class="col-12 col-md-auto d-flex">
                                    @if (Auth::user()->can('project.file.create'))
                                    <a href="#!" data-id="{{ $eventData->id }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2" data-bs-toggle="modal" data-bs-target="#addAttachementModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-file-upload me-sm-2"></span><span class="d-none d-sm-inline">Upload a new file</span></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @foreach ($fileName as $key => $item )
                        <div class="border-top border-dashed border-300 px-3 pt-3 pb-4">
                            <div class="d-flex flex-between-center">
                                <div class="d-flex mb-1"><span class="fa-solid fa-file-lines me-2 text-700 fs--1"></span>
                                    <p class="text-1000 mb-0 lh-1"><a href="../../../upload/event_files/{{ $item->file_name }}" target="_blank">{{$item->original_file_name}}</a></p>
                                </div>
                                @if (Auth::user()->can('project.file.delete'))
                                <div class="font-sans-serif btn-reveal-trigger">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item text-danger" href="{{ route('main.event.file.delete', $item->id) }}" id="delete">Delete</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <p class="fs--1 text-700 mb-2"><span>{{$item->file_size/100}}kB</span><span class="text-400 mx-1">| </span><a href="#!">{{ $item->users->name }} </a><span class="text-400 mx-1">| </span><span class="text-nowrap">{{ $item->created_at }}</span></p>
                        </div>
                        @endforeach
                    </div>
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
    <!-- modal land -->


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
    <div class="modal" id="addTaskNoteModal" tabindex="-1" data-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

    <div class="modal fade" id="taskStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Status</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form class="needs-validation form-submit-event" novalidate="" action="{{ route('main.task.status.update') }}" method="POST" id="task_status">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="editTaskId" name="id">
                                    <input type="hidden" id="editTaskEventId" name="event_id">
                                    <input type="hidden" id="taskStatusParentTable" name="table">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Status</label>
                                        <select name="status_id" class="form-select" id="editTaskStatusSelection" required>
                                            <option selected="selected" value="">Select</option>
                                            @foreach ($statuses as $key => $item )
                                            <option value="{{ $item->id  }}">
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <!-- <input class="form-control" type="number" max="100" min="0" name="prorgress_number" id="editPoregessNumber" required /> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="submit_btn">Save</button>
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

    <div class="modal" id="taskCardViewModal" tabindex="-1" aria-labelledby="taskCardViewModal" aria-hidden="true">
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
                                    @if (Auth::user()->can('task.funds.show'))
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
                                    @endif
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
            // $('#fileUploadForm').ajaxForm({
            //     beforeSend: function() {
            //         var percentage = '0';
            //         console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");

            //     },
            //     uploadProgress: function(event, position, total, percentComplete) {
            //         var percentage = percentComplete;
            //         $('.progress .progress-bar').css("width", percentage + '%', function() {
            //             return $(this).attr("aria-valuenow", percentage) + "%";
            //         })
            //     },
            //     complete: function(xhr) {
            //         console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");
            //         window.location.href = "{{ route('main.task.list',$eventData->id) }}";
            //     }
            // });

            // $('#taskFileUploadForm').ajaxForm({
            //     beforeSend: function() {
            //         var percentage = '0';
            //         console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");

            //     },
            //     uploadProgress: function(event, position, total, percentComplete) {
            //         var percentage = percentComplete;
            //         $('.progress .progress-bar').css("width", percentage + '%', function() {
            //             return $(this).attr("aria-valuenow", percentage) + "%";
            //         })
            //     },
            //     complete: function(xhr) {
            //         console.log('File has uploaded: ' + "{{ route('main.task.list',$eventData->id) }}");
            //         window.location.href = "{{ route('main.task.list',$eventData->id) }}";
            //     }
            // });

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

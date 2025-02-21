@extends('tracki.layout.dashboard')
@section('main')


<!-- ***************************************************************************** */ -->
<div class="content">

    <!-- <div class="pb-9"> -->

    <div class="row g-4 g-xl-0 mt-3">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.project.show.card')}}"><?= get_label('projects', 'Projects') ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$eventData->name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-xl-12 col-xxl-12">
            <ul class="nav nav-underline deal-details scrollbar flex-nowrap w-100 pb-1 mb-6 mx-3" id="myTab" role="tablist" style="overflow-y: hidden;">
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link active" id="project-tab" data-bs-toggle="tab" href="#tab-project" role="tab" aria-controls="tab-project" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Project</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="activity-tab" data-bs-toggle="tab" href="#tab-activity" role="tab" aria-controls="tab-activity" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Tasks</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#tab-notes" role="tab" aria-controls="tab-notes" aria-selected="false" tabindex="-1"> <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes</a></li>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#tab-attachments" role="tab" aria-controls="tab-attachments" aria-selected="true"> <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments</a>
                <li class="nav-item text-nowrap me-2" role="presentation"><a class="nav-link" id="attendees-tab" data-bs-toggle="tab" href="#tab-attendees" role="tab" aria-controls="tab-attendees" aria-selected="true"> <span class="fas fa-person-booth me-2 tab-icon-color"></span>Attendance</a>
                </li>
            </ul>

            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade active show" id="tab-project" role="tabpanel" aria-labelledby="project-tab">
                            <div class="row g-0">
                                <div class="col-12 col-xxl-8 px-0 bg-phoenix-white border-start-xxl border-top-sm">
                                    <div class="px-4 px-lg-6 pt-6 pb-9">
                                        <!-- <div class="mb-5">
                                            <div class="d-flex justify-content-between">
                                                <h2 class="text-body-emphasis fw-bolder mb-2">{{ucfirst(Session::get('record_type'))}} {{$eventData->name}}</h2>
                                                <div class="btn-reveal-trigger">
                                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                                        <a class="dropdown-item" href="javascript:void(0);" id="add_edit_project" data-action="update" data-source="list" data-type="edit" data-table="none" data-id="{{$eventData->id}}" data-redirect="list" data-workspace_id="{{session()->get('workspace_id')}}">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#!">Delete</a>
                                                        <a class="dropdown-item" href="#!">Download</a>
                                                        <a class="dropdown-item" href="{{ route('gantt') }}" target="_blank">Gantt</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge badge-phoenix badge-phoenix-{{$eventData->status->color}}">{{$eventData->status->title}}<span class="ms-1 uil uil-stopwatch"></span></span>
                                            <span class="badge badge-phoenix badge-phoenix-warning">{{$FundCategory}}<span class="ms-1 uil uil-money-bill"></span></span>
                                        </div> -->
                                        <div class="row gx-0 gx-sm-5 gy-8 mb-1">
                                            <div class="col-12 col-xl-3 col-xxl-4 pe-xl-0">
                                                <div class="mb-4 mb-xl-7">
                                                    <div class="row gx-0 gx-sm-7">
                                                        <div class="col-12 col-sm-auto">
                                                            <table class="lh-sm mb-4 mb-sm-0 mb-xl-4">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="align-top py-1">
                                                                            <div class="d-flex"><span class="fa-solid fa-user me-2 text-body-tertiary fs-9"></span>
                                                                                <h5 class="text-body mb-0 text-nowrap">Client :</h5>
                                                                            </div>
                                                                        </td>
                                                                        <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="#!">{{$eventData->clients->pluck('first_name')->first().' '.$eventData->clients->pluck('last_name')->first()}}</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="align-top py-1">
                                                                            <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                                                <h5 class="text-body mb-0 text-nowrap">Budget : </h5>
                                                                            </div>
                                                                        </td>
                                                                        <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($eventData->budget_allocation)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="align-top py-1">
                                                                            <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                                                <h5 class="text-body mb-0 text-nowrap">Spent : </h5>
                                                                            </div>
                                                                        </td>
                                                                        <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($eventData->budget_allocation - $remainingBudget)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="align-top py-1">
                                                                            <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                                                <h5 class="text-body mb-0 text-nowrap">Remaining : </h5>
                                                                            </div>
                                                                        </td>
                                                                        <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($remainingBudget)}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="col-12 col-sm-auto">
                                                            <table class="lh-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Start : </td>
                                                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Deadline :</td>
                                                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Progress :</td>
                                                                        <td class="text-warning fw-semibold ps-3">{{$event_progress}}%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div>
                                                </div> -->
                                            </div>
                                            <div class="col-12 col-xl-9 col-xxl-8">
                                                <div class="row flex-center mb-3 g-3">
                                                    <div class="col-auto">
                                                        <h4 class="text-body-emphasis">Task status</h4>
                                                    </div>
                                                </div>
                                                <div class="echart-pie-edge-align-chart-example" style="min-height:200px;width:100%"></div>
                                                <!-- <div class="echart-completed-task-chart" style="min-height:200px;width:100%"></div> -->
                                            </div>

                                            <div class="row">
                                                <div class="d-flex align-items-top col-md-6"><span class="fa-solid fa-list-check me-2 text-body-tertiary fs-9"></span>
                                                    <h5 class="text-body-emphasis mb-0 me-2">{{$eventData->tasks->count()}}<span class="fw-normal ms-2">tasks</span></h5>
                                                </div>
                                                <div class="col-6 col-sm-6 col-lg-8 col-xl-6">
                                                    <h4 class="text-body-emphasis mb-4">Team members</h4>
                                                    <div class="d-flex mb-8">
                                                        <div id="project_team_members">
                                                            @foreach ($eventData->users as $key => $user )
                                                            <div class="avatar avatar-m  me-1" id="project_team_members_init">
                                                                <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" title="{{$user->name}}">
                                                                    <div class="avatar avatar-m  rounded-circle pull-up">
                                                                        <div class="avatar-name rounded-circle me-2"><span>{{ generateInitials($user->name) }}</span></div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @if (Auth::user()->can('project.edit'))
                                                        <div class="avatar avatar-m  me-1">
                                                            <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="javascript:void(0);" id="add_edit_project" data-action="update" data-source="list" data-type="edit" data-table="none" data-id="{{$eventData->id}}" data-redirect="list" data-workspace_id="{{session()->get('workspace_id')}}" role="button" title="add">
                                                                <div class="avatar avatar-m  rounded-circle pull-up">
                                                                    <div class="avatar-name rounded-circle me-2 text-warning"><span>+</span></div>
                                                                    <!-- <img class="rounded-circle " src="../../assets/img/team/34.webp" alt=""> -->
                                                                </div>
                                                            </a>
                                                        </div>

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-body-emphasis mb-2">Project overview</h4>
                                        <p class="text-body-secondary mb-4">{{strip_tags($eventData->description)}}</p>
                                        <!-- <p class="text-body-secondary mb-0">Join us in celebrating the massive success of data transferring and getting us a huge revenue by eating out. Free public viewing and a buffet is offered for the great team as well as for the other teams working with us. We’ll be checking out places for the best option available at hands and we’ll let you know the schedule once we decide on one.<a class="fw-semibold" href="#!">read more </a></p> -->
                                    </div>
                                </div>
                                <div class="col-12 col-xxl-4 px-0 border-start-xxl border-top-sm">
                                    <div class="bg-light dark__bg-gray-1100 h-100">
                                        <div class="p-4 p-lg-6">
                                            <div class="col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-6">
                                                <div class="mb-6">
                                                    <button class="badge badge-phoenix w-100 badge-phoenix-warning" data-bs-toggle="tooltip" data-bs-placement="left" title="Workspace" id="projectCategory"><span class="me-2 fa-solid fas fa-network-wired"></span>{{$eventData->workspaces->title}}</button>
                                                </div>
                                                <div class="mb-5">
                                                    <h4 class="text-body-emphasis">Attributes</h4>
                                                    <h6 class="text-body-tertiary"></h6>
                                                </div>
                                                <h5 class="text-body-secondary mb-3"></h5>
                                                <div class="mb-6">
                                                    <button class="btn btn-sm btn-secondary rounded-3 mb-2 d-flex align-items-center w-100 pull-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Project Category" id="projectCategory"><span class="me-2 fa-solid fa-earth-americas"></span>{{$eventData->categories->name?$eventData->categories->name:"not specified"}}</button>
                                                    <button class="btn btn-sm btn-secondary rounded-3 mb-2 d-flex align-items-center w-100 pull-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Project Type" id="projectType"><span class="me-2 fa-solid fa-folder-open"></span>{{$eventData->types->name?$eventData->types->name:"not specified"}}</button>
                                                    <button class="btn btn-sm btn-secondary rounded-3 mb-2 d-flex align-items-center w-100 pull-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Attendeeze Category" id="attendCategory"><span class="me-2 fa-solid fa-user-tie"></span>{{$eventData->audiences->name?$eventData->audiences->name:"not specified"}} ({{number_format($eventData->attendances->count())}})</button>
                                                    <button class="btn btn-sm btn-secondary rounded-3 mb-2 d-flex align-items-center w-100 pull-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Venue" id="venue"><span class="me-2 fa-solid fa-globe"></span>{{$eventData->venues->name?$eventData->venues->name:"not specified"}}</button>
                                                    <!-- <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fa-tag"></span>Labels</button> -->
                                                    <button class="btn btn-sm btn-secondary rounded-3 mb-2 d-flex align-items-center w-100 pull-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Location" id="location"><span class="me-2 fa-solid fa-search-location"></span>{{$eventData->locations->name?$eventData->locations->name:"not specified"}}</button>
                                                    <!-- <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Department" id="overviewtaskActualBudget"><span class="me-2 fa-solid fa-donate"></span>actual budget</button> -->
                                                    <!-- <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fa-square-check"></span>Checklist</button> -->
                                                </div>
                                                <!-- <h4 class="text-body-emphasis mb-4">Tags</h4><span class="badge badge-tag me-2 mb-1">Unused_brain</span><span class="badge badge-tag me-2 mb-1">Machine</span><span class="badge badge-tag me-2 mb-1">Coding</span><span class="badge badge-tag me-2 mb-1">Meseeks</span><span class="badge badge-tag me-2 mb-1">Smithpeople</span><span class="badge badge-tag me-2 mb-1">Rick</span><span class="badge badge-tag me-2 mb-1">Biology</span><span class="badge badge-tag me-2 mb-1">Neurology</span><span class="badge badge-tag me-2 mb-1">Brainlessness</span><span class="badge badge-tag me-2 mb-1">Stupidity</span><span class="badge badge-tag me-2 mb-1">Jerry</span><span class="badge badge-tag me-2 mb-1">Not _the_mouse</span> -->

                                            </div>
                                        </div>
                                        <div class="px-4 px-lg-6">
                                            <h4 class="mb-3">Tags</h4>
                                        </div>


                                        <div class="border-top px-4 px-lg-4 py-4">
                                            <!-- <div class="card setting-toggle border-top px-4 px-lg-4 py-4"> -->
                                            <div class="me-n3 ">
                                                <div class="flex-between-center">
                                                    @foreach ($eventData->tags as $key => $item )
                                                    <span class="badge badge-tag me-2 mb-1 pull-up" style="background-color:{{$item->color}};">{{$item->title}}</span>
                                                    @endforeach
                                                </div>
                                                <!-- <div class="d-flex fs-9 text-body-tertiary mb-2 flex-wrap"><span>768 kb</span><span class="text-body-quaternary mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">21st Dec, 12:56 PM</span></div><img class="rounded-2" src="../../assets/img/generic/40.png" alt="" style="max-width:270px" /> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-activity" role="tabpanel" aria-labelledby="activity-tab">
                            <!-- <div class="card"> -->
                            <div class="mb-0">
                                <x-tasks-card :users="$users" :projects="$eventData" :statuses="$statuses" :departments="$departments" source="list" showpage="list" showpageid="list_{{$eventData->id}}" />
                            </div>
                            <!-- </div> -->
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
                                                        <a class="dropdown-item text-danger" href="{{ route('tracki.event.delete.note',$item->id)}}" id="delete">Delete</a>
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
                                                <a class="dropdown-item text-danger" href="{{ route('tracki.event.file.delete', $item->id) }}" id="delete">Delete</a>
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
                                                        <a href="{{ route('tracki.event.attendance.assignment', $eventData->id) }}" class="btn btn-phoenix-primary px-3 px-sm-5 me-2">
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
                                                                        <a class="dropdown-item text-danger" href="{{ route('tracki.attendance.assignment.delete',$item->id, $item->event_id)}}" id="delete">Remove</a>
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
                        <form id="fileUploadForm" class="needs-validation" novalidate="" action="{{ route('tracki.event.file.store') }}" method="POST" enctype='multipart/form-data'>
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

            <div class="modal fade" id="progressModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-top">
                    <div class="modal-content bg-100">
                        <div class="modal-header bg-modal-header">
                            <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Propgress %</h3>
                            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                        </div>
                        <form class="needs-validation" novalidate="" action="{{ route('tracki.task.progress.update') }}" method="POST">
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
                        <form class="needs-validation" novalidate="" action="{{ route('tracki.event.note.store') }}" method="POST">
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

            @endsection

            @push('script')

            @include('tracki.task.partials.charts-js')

            <script src="{{ asset ('assets/jquery/dist/jquery.form.min.js') }}"></script>
            <script src="{{asset('assets/js/pages/projects.js')}}"></script>

            <script type="text/javascript">
                $(document).ready(function() {

                    // var id = $('#addId').val();
                    $('#fileUploadForm').ajaxForm({
                        beforeSend: function() {
                            var percentage = '0';
                            console.log('File has uploaded: ' + "{{ route('tracki.task.list',$eventData->id) }}");

                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentage = percentComplete;
                            $('.progress .progress-bar').css("width", percentage + '%', function() {
                                return $(this).attr("aria-valuenow", percentage) + "%";
                            })
                        },
                        complete: function(xhr) {
                            console.log('File has uploaded: ' + "{{ route('tracki.task.list',$eventData->id) }}");
                            window.location.href = "{{ route('tracki.task.list',$eventData->id) }}";
                        }
                    });

                    $('#taskFileUploadForm').ajaxForm({
                        beforeSend: function() {
                            var percentage = '0';
                            console.log('File has uploaded: ' + "{{ route('tracki.task.list',$eventData->id) }}");

                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentage = percentComplete;
                            $('.progress .progress-bar').css("width", percentage + '%', function() {
                                return $(this).attr("aria-valuenow", percentage) + "%";
                            })
                        },
                        complete: function(xhr) {
                            console.log('File has uploaded: ' + "{{ route('tracki.task.list',$eventData->id) }}");
                            window.location.href = "{{ route('tracki.task.list',$eventData->id) }}";
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
            @include('tracki.partials.event-js')

            @endpush

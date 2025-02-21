@extends('tracki.layout.dashboard')
@section('main')

<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Home</a></li>
            <li class="breadcrumb-item"><a href="#!">Users</a></li>
            <li class="breadcrumb-item active">{{$user->name}}</li>
        </ol>
    </nav>
    <div class="pb-9">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center justify-content-between g-3 mb-3">
                    <div class="col-12 col-md-auto">
                        <h2 class="mb-0">User details</h2>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="d-flex">
                            <div class="flex-1 d-md-none">
                                <button class="btn px-3 btn-phoenix-secondary text-body-tertiary me-2" data-phoenix-toggle="offcanvas" data-phoenix-target="#productFilterColumn"><span class="fa-solid fa-bars"></span></button>
                            </div>
                            <!-- <button class="btn btn-primary me-2"><span class="fa-solid fa-envelope me-2"></span><span>Send an email</span></button> -->
                            <!-- <button class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><span class="fa-solid fa-thumbtack me-sm-2"></span><span class="d-none d-sm-inline">Shortlist</span></button> -->
                            <!-- <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-ellipsis"></span></button> -->
                            <!-- <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                                <li><a class="dropdown-item" href="#!">View profile</a></li>
                                <li><a class="dropdown-item" href="#!">Report</a></li>
                                <li><a class="dropdown-item" href="#!">Manage notifications</a></li>
                                <li><a class="dropdown-item text-danger" href="#!">Delete Lead</a></li>
                            </ul> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-12">
                <div class="sticky-leads-sidebar">
                    <div class="lead-details-offcanvas bg-body scrollbar phoenix-offcanvas phoenix-offcanvas-fixed" id="productFilterColumn">
                        <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                            <h3 class="mb-0">User Details</h3>
                            <button class="btn p-0" data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-7"></span></button>
                        </div>
                        <div class="card mb-3">
                            <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
                                <div class="card-body">
                                    <div class="row align-items-center g-3 text-center text-xl-start">
                                        <div class="col-12 col-xxl-auto">
                                            <div class="avatar avatar-3xl"><img class="rounded-circle" src="../../../../assets/img/team/33.webp" alt="" /></div>
                                        </div>
                                        <div class="col-12 col-sm-auto flex-1">
                                            <h3 class="fw-bolder mb-2">{{$user->name}}</h3>


                                            <p class="mb-0">{{$user->email}}</p><a class="fw-bold" href="#!">{{$user->phone}}</a>



                                            <div class="d-flex flex-between-center border-top border-dashed pt-4">
                                                <div>
                                                    <h6>Projects</h6>
                                                    <p class="fs-7 text-body-secondary mb-0">{{$project_count->count()}}</p>
                                                </div>
                                                <div>
                                                    <h6>Tasks</h6>
                                                    <p class="fs-7 text-body-secondary mb-0">{{$tasks->count()}}</p>
                                                </div>
                                                <div>
                                                    <h6>Todos</h6>
                                                    <p class="fs-7 text-body-secondary mb-0">{{$user->todos->count()}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none top-0" data-phoenix-backdrop="data-phoenix-backdrop"></div>
                </div>
            </div>
            <div class="col-md-7 col-lg-7 col-xl-12">
                <div class="lead-details-container">
                    <nav class="navbar pb-4 px-0 sticky-top bg-body nav-underline-scrollspy" id="navbar-deals-detail">
                        <ul class="nav nav-underline fs-9">
                            <li class="nav-item"><a class="nav-link me-2" href="#scrollspyTask">Tasks</a></li>
                            <li class="nav-item"><a class="nav-link me-2" href="#scrollspyTodo">Todo</a></li>
                            <li class="nav-item"><a class="nav-link me-2" href="#scrollspyDeals">Deals</a></li>
                            <li class="nav-item"><a class="nav-link me-2" href="#scrollspyEmails">Emails</a></li>
                            <li class="nav-item"><a class="nav-link" href="#scrollspyAttachments">Attachments </a></li>
                        </ul>
                    </nav>

                    <div class="scrollspy-example rounded-2" data-bs-spy="scroll" data-bs-offset="0" data-bs-target="#navbar-deals-detail" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" tabindex="0">
                        <div class="mb-8">
                            <h2 class="mb-4" id="scrollspyTask">Tasks</h2>
                            <x-tasks-card :users="$user" :projects="$projects" :statuses="$statuses" :departments="$departments" source="list" showpage="user_profile" showpageid="user_{{$user->id}}" />
                        </div>


                        <div class="mt-3 mx-lg-n0 mb-4">
                            <div class="row g-3">
                                <div class="col-12 col-xl-6 col-xxl-7" id="scrollspyTodo">
                                    <div class="card todo-list h-100">
                                        <div class="card-header border-bottom-0 pb-0">
                                            <div class="row justify-content-between align-items-center mb-4">
                                                <div class="col-auto">
                                                    <h3 class="text-body-emphasis">To do</h3>
                                                    <!-- <p class="mb-2 mb-md-0 mb-lg-2 text-body-tertiary">Todos assigned to me</p> -->
                                                </div>
                                                <div class="col-auto w-100 w-md-auto">
                                                    <div class="row align-items-center g-0 justify-content-between">
                                                        <div class="col-12 col-sm-auto">
                                                            <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                                                                <form class="position-relative">
                                                                    <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
                                                                    <span class="fas fa-search search-box-icon"></span>

                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto d-flex">
                                                            <p class="mb-0 ms-sm-3 fs-9 text-body-tertiary fw-bold"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span>23 tasks</p>
                                                            <button class="btn btn-link p-0 ms-3 fs-9 text-primary fw-bold"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body py-0 scrollbar to-do-list-body">
                                            @foreach ($todos as $key => $todo )
                                            @php
                                            $is_completed_flag = "";
                                            $is_completed_flag = $todo->is_completed
                                            ? "checked"
                                            : "";
                                            @endphp
                                            <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">

                                                <!-- <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" onclick="update_todo_status(this)" name="subtask-{{ $todo->id }}" id="{{ $todo->id }}" {{ $is_completed_flag }}> -->
                                                <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" onclick="update_todo_status(this)" name="subtask-{{ $todo->id }}" id="{{ $todo->id }}" {{ $is_completed_flag }} data-event-propagation-prevent="data-event-propagation-prevent" />
                                                <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                            <label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">{{ $todo->title }}</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-{{$todo->priority->color}}">{{$todo->priority->title}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                        <div class="d-flex lh-1 align-items-center"><a class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><span class="fas fa-paperclip me-1"></span>2</a>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">{{format_date($todo->created_at, null,  'd M, Y')}}</p>
                                                            <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                                <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">{{format_date($todo->created_at, null,  'h:i A')}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                                                    <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                                                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent"><span class="fas fa-edit"></span></button>
                                                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent"><span class="fas fa-trash"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="card-footer border-0">
                                            <a class="fw-bold fs-9 mt-4" href="#!" data-bs-toggle="modal" data-bs-target="#createTodoModal" id="addSubtask"><span class="fas fa-plus me-1"></span>Add new task</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6 col-xxl-5">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="card-title mb-1">
                                                <h3 class="text-body-emphasis">Activity</h3>
                                            </div>
                                            <p class="text-body-tertiary mb-4">Recent activity across all projects</p>
                                            <div class="timeline-vertical timeline-with-details">
                                                <div class="timeline-item position-relative">
                                                    <div class="row g-md-3">
                                                        <div class="col-12 col-md-auto d-flex">
                                                            <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                                <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">01 DEC, 2023<br class="d-none d-md-block" /> 10:30 AM</p>
                                                            </div>
                                                            <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                                <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-chess text-primary-dark fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="timeline-item-content ps-6 ps-md-3">
                                                                <h5 class="fs-9 lh-sm">Phoenix Template: Unleashing Creative Possibilities</h5>
                                                                <p class="fs-9">by <a class="fw-semibold" href="#!">Shantinon Mekalan</a></p>
                                                                <p class="fs-9 text-body-secondary mb-5">Discover limitless creativity with the Phoenix template! Our latest update offers an array of innovative features and design options.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="timeline-item position-relative">
                                                    <div class="row g-md-3">
                                                        <div class="col-12 col-md-auto d-flex">
                                                            <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                                <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">05 DEC, 2023<br class="d-none d-md-block" /> 12:30 AM</p>
                                                            </div>
                                                            <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                                <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-dove text-primary-dark fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="timeline-item-content ps-6 ps-md-3">
                                                                <h5 class="fs-9 lh-sm">Empower Your Digital Presence: The Phoenix Template Unveiled</h5>
                                                                <p class="fs-9">by <a class="fw-semibold" href="#!">Bookworm22</a></p>
                                                                <p class="fs-9 text-body-secondary mb-5">Unveiling the Phoenix template, a game-changer for your digital presence. With its powerful features and sleek design,</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="timeline-item position-relative">
                                                    <div class="row g-md-3">
                                                        <div class="col-12 col-md-auto d-flex">
                                                            <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                                <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">15 DEC, 2023<br class="d-none d-md-block" /> 2:30 AM</p>
                                                            </div>
                                                            <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                                <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-dungeon text-primary-dark fs-10"></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="timeline-item-content ps-6 ps-md-3">
                                                                <h5 class="fs-9 lh-sm">Phoenix Template: Simplified Design, Maximum Impact</h5>
                                                                <p class="fs-9">by <a class="fw-semibold" href="#!">Sharuka Nijibum</a></p>
                                                                <p class="fs-9 text-body-secondary mb-0">Introducing the Phoenix template, where simplified design meets maximum impact. Elevate your digital presence with its sleek and intuitive features.</p>
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

                        <!-- </div> -->
                        <div class="mb-8">
                            <div class="d-flex justify-content-between align-items-center mb-4" id="scrollspyDeals">
                                <h2 class="mb-0">Deals</h2>
                                <button class="btn btn-primary btn-sm"><span class="fa-solid fa-plus me-2"></span>Add Deals</button>
                            </div>
                            <div class="border-top border-bottom border-translucent" id="leadDetailsTable" data-list='{"valueNames":["dealName","amount","stage","probability","date","type"],"page":5,"pagination":true}'>
                                <div class="table-responsive scrollbar mx-n1 px-1">
                                    <table class="table fs-9 mb-0">
                                        <thead>
                                            <tr>
                                                <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select='{"body":"lead-details-table-body"}' />
                                                    </div>
                                                </th>
                                                <th class="sort white-space-nowrap align-middle pe-3 ps-0 text-uppercase" scope="col" data-sort="dealName" style="width:15%; min-width:200px">Deal name</th>
                                                <th class="sort align-middle pe-6 text-uppercase text-end" scope="col" data-sort="amount" style="width:15%; min-width:100px">Amount</th>
                                                <th class="sort align-middle text-start text-uppercase" scope="col" data-sort="stage" style="width:20%; min-width:200px">Stage</th>
                                                <th class="sort align-middle text-start text-uppercase" scope="col" data-sort="probability" style="width:20%; min-width:100px">Probability</th>
                                                <th class="sort align-middle ps-0 text-end text-uppercase" scope="col" data-sort="date" style="width:15%; min-width:120px">Closing Date</th>
                                                <th class="sort align-middle text-end text-uppercase" scope="col" data-sort="type" style="width:15%; min-width:140px">Type</th>
                                                <th class="align-middle pe-0 text-end" scope="col" style="width:15%;"> </th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="lead-details-table-body">
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"Mocking Bird","active":true,"amount":"$6,800,000","stage_status":{"label":"won deal","type":"badge-phoenix-success"},"progress":{"min":"67","max":"145","color":"bg-info"},"date":"Dec 29, 2021","type_status":{"label":"warm","type":"badge-phoenix-info"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Mocking Bird</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$6,800,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">won deal</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">67%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-info" style="width: 46.206896551724135%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">Dec 29, 2021</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-info">warm</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"Airbender","active":true,"amount":"$89,090,000","stage_status":{"label":"new Deal","type":"badge-phoenix-primary"},"progress":{"min":"34","max":"145","color":"bg-warning"},"date":"Mar 27, 2021","type_status":{"label":"hot","type":"badge-phoenix-danger"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Airbender</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$89,090,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-primary">new Deal</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">34%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-warning" style="width: 23.448275862068964%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">Mar 27, 2021</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-danger">hot</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"Showmen","active":true,"amount":"$78,650,000","stage_status":{"label":"Canceled","type":"badge-phoenix-secondary"},"progress":{"min":"89","max":"145","color":"bg-success"},"date":"Jun 24, 2021","type_status":{"label":"cold","type":"badge-phoenix-warning"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Showmen</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$78,650,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary">Canceled</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">89%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-success" style="width: 61.37931034482759%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">Jun 24, 2021</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">cold</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"Tarakihi","active":true,"amount":"$1,200,000","stage_status":{"label":"In Progress","type":"badge-phoenix-info"},"progress":{"min":"90","max":"145","color":"bg-success"},"date":"May 19, 2024","type_status":{"label":"hot","type":"badge-phoenix-danger"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Tarakihi</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$1,200,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">In Progress</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">90%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-success" style="width: 62.06896551724138%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">May 19, 2024</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-danger">hot</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"Ponce d’leon","active":true,"amount":"$46,000","stage_status":{"label":"won Deal","type":"badge-phoenix-success"},"progress":{"min":"97","max":"145","color":"bg-success"},"date":"Aug 19, 2024","type_status":{"label":"cold","type":"badge-phoenix-warning"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Ponce d’leon</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$46,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">won Deal</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">97%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-success" style="width: 66.89655172413794%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">Aug 19, 2024</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">cold</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="fs-9 align-middle px-0 py-3">
                                                    <div class="form-check mb-0 fs-8">
                                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"dealName":"leon","active":true,"amount":"$66,000","stage_status":{"label":"IN PROGRESS","type":"badge-phoenix-info"},"progress":{"min":"88","max":"145","color":"bg-success"},"date":"Aug 19, 2024","type_status":{"label":"cold","type":"badge-phoenix-warning"}}' />
                                                    </div>
                                                </td>
                                                <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">leon</a></td>
                                                <td class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">$66,000</td>
                                                <td class="stage align-middle white-space-nowrap text-body py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">IN PROGRESS</span></td>
                                                <td class="probability align-middle white-space-nowrap">
                                                    <p class="text-body-secondary fs-10 mb-0">88%</p>
                                                    <div class="progress bg-primary-subtle" style="height:3px;" role="progressbar">
                                                        <div class="progress-bar bg-success" style="width: 60.689655172413794%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="date align-middle text-body-tertiary text-center py-2">Aug 19, 2024</td>
                                                <td class="type align-middle fw-semibold py-2 text-end"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">cold</span></td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                                    <div class="col-auto d-flex">
                                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                    </div>
                                    <div class="col-auto d-flex">
                                        <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                        <ul class="mb-0 pagination"></ul>
                                        <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-8">
                            <h2 class="mb-2" id="scrollspyEmails">Emails</h2>
                            <div>
                                <div class="scrollbar">
                                    <ul class="nav nav-underline fs-9 flex-nowrap mb-1" id="emailTab" role="tablist">
                                        <li class="nav-item me-3"><a class="nav-link text-nowrap border-0 active" id="mail-tab" data-bs-toggle="tab" href="#tab-mail" aria-controls="mail-tab" role="tab" aria-selected="true">Mails (68)<span class="text-body-tertiary fw-normal"></span></a></li>
                                        <li class="nav-item me-3"><a class="nav-link text-nowrap border-0" id="drafts-tab" data-bs-toggle="tab" href="#tab-drafts" aria-controls="drafts-tab" role="tab" aria-selected="true">Drafts (6)<span class="text-body-tertiary fw-normal"></span></a></li>
                                        <li class="nav-item me-3"><a class="nav-link text-nowrap border-0" id="schedule-tab" data-bs-toggle="tab" href="#tab-schedule" aria-controls="schedule-tab" role="tab" aria-selected="true">Scheduled (17)</a></li>
                                    </ul>
                                </div>
                                <div class="search-box w-100 mb-3">
                                    <form class="position-relative">
                                        <input class="form-control search-input search" type="search" placeholder="Search..." aria-label="Search" />
                                        <span class="fas fa-search search-box-icon"></span>

                                    </form>
                                </div>
                                <div class="tab-content" id="profileTabContent">
                                    <div class="tab-pane fade show active" id="tab-mail" role="tabpanel" aria-labelledby="mail-tab">
                                        <div class="border-top border-bottom border-translucent" id="allEmailsTable" data-list='{"valueNames":["subject","sent","date","source","status"],"page":7,"pagination":true}'>
                                            <div class="table-responsive scrollbar mx-n1 px-1">
                                                <table class="table fs-9 mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select='{"body":"all-email-table-body"}' />
                                                                </div>
                                                            </th>
                                                            <th class="sort white-space-nowrap align-middle pe-3 ps-0 text-uppercase" scope="col" data-sort="subject" style="width:31%; min-width:350px">Subject</th>
                                                            <th class="sort align-middle pe-3 text-uppercase" scope="col" data-sort="sent" style="width:15%; min-width:130px">Sent by</th>
                                                            <th class="sort align-middle text-start text-uppercase" scope="col" data-sort="date" style="min-width:165px">Date</th>
                                                            <th class="sort align-middle pe-0 text-uppercase" scope="col" style="width:15%; min-width:100px">Action</th>
                                                            <th class="sort align-middle text-end text-uppercase" scope="col" data-sort="status" style="width:15%; min-width:100px">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="all-email-table-body">
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"Quary about purchased soccer socks","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 29, 2021 10:23 am","source":"Call","type_status":{"label":"sent","type":"badge-phoenix-success"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Quary about purchased soccer socks</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 29, 2021 10:23 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">sent</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"How to take the headache out of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 27, 2021 3:27 pm","source":"Call","type_status":{"label":"delivered","type":"badge-phoenix-info"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">How to take the headache out of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 27, 2021 3:27 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">delivered</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"The Arnold Schwarzenegger of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 24, 2021 10:44 am","source":"Call","type_status":{"label":"Bounce","type":"badge-phoenix-warning"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">The Arnold Schwarzenegger of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 24, 2021 10:44 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">Bounce</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"My order is not being taken","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 4:55 pm","source":"Call","type_status":{"label":"Spam","type":"badge-phoenix-danger"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">My order is not being taken</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 4:55 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-danger">Spam</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"Shipment is missing","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 2:43 pm","source":"Call","type_status":{"label":"sent","type":"badge-phoenix-success"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Shipment is missing</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 2:43 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">sent</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"How can I order something urgently?","email":"ansolo45@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 2:43 pm","source":"Call","type_status":{"label":"Delivered","type":"badge-phoenix-info"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">How can I order something urgently?</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 2:43 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">Delivered</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"How the delicacy of the products will be handled?","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 16, 2021 5:18 pm","source":"Call","type_status":{"label":"bounced","type":"badge-phoenix-warning"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">How the delicacy of the products will be handled?</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 16, 2021 5:18 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">bounced</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                                                <div class="col-auto d-flex">
                                                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                                </div>
                                                <div class="col-auto d-flex">
                                                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                                    <ul class="mb-0 pagination"></ul>
                                                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-drafts" role="tabpanel" aria-labelledby="drafts-tab">
                                        <div class="border-top border-bottom border-translucent" id="draftsEmailsTable" data-list='{"valueNames":["subject","sent","date","source","status"],"page":7,"pagination":true}'>
                                            <div class="table-responsive scrollbar mx-n1 px-1">
                                                <table class="table fs-9 mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select='{"body":"drafts-email-table-body"}' />
                                                                </div>
                                                            </th>
                                                            <th class="sort white-space-nowrap align-middle pe-3 ps-0 text-uppercase" scope="col" data-sort="subject" style="width:31%; min-width:350px">Subject</th>
                                                            <th class="sort align-middle pe-3 text-uppercase" scope="col" data-sort="sent" style="width:15%; min-width:130px">Sent by</th>
                                                            <th class="sort align-middle text-start text-uppercase" scope="col" data-sort="date" style="min-width:165px">Date</th>
                                                            <th class="sort align-middle pe-0 text-uppercase" scope="col" style="width:15%; min-width:100px">Action</th>
                                                            <th class="sort align-middle text-end text-uppercase" scope="col" data-sort="status" style="width:15%; min-width:100px">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="drafts-email-table-body">
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"Quary about purchased soccer socks","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 29, 2021 10:23 am","source":"Call","type_status":{"label":"sent","type":"badge-phoenix-success"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Quary about purchased soccer socks</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 29, 2021 10:23 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">sent</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"How to take the headache out of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 27, 2021 3:27 pm","source":"Call","type_status":{"label":"delivered","type":"badge-phoenix-info"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">How to take the headache out of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 27, 2021 3:27 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">delivered</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"The Arnold Schwarzenegger of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 24, 2021 10:44 am","source":"Call","type_status":{"label":"Bounce","type":"badge-phoenix-warning"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">The Arnold Schwarzenegger of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 24, 2021 10:44 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">Bounce</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"My order is not being taken","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 4:55 pm","source":"Call","type_status":{"label":"Spam","type":"badge-phoenix-danger"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">My order is not being taken</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 4:55 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-danger">Spam</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"Shipment is missing","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 2:43 pm","source":"Call","type_status":{"label":"sent","type":"badge-phoenix-success"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Shipment is missing</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 2:43 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">sent</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                                                <div class="col-auto d-flex">
                                                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                                </div>
                                                <div class="col-auto d-flex">
                                                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                                    <ul class="mb-0 pagination"></ul>
                                                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-schedule" role="tabpanel" aria-labelledby="schedule-tab">
                                        <div class="border-top border-bottom border-translucent" id="scheduledEmailsTable" data-list='{"valueNames":["subject","sent","date","source","status"],"page":7,"pagination":true}'>
                                            <div class="table-responsive scrollbar mx-n1 px-1">
                                                <table class="table fs-9 mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select='{"body":"scheduled-email-table-body"}' />
                                                                </div>
                                                            </th>
                                                            <th class="sort white-space-nowrap align-middle pe-3 ps-0 text-uppercase" scope="col" data-sort="subject" style="width:31%; min-width:350px">Subject</th>
                                                            <th class="sort align-middle pe-3 text-uppercase" scope="col" data-sort="sent" style="width:15%; min-width:130px">Sent by</th>
                                                            <th class="sort align-middle text-start text-uppercase" scope="col" data-sort="date" style="min-width:165px">Date</th>
                                                            <th class="sort align-middle pe-0 text-uppercase" scope="col" style="width:15%; min-width:100px">Action</th>
                                                            <th class="sort align-middle text-end text-uppercase" scope="col" data-sort="status" style="width:15%; min-width:100px">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="scheduled-email-table-body">
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"Quary about purchased soccer socks","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 29, 2021 10:23 am","source":"Call","type_status":{"label":"sent","type":"badge-phoenix-success"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">Quary about purchased soccer socks</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 29, 2021 10:23 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-success">sent</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"How to take the headache out of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 27, 2021 3:27 pm","source":"Call","type_status":{"label":"delivered","type":"badge-phoenix-info"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">How to take the headache out of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 27, 2021 3:27 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-info">delivered</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"The Arnold Schwarzenegger of Order","email":"ansolo45@mail.com"},"active":true,"sent":"Ansolo Lazinatov","date":"Dec 24, 2021 10:44 am","source":"Call","type_status":{"label":"Bounce","type":"badge-phoenix-warning"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">The Arnold Schwarzenegger of Order</a>
                                                                <div class="fs-10 d-block">ansolo45@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Ansolo Lazinatov</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 24, 2021 10:44 am</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-warning">Bounce</span></td>
                                                        </tr>
                                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                            <td class="fs-9 align-middle px-0 py-3">
                                                                <div class="form-check mb-0 fs-8">
                                                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"mail":{"subject":"My order is not being taken","email":"jackson@mail.com"},"active":true,"sent":"Jackson Pollock","date":"Dec 19, 2021 4:55 pm","source":"Call","type_status":{"label":"Spam","type":"badge-phoenix-danger"}}' />
                                                                </div>
                                                            </td>
                                                            <td class="subject order align-middle white-space-nowrap py-2 ps-0"><a class="fw-semibold text-primary" href="#!">My order is not being taken</a>
                                                                <div class="fs-10 d-block">jackson@mail.com</div>
                                                            </td>
                                                            <td class="sent align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">Jackson Pollock</td>
                                                            <td class="date align-middle white-space-nowrap text-body py-2">Dec 19, 2021 4:55 pm</td>
                                                            <td class="align-middle white-space-nowrap ps-3"><a class="text-body" href="#!"><span class="fa-solid fa-phone text-primary me-2"></span>Call</a></td>
                                                            <td class="status align-middle fw-semibold text-end py-2"><span class="badge badge-phoenix fs-10 badge-phoenix-danger">Spam</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                                                <div class="col-auto d-flex">
                                                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                                </div>
                                                <div class="col-auto d-flex">
                                                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                                    <ul class="mb-0 pagination"></ul>
                                                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="mb-4" id="scrollspyAttachments">Attachments</h2>
                            <div class="border-top border-dashed pt-3 pb-4">
                                <div class="d-flex flex-between-center">
                                    <div class="d-flex mb-1"><span class="fa-solid fa-image me-2 text-body-tertiary fs-9"></span>
                                        <p class="text-body-highlight mb-0 lh-1">Silly_sight_1.png</p>
                                    </div>
                                    <div class="btn-reveal-trigger">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                    </div>
                                </div>
                                <p class="fs-9 text-body-tertiary mb-3"><span>768kB</span><span class="text-body-quaternary mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">21st Dec, 12:56 PM</span></p><img class="rounded-2" src="../../assets/img/generic/40.png" alt="" />
                            </div>
                            <div class="border-top border-dashed py-4">
                                <div class="d-flex flex-between-center">
                                    <div>
                                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-image me-2 fs-9 text-body-tertiary"></span>
                                            <p class="text-body-highlight mb-0 lh-1">All_images.zip</p>
                                        </div>
                                        <p class="fs-9 text-body-tertiary mb-0"><span>12.8 mB</span><span class="text-body-quaternary mx-1">|</span><a href="#!">Yves Tanguy </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">19th Dec, 08:56 PM</span></p>
                                    </div>
                                    <div class="btn-reveal-trigger">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top border-dashed py-4">
                                <div class="d-flex flex-between-center">
                                    <div>
                                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-file-lines me-2 fs-9 text-body-tertiary"></span>
                                            <p class="text-body-highlight mb-0 lh-1">Project.txt</p>
                                        </div>
                                        <p class="fs-9 text-body-tertiary mb-0"><span>123 kB</span><span class="text-body-quaternary mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">12th Dec, 12:56 PM</span></p>
                                    </div>
                                    <div class="btn-reveal-trigger">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse </a></div>
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

        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        @endsection

        @push('script')


        @endpush

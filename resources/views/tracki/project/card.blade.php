@extends('tracki.event.layout.event-add-layout')
@section('main')

<?php

use App\Models\Workspace;

$workspace_id = session()->get('workspace_id') ? session()->get('workspace_id') : "0";
$is_workspace_id_set = ($workspace_id) ? true : false;
$disabled = "";
// if (!$is_workspace_id_set){
//     $disabled = "disabled";
// }

// $workspace = Workspace::findOrFail($workspace_id);
// $clients = $workspace->clients;

?>

<!-- {{ logger('clients: '.$clients)}} -->
<div class="content">

    <div class="d-flex justify-content-between m-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{url('/main/dashboard')}}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('tracki.project.show.card')}}">
                            <?= get_label('projects', 'Projects') ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= get_label('card', 'Card') ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-between align-items-end mb-4 g-3">
        <div class="col-12 col-sm-auto">
            <h2 class="mb-0">{{__('traki.project.card_title')}}<span class="fw-normal text-700 ms-3">({{$eventData->count()}})</span></h2>
        </div>
        <div class="col-12 col-sm-auto">
            <div class="d-flex align-items-center">
                <div class="search-box me-3">
                </div>
                <!-- <a class="btn btn-primary px-5" href="#!" id="add_new_project" data-workspace-id=""><i class="bx bx-plus"></i></a> -->
                <!-- <a href="#" id="add_new_project" data-workspace-id=""><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>"><i class="bx bx-plus"></i></button></a> -->
            </div>
        </div>
    </div>
    <div class="row justify-content-between align-items-end mb-4 g-3">
        <div class="col-12 col-sm-auto">
            <ul class="nav nav-links mx-n2">
                <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_all}}" aria-current="page" href=" {{ route('tracki.project.show.card')}} "><span>All</span></a></li>
                <!-- <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_active}}" href="{{ route('tracki.project.show.card', 'active')}} "><span>Active</span></a></li> -->
                <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_inprogress}}" href="{{ route('tracki.project.show.card', 'inprogress')}} "><span>In-progress</span></a></li>
                <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_completed}}" href="{{ route('tracki.project.show.card', 'completed')}}"><span>Completed</span></a></li>
                <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_unbudgeted}}" href="{{ route('tracki.project.show.card', 'unbudgeted')}}"><span>Unbudgeted</span></a></li>
            </ul>


        </div>
        <!-- <div class="col-12 col-sm-auto">
            <div class="d-flex align-items-center">
                <div class="search-box me-3">
                </div>
                <a class="btn btn-sm btn-phoenix-secondary preview-btn ms-2 me-3" href="{{ route('tracki.project.export.now') }}"><span class="fa-solid fas fa-download me-2"></span>Download all projects</a>
                <a href="javascript:void(0);" class="{{$disabled}} btn btn-sm btn-primary ms-2 me-3" data-bs-toggle="tooltip" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>" id="add_edit_project" data-action="store" data-redirect="card" data-type="add" data-table="none" data-id="" data-workspace_id="{{session()->get('workspace_id')}}">
                    <i class="bx bx-plus"></i>
                </a>
                <a class="btn btn-phoenix-primary px-3 me-1" href="{{route('tracki.project.show.list')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view"><span class="fa-solid fa-list fs--2"></span></a>
            </div>
        </div> -->
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative">
                        <input class="form-control search-input search" type="search" placeholder="Search products" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                </div>
                <div class="scrollbar overflow-hidden-y">
                    <div class="btn-group position-static" role="group">
                        <div class="py-0 me-2">
                            <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none">
                                <option value="" selected>Filter by Workspace .... </option>
                                @foreach ($workspaces as $key => $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="py-0">
                            <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none">
                                <option value="" selected>Venue</option>
                                @foreach ($event_venue as $key => $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- <div class="btn-group position-static text-nowrap">
                            <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                {{$ws_dropdown?$ws_dropdown:''}} Workspace<span class="fas fa-angle-down ms-2"></span></button>
                            <ul class="dropdown-menu">
                                @foreach ($workspaces as $key => $item)
                                <li><a class="dropdown-item" href="?ws={{$item->id}}">{{$item->title}}</a></li>
                                @endforeach
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="?">See all</a></li>
                            </ul>
                        </div>
                        <div class="btn-group position-static text-nowrap">
                            <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                {{$venue_dropdown?$venue_dropdown:''}} Venue<span class="fas fa-angle-down ms-2"></span></button>
                            <ul class="dropdown-menu">
                                @foreach ($event_venue as $key => $item)
                                <li><a class="dropdown-item" href="?venue={{$item->id}}">{{$item->name}}</a></li>
                                @endforeach
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="?">See all</a></li>
                            </ul>
                        </div> -->
                        <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters</button>
                    </div>
                </div>
                <div class="col-12 col-sm-auto">
                    <div class="d-flex align-items-center">
                        <div class="search-box me-3">
                        </div>
                        <a class="btn btn-sm btn-phoenix-secondary preview-btn ms-2 me-3" href="{{ route('tracki.project.export.now') }}"><span class="fa-solid fas fa-download me-2"></span>Download all projects</a>
                        <a href="javascript:void(0);" class="{{$disabled}} btn btn-sm btn-primary ms-2 me-3" data-bs-toggle="tooltip" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>" id="add_edit_project" data-action="store" data-redirect="card" data-type="add" data-table="none" data-id="" data-workspace_id="{{session()->get('workspace_id')}}">
                            <i class="bx bx-plus"></i>
                        </a>
                        <a class="btn btn-phoenix-primary px-3 me-1" href="{{route('tracki.project.show.list')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view"><span class="fa-solid fa-list fs--2"></span></a>
                    </div>
                </div>
                <!-- <div class="ms-xxl-auto">
                    <button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button>
                    <button class="btn btn-primary" id="addBtn"><span class="fas fa-plus me-2"></span>Add product</button>
                </div>
            </div> -->
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 g-3 mb-9">

            @foreach ($eventData as $key => $item )


            <?php
            $client_name = "";
            foreach ($item->clients as $key => $client)
                $client_name = $client->first_name . ' ' . $client->last_name;
            ?>
            <!-- logger('card:: inside foreach project: '.$item->clients.['first_name'][0]) -->
            <?php
            $project_progress = get_project_progress($item->id);
            ?>
            <div class="col">
                <div class="card h-100 hover-actions-trigger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-2 line-clamp-1 lh-sm flex-1 me-5">{{$item->name}}</h4><span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-warning">{{$item->workspaces?->title}}</span>
                            <div class="hover-actions top-0 end-0 mt-8 me-4">
                                <!-- <button class="btn btn-primary btn-icon flex-shrink-0" id="projectsCardViewModal" data-bs-toggle="modal" data-bs-target="#projectsCardViewModal"><span class="fa-solid fa-chevron-right"></span></button> -->

                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-gear"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    @if (Auth::user()->can('project.edit'))
                                    <a class="dropdown-item" href="javascript:void(0);" id="add_edit_project" data-action="update" data-source="list" data-type="edit" data-table="none" data-id="{{$item->id}}" data-redirect="card" data-workspace_id="{{session()->get('workspace_id')}}">Edit</a>
                                    @endif
                                    @if (Auth::user()->can('project.delete'))
                                    <a class="dropdown-item text-danger" href="#!" id="delete" data-id="" title="Delete" class="card-link">Delete</a>
                                    @endif
                                </div>

                                <!-- <a href="{{ route('tracki.task.list', $item['id']) }}" class="btn btn-primary btn-icon flex-shrink-0"><span class="fa-solid fa-chevron-right"></span></a> -->
                            </div>

                        </div>
                        <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-{{$item->status->color}}">{{$item->status->title}}<span class="ms-1 fas fa-stream"></span></span>

                        @if ($project_progress == 999) <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-warning">In-progress<span class="ms-1 fas fa-stream"></span></span>
                        @php
                        $bg = 'bg-warning';
                        @endphp

                        @elseif ($project_progress == 999)
                        <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-success">Completed<span class="ms-1 fas fa-check"></span></span>
                        @php
                        $bg = 'bg-success';
                        @endphp
                        @endif

                        @if ($item->fundCategories?->name == 'Budgeted')
                        @php
                        $bg_color = 'badge-phoenix-success';
                        @endphp
                        @else
                        @php
                        $bg_color = 'badge-phoenix-danger';
                        @endphp
                        @endif

                        @if (Auth::user()->can('project.funds.show'))
                        <span class="badge badge-phoenix fs--2 {{$bg_color}}">{{$item->fundCategories?->name}}</span>
                        @endif
                        <!-- <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-success">completed</span> -->
                        <div class="d-flex align-items-center mb-2"><span class="fa-solid fa-user me-2 text-700 fs--1 fw-extra-bold"></span>
                            <p class="fw-bold mb-0 text-truncate lh-1">Client : <span class="fw-semi-bold text-primary ms-1"> {{ $client_name }} </span></p>
                        </div>
                        <!-- <div class="d-flex align-items-center mb-2"><span class="fas fa-project-diagram me-2 text-700 fs--1 fw-extra-bold"></span>
                        <p class="fw-bold mb-0 text-truncate lh-1">Project Type : <span class="fw-semi-bold text-primary ms-1"> {{$item->types->name}}</span></p>
                    </div> -->

                        @if (Auth::user()->can('project.funds.show'))

                        <!-- <div class="d-flex align-items-center mb-2"><span class="fa-solid fa-credit-card me-2 text-700 fs--1 fw-extra-bold"></span>
                            <p class="fw-bold mb-0 lh-1">Fund : <span class="ms-1 text-1100"><span class="badge badge-phoenix fs--2 {{$bg_color}}">{{$item['fund_name']}}</span></span></p>
                        </div> -->
                        <div class="d-flex align-items-center mb-2"><span class="fa-solid fa-credit-card me-2 text-700 fs--1 fw-extra-bold"></span>
                            <p class="fw-bold mb-0 lh-1">Budget : <span class="ms-1 text-1100">{{$item->budget_allocation}}</span></p>
                        </div>
                        <!-- <div class="d-flex align-items-center mb-2"><span class="fa-solid fas fa-cash-register me-2 text-700 fs--1 fw-extra-bold"></span>
                        <p class="fw-bold mb-0 lh-1">Balance : <span class="ms-1 text-1100">{{$item->tasks->sum('actual_budget_allocated')}}</span></p>
                    </div>
                    <div class="d-flex align-items-center mb-4"><span class="fa-solid fas fa-money-bill me-2 text-700 fs--1 fw-extra-bold"></span>
                        <p class="fw-bold mb-0 lh-1">Sales : <span class="ms-1 text-1100">{{$item->total_sales}}</span></p>
                    </div> -->

                        @endif

                        <div class="d-flex justify-content-between text-body-tertiary fw-semibold">
                            <p class="mb-2"> Progress</p>
                            <p class="mb-2 text-1100">{{$project_progress*100}}%</p>
                        </div>
                        <div class="progress bg-success-100">
                            <div class="progress-bar rounded bg-{{$item->status->color}}" role="progressbar" aria-label="Success example" style="width: {{$project_progress*100}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex align-items-center mt-5">
                            <p class="mb-0 fw-bold fs-9">Started :<span class="fw-semibold text-body-tertiary text-opactity-85 ms-1">{{ Carbon\Carbon::parse($item->start_date)->format('d-M-Y') }}</span></p>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <p class="mb-0 fw-bold fs-9">Deadline : <span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"> {{ Carbon\Carbon::parse($item->end_date)->format('d-M-Y') }}</span></p>
                        </div>

                        <div class="d-flex d-lg-block d-xl-flex justify-content-between align-items-center mt-3">
                            <div class="avatar-group">
                                @foreach ($item->employees as $key => $user )


                                @if ($user->emp_files?->file_path)
                                <div class="avatar avatar-m ">
                                    <a href="{{route('tracki.employee.profile', $user->id)}}" role="button" title="{{$user->full_name}}">
                                        <img class="rounded-circle pull-up" src=" {{$user->emp_files->file_path}}{{ $user->emp_files->file_name }}" alt="" />
                                    </a>
                                </div>
                                @else
                                <div class="avatar avatar-m  me-1">

                                    <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('tracki.employee.profile', $user->id)}}" role="button" title="{{$user->name}}">
                                        <div class="avatar avatar-m  rounded-circle pull-up">
                                            <div class="avatar-name rounded-circle me-2"><span>{{ generateInitials($user->full_name) }}</span></div>
                                            <!-- <img class="rounded-circle " src="../../assets/img/team/34.webp" alt=""> -->
                                        </div>
                                    </a>
                                </div>
                                @endif


                                @endforeach
                                @if (Auth::user()->can('project.edit'))
                                <div class="avatar avatar-m  me-1">

                                    <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="javascript:void(0);" id="add_edit_project" data-action="update" data-source="list" data-type="edit" data-table="none" data-id="{{$item->id}}" data-redirect="card" data-workspace_id="{{session()->get('workspace_id')}}" role="button" title="add">
                                        <div class="avatar avatar-m  rounded-circle pull-up">
                                            <div class="avatar-name rounded-circle me-2 text-warning"><span>+</span></div>
                                            <!-- <img class="rounded-circle " src="../../assets/img/team/34.webp" alt=""> -->
                                        </div>
                                    </a>
                                </div>

                                <!-- <div class="avatar avatar-m  rounded-circle pull-up">
                                <div class="avatar-name rounded-circle "><span>+</span></div>
                            </div>
                            <a class="dropdown-item" href="javascript:void(0);" id="add_edit_project" data-action="update" data-source="list" data-type="edit" data-table="none" data-id="{{$item->id}}" data-redirect="card" data-workspace_id="{{session()->get('workspace_id')}}">Edit</a>
                             -->
                                @endif

                            </div>
                            <div class="mt-lg-3 mt-xl-0"><a href="{{ route('tracki.task.list', $item['id']) }}"> <i class="fa-solid fa-list-check me-1"></i>
                                    <p class="d-inline-block fw-bold mb-0">{{$item->tasks->count()}}<span class="fw-normal"> Task</span>
                                </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!-- Modal to show the overview of the event with tasks and  -->

        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        @endsection

        @push('script')
        <script src="{{asset('assets/js/pages/projects.js')}}"></script>


        @endpush

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
                                <option value="" selected>Filter by Workspace ....    </option>
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
    <div id="projectCards"></div>

    <!-- Modal to show the overview of the event with tasks and  -->

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')
    <script src="{{asset('assets/js/pages/projects.js')}}"></script>


    @endpush

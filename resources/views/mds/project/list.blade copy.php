@extends('tracki.event.layout.event-add-layout')
@section('main')


<div class="content">
    <div class="mb-9">
        <div id="projectSummary" data-list='{"valueNames":["projectName","assigness","start","deadline","task","projectprogress","status","action"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{__('traki.project.card_title')}}<span class="fw-normal text-body-tertiary ms-3">({{$count}})</span></h2>
                </div>
                @if (Auth::user()->can('project.create'))
                <div class="col-auto"><a class="btn btn-primary px-5" href="{{ route('tracki.project.add')}}"><i class="fa-solid fa-plus me-2"></i>Add new project</a></div>
                @endif
            </div>
            <div class="row g-3 justify-content-between align-items-end mb-4">
                <div class="col-12 col-sm-auto">
                    <ul class="nav nav-links mx-n2">
                        <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_all}}" aria-current="page" href=" {{ route('tracki.project.show.list')}} "><span>All</span></a></li>
                        <!-- <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_active}}" href="{{ route('tracki.project.show.list', 'active')}} "><span>Active</span></a></li> -->
                        <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_inprogress}}" href="{{ route('tracki.project.show.list', 'inprogress')}} "><span>In-progress</span></a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_completed}}" href="{{ route('tracki.project.show.list', 'completed')}}"><span>Completed</span></a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 {{$active_unbudgeted}}" href="{{ route('tracki.project.show.list', 'unbudgeted')}}"><span>Unbudgeted</span></a></li>
                    </ul>
                </div>
                <div class="col-12 col-sm-auto">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-phoenix-secondary preview-btn ms-2 me-3" href="{{ route('tracki.project.export.now') }}"><span class="fa-solid fas fa-download me-2"></span>Download all projects</a>
                        <div class="search-box me-3">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>

                            </form>
                        </div>
                        <a class="btn btn-phoenix-primary px-3" href="{{route('tracki.project.show.card')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Card view">
                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0.5C0 0.223858 0.223858 0 0.5 0H3.5C3.77614 0 4 0.223858 4 0.5V3.5C4 3.77614 3.77614 4 3.5 4H0.5C0.223858 4 0 3.77614 0 3.5V0.5Z" fill="currentColor"></path>
                                <path d="M0 5.5C0 5.22386 0.223858 5 0.5 5H3.5C3.77614 5 4 5.22386 4 5.5V8.5C4 8.77614 3.77614 9 3.5 9H0.5C0.223858 9 0 8.77614 0 8.5V5.5Z" fill="currentColor"></path>
                                <path d="M5 0.5C5 0.223858 5.22386 0 5.5 0H8.5C8.77614 0 9 0.223858 9 0.5V3.5C9 3.77614 8.77614 4 8.5 4H5.5C5.22386 4 5 3.77614 5 3.5V0.5Z" fill="currentColor"></path>
                                <path d="M5 5.5C5 5.22386 5.22386 5 5.5 5H8.5C8.77614 5 9 5.22386 9 5.5V8.5C9 8.77614 8.77614 9 8.5 9H5.5C5.22386 9 5 8.77614 5 8.5V5.5Z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0 border-top border-translucent">
                    <thead>
                        <tr>
                            <!-- <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:5%;"></th> -->
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:20%;">PROJECT NAME</th>
                            <!-- <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">FUND</th> -->
                            <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNESS</th>
                            <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                            <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:10%;">DEADLINE</th>
                            <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:5%;">TASK</th>
                            <!-- <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th> -->
                            <th class="sort align-middle text-end" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                            <th class="sort align-middle text-end" scope="col" style="width:2%;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                        @foreach ($eventData as $key => $item )
                        <tr class="position-static">
                            <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-8" href="{{ route('tracki.task.list', $item['id']) }}">{{$item['name']}}</a>
                            </td>
                            @if ($item['fund_name'] == 'Budgeted')
                            @php
                            $bg_color = 'badge-phoenix-success';
                            @endphp
                            @else
                            @php
                            $bg_color = 'badge-phoenix-danger';
                            @endphp
                            @endif
                            <!-- <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><span class="badge badge-phoenix fs--2 badge-phoenix-primary">{{$item['fa_name']}}</span></td> -->

                            <!-- <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><span class="badge badge-phoenix fs--2 ml-1 badge-phoenix-primary">{{$item['fa_name']}}</span><span class="ms-1 text-1100"><span class="badge badge-phoenix fs--2 {{$bg_color}}">{{$item['fund_name']}}</span>
                            </td> -->
                            <td class="align-middle white-space-nowrap assigness ps-3 py-4">
                                <div class="avatar-group avatar-group-dense">
                                    <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                        <div class="avatar avatar-m  rounded-circle">
                                            <!-- <span>{{substr($item['planner'], 0, 1)}}</span> -->
                                            <span>{{$item['planner']}}</span>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle white-space-nowrap start ps-3 py-4">
                                <p class="mb-0 fs-9 text-body">{{ Carbon\Carbon::parse($item['start_date'])->format('M d, Y') }}</p>
                            </td>
                            <td class="align-middle white-space-nowrap deadline ps-3 py-4">
                                <p class="mb-0 fs-9 text-body">{{ Carbon\Carbon::parse($item['end_date'])->format('M d, Y') }}</p>
                            </td>
                            <td class="align-middle white-space-nowrap task ps-3 py-4">
                                <p class="fw-bo text-body fs-9 mb-0"><a href="{{ route('tracki.task.list', $item['id']) }}">{{$item['task_count']}}</a></p>
                            </td>

                            <!-- <td class="align-middle white-space-nowrap ps-3 projectprogress">
                                <p class="text-body-secondary fs-10 mb-0">145 / 145</p>
                                <div class="progress" style="height:3px;">
                                    <div class="progress-bar bg-success" style="width: 100%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td> -->

                            <td class="align-middle white-space-nowrap text-end statuses">
                                <!-- <span class="badge badge-phoenix fs-10 badge-phoenix-success">completed</span> -->
                                <span class="badge badge-phoenix fs--2 ml-1 badge-phoenix-primary">{{$item['fa_name']}}</span>
                                @if ($item['progress'] < 100) <span class="badge badge-phoenix fs-10 badge-phoenix-warning">In-progress<span class="ms-1 fas fa-stream"></span></span>
                                    @php
                                    $bg = 'bg-warning';
                                    @endphp

                                    @elseif ($item['progress'] >= 100)
                                    <span class="badge badge-phoenix fs-10 badge-phoenix-success">Completed<span class="ms-1 fas fa-check"></span></span>
                                    @php
                                    $bg = 'bg-success';
                                    @endphp
                                    @endif
                                    <span class="ms-1 text-1100"><span class="badge badge-phoenix fs--2 {{$bg_color}}">{{$item['fund_name']}}</span>
                            </td>
                            <td class="align-middle text-end white-space-nowrap pe-0 action">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="{{ route('tracki.task.list', $item['id']) }}">View</a>
                                        @if (Auth::user()->can('project.edit'))
                                        <a class="dropdown-item" href="{{ route('tracki.project.edit', $item['id']) }}">Edit</a>
                                        @endif
                                        @if (Auth::user()->can('project.delete'))
                                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="{{ route('tracki.project.delete',['id' => $item['id']])}}" id="delete">Remove</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs-9 border-bottom border-translucent">
                <div class="d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="d-flex">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

@extends('main.event.layout.event-add-layout')
@section('main')

<div class="content">
    <div class="row g-4 g-xl-0 mt-3">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('main.project.show.card')}}"><?= get_label('task', 'Tasks') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('main.project.show.card')}}"><?= get_label('information', 'Information') ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$taskData->name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- <div class="tab-content" id="myTabContent"> -->
                <div class="row g-0">
                    <div class="col-12 col-xxl-12 px-0 bg-white border-xxl border-top-sm">
                        <div class="px-4 px-lg-6 pt-6 pb-9">
                            <div class="mb-5">
                                <div class="d-flex justify-content-between">
                                    <h2 class="text-body-emphasis fw-bolder mb-2">{{ucfirst(Session::get('record_type'))}} {{$taskData->name}}</h2>
                                    <div class="btn-reveal-trigger">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="{{ route('main.project.edit', ['id'=>$taskData->id, 'source'=>'plist']) }}">Edit</a>
                                            <!-- <a class="dropdown-item text-danger" href="#!">Delete</a> -->
                                            <a class="dropdown-item" href="#!">Download</a>
                                            <!-- <a class="dropdown-item" href="{{ route('gantt') }}" target="_blank">Gantt</a> -->
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-phoenix badge-phoenix-{{$taskData->status->color}}">{{$taskData->status->title}}<span class="ms-1 uil uil-stopwatch"></span></span>
                                <span class="badge badge-phoenix badge-phoenix-{{$taskData->status->color}}">{{$taskData->department->name}}</span>
                                <!-- <span class="badge badge-phoenix badge-phoenix-warning">xxx<span class="ms-1 uil uil-money-bill"></span></span> -->
                            </div>
                            <div class="d-flex row gx-0 gx-sm-5 gy-8 mb-4">
                                <div class="flex-fill col-12 col-sm-auto">
                                    <table class="lh-sm mb-4 mb-sm-0 mb-xl-4">
                                        <tbody>
                                            <tr>
                                                <td class="align-top py-1">
                                                    <div class="d-flex"><span class="fa-solid fa-user me-2 text-body-tertiary fs-9"></span>
                                                        <h5 class="text-body mb-0 text-nowrap">Project :</h5>
                                                    </div>
                                                </td>
                                                <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="{{route('main.task.list', $taskData->event_id)}}">{{$taskData->project->name}}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="align-top py-1">
                                                    <div class="d-flex"><span class="fa-solid fa-user me-2 text-body-tertiary fs-9"></span>
                                                        <h5 class="text-body mb-0 text-nowrap">Department :</h5>
                                                    </div>
                                                </td>
                                                <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="#!">{{$taskData->department->name}}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="align-top py-1">
                                                    <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                        <h5 class="text-body mb-0 text-nowrap">Budget : </h5>
                                                    </div>
                                                </td>
                                                <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($taskData->budget_allocation)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="align-top py-1">
                                                    <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                        <h5 class="text-body mb-0 text-nowrap">Spent : </h5>
                                                    </div>
                                                </td>
                                                <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($taskData->actual_budget_allocated)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="align-top py-1">
                                                    <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                                                        <h5 class="text-body mb-0 text-nowrap">Remaining : </h5>
                                                    </div>
                                                </td>
                                                <td class="fw-bold ps-1 py-1 text-body-highlight">{{number_format($taskData->budget_allocation-$taskData->actual_budget_allocated)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex-fill col-12 col-sm-auto">
                                    <table class="lh-sm">
                                        <tbody>
                                            <tr>
                                                <td class="align-top py-1 text-body text-nowrap fw-bold">Started : </td>
                                                <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{\Carbon\Carbon::parse($taskData->start_date)->format('d-M-Y')}}</td>
                                            </tr>
                                            <tr>
                                                <td class="align-top py-1 text-body text-nowrap fw-bold">Deadline :</td>
                                                <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{\Carbon\Carbon::parse($taskData->end_date)->format('d-M-Y')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex mt-4">
                                        <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <div class="avatar avatar-xl  me-1">
                                                    <img class="rounded-circle " src="{{asset('assets/img//team/33.webp')}}" alt="" />
                                                </div>
                                            </a>
                                            <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                                <div class="position-relative">
                                                    <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                                    </div>
                                                    <!--/.bg-holder-->

                                                    <div class="p-3">
                                                        <div class="text-end">
                                                            <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                                            <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2">
                                                                <img class="rounded-circle border border-light-subtle" src="{{asset('assets/img//team/33.webp')}}" alt="" />
                                                            </div>
                                                            <h6 class="text-white">Tyrion Lannister</h6>
                                                            <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                                            <div class="d-flex flex-center mb-3">
                                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-body-emphasis">
                                                    <div class="p-3 border-bottom border-translucent">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                                                            </div>
                                                            <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                                                        </div>
                                                    </div>
                                                    <ul class="nav d-flex flex-column py-3 border-bottom">
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                                            </div>
                                        </div>
                                        <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <div class="avatar avatar-xl  me-1">
                                                    <img class="rounded-circle " src="{{asset('assets/img//team/30.webp')}}" alt="" />

                                                </div>
                                            </a>
                                            <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                                <div class="position-relative">
                                                    <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                                    </div>
                                                    <!--/.bg-holder-->

                                                    <div class="p-3">
                                                        <div class="text-end">
                                                            <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                                            <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="{{asset('assets/img//team/30.webp')}}" alt="" /></div>
                                                            <h6 class="text-white">Milind Mikuja</h6>
                                                            <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                                            <div class="d-flex flex-center mb-3">
                                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-body-emphasis">
                                                    <div class="p-3 border-bottom border-translucent">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                                                            </div>
                                                            <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                                                        </div>
                                                    </div>
                                                    <ul class="nav d-flex flex-column py-3 border-bottom">
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                                            </div>
                                        </div>
                                        <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <div class="avatar avatar-xl  me-1">
                                                    <img class="rounded-circle " src="{{asset('assets/img//team/31.webp')}}" alt="" />

                                                </div>
                                            </a>
                                            <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                                <div class="position-relative">
                                                    <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                                    </div>
                                                    <!--/.bg-holder-->

                                                    <div class="p-3">
                                                        <div class="text-end">
                                                            <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                                            <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="{{asset('assets/img//team/31.webp')}}" alt="" /></div>
                                                            <h6 class="text-white">Stanly Drinkwater</h6>
                                                            <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                                            <div class="d-flex flex-center mb-3">
                                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-body-emphasis">
                                                    <div class="p-3 border-bottom border-translucent">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                                                            </div>
                                                            <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                                                        </div>
                                                    </div>
                                                    <ul class="nav d-flex flex-column py-3 border-bottom">
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                                            </div>
                                        </div>
                                        <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <div class="avatar avatar-xl  me-1">
                                                    <img class="rounded-circle " src="{{asset('assets/img//team/60.webp')}}" alt="" />

                                                </div>
                                            </a>
                                            <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                                <div class="position-relative">
                                                    <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                                    </div>
                                                    <!--/.bg-holder-->

                                                    <div class="p-3">
                                                        <div class="text-end">
                                                            <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                                            <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="{{asset('assets/img//team/60.webp')}}" alt="" /></div>
                                                            <h6 class="text-white">Josef Stravinsky</h6>
                                                            <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                                            <div class="d-flex flex-center mb-3">
                                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-body-emphasis">
                                                    <div class="p-3 border-bottom border-translucent">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                                                            </div>
                                                            <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                                                        </div>
                                                    </div>
                                                    <ul class="nav d-flex flex-column py-3 border-bottom">
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                                            </div>
                                        </div>
                                        <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <div class="avatar avatar-xl  me-1">
                                                    <img class="rounded-circle " src="{{asset('assets/img//team/65.webp')}}" alt="" />

                                                </div>
                                            </a>
                                            <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                                <div class="position-relative">
                                                    <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                                    </div>
                                                    <!--/.bg-holder-->

                                                    <div class="p-3">
                                                        <div class="text-end">
                                                            <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                                            <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="{{asset('assets/img//team/65.webp')}}" alt="" /></div>
                                                            <h6 class="text-white">Igor Borvibson</h6>
                                                            <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                                            <div class="d-flex flex-center mb-3">
                                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-body-emphasis">
                                                    <div class="p-3 border-bottom border-translucent">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                                                            </div>
                                                            <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                                                        </div>
                                                    </div>
                                                    <ul class="nav d-flex flex-column py-3 border-bottom">
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                        <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <h4 class="text-body-emphasis mb-4">Tags</h4><span class="badge badge-tag me-2 mb-1">Unused_brain</span><span class="badge badge-tag me-2 mb-1">Machine</span><span class="badge badge-tag me-2 mb-1">Coding</span><span class="badge badge-tag me-2 mb-1">Meseeks</span><span class="badge badge-tag me-2 mb-1">Smithpeople</span><span class="badge badge-tag me-2 mb-1">Rick</span><span class="badge badge-tag me-2 mb-1">Biology</span><span class="badge badge-tag me-2 mb-1">Neurology</span><span class="badge badge-tag me-2 mb-1">Brainlessness</span><span class="badge badge-tag me-2 mb-1">Stupidity</span><span class="badge badge-tag me-2 mb-1">Jerry</span><span class="badge badge-tag me-2 mb-1">Not _the_mouse</span> -->
                                </div>
                                <div class="flex-fill col-12 col-sm-auto">
                                    <h4 class="text-body-emphasis"></h4><span class="badge badge-tag me-2 mb-1">Unused_brain</span><span class="badge badge-tag me-2 mb-1">Machine</span><span class="badge badge-tag me-2 mb-1">Coding</span><span class="badge badge-tag me-2 mb-1">Meseeks</span><span class="badge badge-tag me-2 mb-1">Smithpeople</span><span class="badge badge-tag me-2 mb-1">Rick</span><span class="badge badge-tag me-2 mb-1">Biology</span><span class="badge badge-tag me-2 mb-1">Neurology</span><span class="badge badge-tag me-2 mb-1">Brainlessness</span><span class="badge badge-tag me-2 mb-1">Stupidity</span><span class="badge badge-tag me-2 mb-1">Jerry</span><span class="badge badge-tag me-2 mb-1">Not _the_mouse</span>
                                </div>
                            </div>

                            <div class="border-bottom mb-5">
                                <h3 class="text-body-emphasis mb-3 mt-4">Description</h3>
                                <p class="text-body-secondary mb-4">{{strip_tags($taskData->description)}}</p>
                            </div>
                            <x-task-notes-card :tasks="$taskData" />
                            <x-task-files-card :tasks="$taskData" />


                            <!-- <p class="text-body-secondary mb-0">Join us in celebrating the massive success of data transferring and getting us a huge revenue by eating out. Free public viewing and a buffet is offered for the great team as well as for the other teams working with us. We’ll be checking out places for the best option available at hands and we’ll let you know the schedule once we decide on one.<a class="fw-semibold" href="#!">read more </a></p> -->
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        @endsection

        @push('script')


        @endpush

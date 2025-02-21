@extends('tracki.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->


<div class="content">
    <div class="mb-9">
        <h2 class="mb-4">Todo list<span class="text-body-tertiary fw-normal">(23)</span></h2>
        <div class="row align-items-center g-3 mb-3">
            <div class="col-sm-auto">
                <div class="search-box">
                    <form class="position-relative">
                        <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex"><a class="btn btn-link p-0 ms-sm-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span>23 tasks</a><a class="btn btn-link p-0 ms-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</a></div>
            </div>
        </div>
        <div class="mb-4 todo-list">
            @foreach ($todos as $key => $todo )
            @php
            $is_completed_flag = "";
                    $is_completed_flag = $todo->is_completed
                        ? "checked"
                        : "";
            @endphp
            <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 cursor-pointer border-top">
                <div class="col-12 col-md-auto flex-1">
                    <div>
                        <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                            <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" onclick="update_todo_status(this)" name="subtask-{{ $todo->id }}" id="{{ $todo->id }}" {{ $is_completed_flag }} >
                            <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 cursor-pointer" data-event-propagation-prevent="data-event-propagation-prevent" data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-1">{{$todo->title}}</label><span class="badge badge-phoenix fs-10 badge-phoenix-primary">{{$todo->priority->title}}</span>
                        </div>
                    </div>
                </div>

                <!-- Assignees -->
                <div class="col-12 col-md-auto d-flex">
                    @foreach($todo->users as $key => $asg)

                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <div class="avatar avatar-m  me-1">
                                <!-- <img class="rounded-circle " src="../../assets/img/team/60.webp" alt="" />{{ generateInitials($asg->name) }} -->
                                <div class="avatar-name rounded-circle me-2" title="{{ $asg->name }}"><span>{{ generateInitials($asg->name) }}</span></div>
                            </div>
                        </a>
                        <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                            <div class="position-relative">
                                <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                                </div>
                                <!--/.bg-holder-->

                                <div class="p-3">
                                    <div class="text-end">
                                        <!-- <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                                        <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button> -->
                                    </div>
                                    <div class="text-center">
                                        <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="../../assets/img/team/60.webp" alt="" /></div>
                                        <h6 class="text-white">{{ $asg->name }}</h6>
                                        <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">{{ $asg->email_address }}</p>
                                        <div class="d-flex flex-center mb-3">
                                            <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">tasks</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                                            <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">projects</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                        </div>
                    </div>
                    @endforeach
                    <button class="btn btn-sm btn-phoenix-secondary btn-circle"><span class="fa-solid fa-plus"></span></button>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="d-flex ms-4 lh-1 align-items-center">
                        <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>2</button>
                        <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0">{{format_date($todo->created_at, null,  'd M, Y')}}</p>
                        <div class="d-none d-md-block end-0 position-absolute" style="top: 23%;">
                            <div class="hover-actions end-0">
                                <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0" data-event-propagation-prevent="data-event-propagation-prevent"><span class="fas fa-edit"></span></button>
                                <a href="{{ route('tracki.todo.delete',$todo->id)}} " class="btn btn-sm  delete" id="delete">
                                                                <i class="fa-solid fa-trash" style="color: #f33061;"></i>
                                                            </a>
                                <!-- <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" id="delete" data-id="{{ $todo->id }}"><span class="fas fa-trash"></span></button> -->
                            </div>
                        </div>
                        <div class="hover-md-hide hover-lg-show hover-xl-hide">
                            <p class="text-body-tertiary fs-10 ps-md-3 border-start-md fw-bold mb-md-0 mb-0">{{format_date($todo->created_at, null,  'h:i A')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <a class="fw-bold fs-9 mt-4" href="#!" data-bs-toggle="modal" data-bs-target="#createTodoModal" id="addSubtask"><span class="fas fa-plus me-1"></span>Add new task</a>
    </div>
    <!-- </div> -->

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

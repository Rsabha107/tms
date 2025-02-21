@extends('main.task.layout.task-pdf-layout')
@section('main')


<!-- ***************************************************************************** */ -->
<div class="content">
    <div id="taskCardViewModal">
        <div class="modal-dialog px-6">
            <div class="modal-content overflow-hidden">

                <div class="modal-body p-5 px-md-2">
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
                                                        <div><span class="badge  bg-success me-2">Active</span>
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
                                        <button class="btn btn-link p-0"><span class="fa-solid fa-pen"></span></button>
                                    </div>
                                    <p class="text-body-highlight" id="overviewtaskDescription">The female circus horse-rider is a recurring subject in Chagall’s work. In 1926 the art dealer Ambroise Vollard invited Chagall to make a project based on the circus. They visited Paris’s historic Cirque d’Hiver Bouglione together; Vollard lent Chagall his private box seats. Chagall completed 19 gouaches...<a class="fw-semibold" href="#!">see more </a></p>
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
                                    <div class="mb-6">
                                        <div class="mb-7">
                                            <h4 class="mb-4">To do list <span class="text-body-tertiary fw-normal fs-2">(23)</span></h4>
                                            <div class="row align-items-center g-0 justify-content-between mb-3">
                                                <div class="col-12 col-sm-auto">
                                                    <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                                                        <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
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
                                            <div class="mb-3">
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-1">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-0" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-0">Designing the dungeon</label><span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-primary">DRAFT</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>2</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-2">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-1" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-1">Hiring a motion graphic designer</label><span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-warning">URGENT</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>2</button>
                                                            <button class="btn p-0 text-warning fs-10 me-2"><span class="fas fa-tasks me-1"></span>3</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-3">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-2" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-2">Daily Meetings Purpose, participants</label><span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-info">ON PROCESS</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>4</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Dec, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">05:00 AM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-4">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-3" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-3">Finalizing the geometric shapes</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>3</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-5">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-4" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-4">Daily meeting with team members</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">1 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-6">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-5" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-5">Daily Standup Meetings</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">13 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">10:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-7">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-6" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-6">Procrastinate for a month</label><span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-info">ON PROCESS</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>3</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-8">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-7" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-7">warming up</label><span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-info">CLOSE</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>3</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">12 Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">12:00 PM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top border-bottom">
                                                    <div class="col-12">
                                                        <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-9">
                                                            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                                                                <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-8" />
                                                                <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-8">Make ready for release</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex ms-4 lh-1 align-items-center">
                                                            <button class="btn p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>2</button>
                                                            <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">2o Nov, 2021</p>
                                                            <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">1:00 AM</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><a class="fw-bold fs-9 mt-4" href="#!"><span class="fas fa-plus me-1"></span>Add new task</a>
                                        </div>
                                    </div>
                                    <h4 class="mb-3">Files</h4>
                                    <div class="border-top pt-3 pb-4">
                                        <div class="me-n3">
                                            <div class="d-flex flex-between-center">
                                                <div class="d-flex mb-1"><span class="fa-solid fa-image me-2 text-body-tertiary fs-9"></span>
                                                    <p class="text-body-highlight mb-0 lh-1">Silly_sight_1.png</p>
                                                </div>
                                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                            </div>
                                            <p class="fs-9 text-body-tertiary mb-2"><span>768 kb</span><span class="text-body-quaternary mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">21st Dec, 12:56 PM</span></p><img class="rounded-2" src="../../assets/img/generic/40.png" alt="" />
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
</div>
@endsection

@push('script')


@include('main.partials.event-js')
@endpush

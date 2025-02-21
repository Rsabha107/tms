@extends('main.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between m-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('main.project.show.card')}}"><?= get_label('projects', 'Projects') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('tasks', 'Tasks') ?>
                        </li>

                    </ol>
                </nav>
            </div>
            <div>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_tag_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_tag', 'Create tag') ?>"><i class="bx bx-plus"></i></button></a>
            </div>
        </div>
        <x-tasks-card :persons="$persons" :projects="$projects" :statuses="$statuses" />
    </div>
    <div class="modal fade" id="taskStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Status</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ route('main.task.status.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <input type="hidden" id="editTaskId" name="id">
                                    <input type="hidden" id="editTaskEventId" name="event_id">
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

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- add event modal 1-->
    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">Launch demo modal 2</button> -->



    @endsection

    @push('script')


    @include('main.partials.event-js')

    @endpush

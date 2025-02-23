<!-- Modals for Status models -->
@if ((Request::is('main/project/*') || Request::is('main/users/create-new') || Request::is('main/task/*/list')) && !Request::is('main/project/archive'))
<div class="modal fade" id="add_edit_project_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel"><?= get_label('create_status', 'Create status') ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation form-submit-event" id="create_status_form" novalidate="" action="{{ route('main.setup.status.store') }}" method="POST">
                @csrf

                <input type="hidden" name="table" value="status_table">

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="status_title" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="addTitle" class="form-control" name="title" required placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                            <select class="form-select" id="color" name="color">
                                <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= get_label('close', 'Close') ?></label></button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>
@end if

@if ((Request::is('xxxmain/project/*') || Request::is('xxxmain/users/create-new') || Request::is('xxxmain/task/*/list')) && !Request::is('xxxmain/project/archive'))
<div class="offcanvas offcanvas-start w-50" id="offcanvasAddEditProject" tabindex="-1" aria-labelledby="offcanvasWithBackdropLabel">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="add_edit_project_modal_label">Create new project</h5>
        <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <?php
        $workspace_id = session()->get('workspace_id');
        $is_workspace_id_set = ($workspace_id) ? true : false;
        ?>
        <!-- <h4 class="mb-3">Information </h4> -->
        <form class="row g-3 needs-validation form-submit-event" id="add_edit_project_form" novalidate="" action="{{ route ('main.project.create') }}" method="POST">
            @csrf

            <input type="hidden" name="id" id="add_edit_project_id_h" value="">
            <input type="hidden" name="table" id="add_edit_project_table_h" value="task_table">
            <input type="hidden" name="redirect" id="add_edit_project_redirect_h" value="">

            @if (!$is_workspace_id_set)
            <div class="col-12">
                <!-- <label class="form-label" for="inputAddress">Workspace</label> -->
                <label class="col-sm-2 col-form-label col-form-label-sm" for="colFormLabelSm">Workspace</label>
                <select name="workspace_id" class="form-select" id="add_edit_project_workspace_id" required style="background-color: #ADC5FF;">
                    <option selected="selected" value="">Select...</option>
                    @foreach ($workspaces as $key => $item )
                    <option value="{{ $item->id  }}">
                        {{ $item->title }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-12 gy-6">
                <div class="form-floating form-floating-advance-select">
                  <label>Add tags</label>
                  <select class="form-select" id="organizerMultiple" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option selected="selected">Stupidity</option>
                    <option>Jerry</option>
                    <option>Not_the_mouse</option>
                    <option>Brainlessness</option>
                  </select>
                </div>
              </div>
            <div class="col-12 gy-6">
                <label for="organizerMultiple">Multiple</label>
                <select class="form-select" id="organizerMultiple" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Select organizer...</option>
                    <option>Massachusetts Institute of Technology</option>
                    <option>University of Chicago</option>
                    <option>GSAS Open Labs At Harvard</option>
                    <option>California Institute of Technology</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inputEmail4">Title</label>
                <input name="name" id="add_edit_project_name" class="form-control" type="text" placeholder="" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="inputAddress2">Tags (multiple)</label>

                <select required class="form-select js-example-basic-multiple" id="add_edit_project_tag" name="tag_id[]" multiple="multiple" data-with="100%" data-placeholder="<?= get_label('Tags', 'Tags') ?>">
                    <!-- <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required> -->
                    <option value="">Select tag</option>
                    @foreach ($tags as $key => $item )
                    <option value="{{ $item->id  }}">
                        {{ $item->title }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Project type</label>
                <select name="project_type_id" class="form-select" id="add_edit_project_project_type" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($project_type as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Category</label>
                <select name="category_id" class="form-select" id="add_edit_project_category" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($event_category as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Audience</label>
                <select name="audience_id" class="form-select" id="add_edit_project_audience" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($event_audience as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Client</label>
                <select name="client_id" class="form-select" id="add_edit_project_client" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($clients as $key => $item )
                    <option value="{{ $item->id  }}">
                        {{ $item->first_name.' '.$item->last_name}}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Venue</label>
                <select name="venue_id" class="form-select" id="add_edit_project_venue" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($event_venue as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Location</label>
                <select name="location_id" class="form-select" id="add_edit_project_location" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($event_location as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Fund</label>
                <select name="fund_category_id" class="form-select" id="add_edit_project_fund" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($fund_category as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="inputAddress">Budget</label>
                <select name="budget_name_id" class="form-select" id="add_edit_project_budget" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($budget_name as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>



            <!-- <h4 class="mt-6">Schedule</h4> -->
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">Start Date</label>
                <input class="form-control datetimepicker" id="add_edit_project_start_date" data-target="#floatingInputStartDate" name="start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">End Date</label>
                <input class="form-control datetimepicker" id="add_edit_project_end_date" data-target="#floatingInputStartDate" name="end_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>

            <!-- <h4 class="mt-6">Other Information</h4> -->

            <div class="col-md-6">
                <label class="form-label" for="inputCity">Budget allocated</label>
                <input name="budget_allocation" class="form-control" id="add_edit_project_budget_allocation" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputState">Attendance forcast</label>
                <input name="attendance_forcast" class="form-control" id="add_edit_project_attendance" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="gridCheck">Description</label>
                <textarea required name="description" class="form-control tinymce" id="add_edit_project_description" data-tinymce="{}" placeholder=""></textarea>
            </div>
            <div class="col-12 d-flex justify-content-end mt-6">
                <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save" id="submit_btn">Save</button>
                <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                <!-- <a class="btn btn-phoenix-danger me-2 px-6" href="#">Cancel</a> -->
                <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
            </div>
        </form>

    </div>
</div>
@endif

@if (Request::is('main/setup/status/*'))
<div class="modal fade" id="create_status_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel"><?= get_label('create_status', 'Create status') ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation form-submit-event" id="create_status_form" novalidate="" action="{{ route('main.setup.status.store') }}" method="POST">
                @csrf

                <input type="hidden" name="table" value="status_table">

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="status_title" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="addTitle" class="form-control" name="title" required placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                            <select class="form-select" id="color" name="color">
                                <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= get_label('close', 'Close') ?></label></button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_status_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel">Edit</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation form-submit-event" id="edit_status_form" novalidate="" action="{{ route('main.setup.status.update') }}" method="POST">
                @csrf

                <input type="hidden" id="status_id" name="id" value="">
                <input type="hidden" id="edit_status_table" name="table" value="">

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="status_title" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="status_title" class="form-control" name="title" required placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                            <select class="form-select" id="status_color" name="color">
                                <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                            </select>
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
@endif

@if (Request::is('main/setup/priority/*'))
<div class="modal fade" id="create_priority_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel"><?= get_label('create_priority', 'Create priority') ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation form-submit-event" id="create_priority_form" novalidate="" action="{{ route('main.setup.priority.store') }}" method="POST">
                @csrf

                <input type="hidden" name="table" value="priority_table">

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="priority_title" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="addTitle" class="form-control" name="title" required placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                            <select class="form-select" id="color" name="color">
                                <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= get_label('close', 'Close') ?></label></button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_priority_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel">Edit</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation form-submit-event" id="edit_priority_form" novalidate="" action="{{ route('main.setup.priority.update') }}" method="POST">
                @csrf

                <input type="hidden" id="priority_id" name="id" value="">
                <input type="hidden" id="edit_priority_table" name="table" value="">

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="priority_title" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="priority_title" class="form-control" name="title" required placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                            <select class="form-select" id="priority_color" name="color">
                                <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                                <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                            </select>
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
@endif

@if (Request::is('home') || Request::is('todos'))
<div class="modal fade" id="create_todo_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/todos/store')}}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_todo', 'Create todo') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('priority', 'Priority') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" name="priority">
                            <option value="low" {{ old('priority') == "low" ? "selected" : "" }}><?= get_label('low', 'Low') ?></option>
                            <option value="medium" {{ old('priority') == "medium" ? "selected" : "" }}><?= get_label('medium', 'Medium') ?></option>
                            <option value="high" {{ old('priority') == "high" ? "selected" : "" }}><?= get_label('high', 'High') ?></option>
                        </select>
                    </div>
                </div>
                <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_todo_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('/todos/update')}}" class="modal-content form-submit-event" method="POST">
            <input type="hidden" name="id" id="todo_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_todo', 'Update todo') ?></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="todo_title" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('priority', 'Priority') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="todo_priority" name="priority">
                            <option value="low"><?= get_label('low', 'Low') ?></option>
                            <option value="medium"><?= get_label('medium', 'Medium') ?></option>
                            <option value="high"><?= get_label('high', 'High') ?></option>
                        </select>
                    </div>
                </div>
                <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                <textarea class="form-control" id="todo_description" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></span></button>
            </div>
        </form>
    </div>
</div>
@endif

@if (Request::is('main/setup/tags'))
<!-- tags modal -->
<div class="modal fade" id="create_tags_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form novalidate="" class="modal-content form-submit-event needs-validation" id="form_submit_event" action="{{route('main.setup.tags.store')}}" method="POST">
            <input type="hidden" name="table" value="tags_table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_tags', 'Create tags') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="nameBasic" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <input required type="color" value="#d6fafc" id="tags_color" name="color" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select required class="form-select" id="color" name="color">
                            <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_tags_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form novalidate="" class="modal-content form-submit-event needs-validation" id="edit_form_submit_event" action="{{route('main.setup.tags.update')}}" method="POST">
            <input type="hidden" id="edit_tags_id" name="id" value="">
            <input type="hidden" id="edit_tags_table" name="table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('edit_tags', 'Edit tags') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="edit_tags_title" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <input required type="color" id="edit_tags_color" name="color" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="tags_color" name="color">
                            <option class="badge badge-phoenix badge-phoenix-primary" value="primary"><?= get_label('primary', 'Primary') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-success" value="success"><?= get_label('success', 'Success') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-info" value="info"><?= get_label('info', 'Info') ?></option>
                            <option class="badge badge-phoenix badge-phoenix-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>
@endif

@if (Request::is('main/setup/workspace'))
<!-- workspace modal -->
<div class="modal fade" id="create_workspace_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form novalidate="" class="modal-content form-submit-event needs-validation" id="form_submit_event" action="{{route('main.setup.workspace.store')}}" method="POST">
            <input type="hidden" name="table" value="workspace_table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_workspace', 'Create workspace') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="nameBasic" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>

                <div class="row">

                    <div class="col-12">
                        <label class="form-label" for="inputAddress2">Assigned to</label>
                        <select class="form-select js-example-basic-multiple" name="assigned_to_id[]" multiple="multiple" data-with="100%" data-placeholder="<?= get_label('type_to_search', 'Type to search') ?>">
                            <!-- <select name="assigned_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required> -->
                            <option value="">Select Assinged to</option>
                            @foreach ($users as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 gy-6">
              </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_workspace_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form novalidate="" class="modal-content form-submit-event needs-validation" id="form_submit_event" action="{{route('main.setup.workspace.update')}}" method="POST">
            <input type="hidden" name="table" value="workspace_table">
            <input type="hidden" id="id" name="id" value="">
            <input type="hidden" id="table" name="table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('edit_workspace', 'Edit workspace') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="editWsTitle" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <label class="form-label" for="user_id"><?= get_label('select_users', 'Select users') ?> <span id="task_update_users_associated_with_project"></span></label>
                        <select id="editWsAsgToId" class="form-select js-example-basic-multiple" name="assigned_to_id[]" multiple="multiple" data-placeholder="<?= get_label('type_to_search', 'Type to search') ?>">
                            <option value="">Select Assinged to</option>
                            @foreach ($users as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>
@endif

@if (Request::is('main/todo/manage'))
<div class="modal fade" id="createTodoModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Create Todo</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation" novalidate="" form-submit-eventx" id="add_new_todo" action="{{ route('main.todo.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <!-- <input type="hidden" name="parent_task_id" id="subtask_parent_task_id" value=""> -->
                                <!-- <input type="hidden" name="table" value="task_table"> -->

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="inputEmail4">Title</label>
                                    <input name="title" class="form-control" type="text" placeholder="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="inputAddress2">Assigned to</label>
                                    <select name="assigned_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required>
                                        <option value="">Select Assinged to</option>
                                        @foreach ($users as $key => $item )
                                        @if (Request::old('id') == $item->id )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->name }}
                                        </option>
                                        @else
                                        <option value="{{ $item->id  }}">
                                            {{ $item->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="inputAddress">Priority</label>
                                    <select name="priority_id" class="form-select" id="floatingSelectRating" required>
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($priorities as $key => $item )
                                        @if (Request::old('id') == $item->id )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->title }}
                                        </option>
                                        @else
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="gridCheck">Description</label>
                                    <textarea required name="description" class="form-control" id="floatingProjectOverview" data-tinymce="{}" placeholder=""></textarea>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-6">
                                    <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save" id="submit_btn">Save</button>
                                    <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                                    <a class="btn btn-phoenix-danger me-2 px-6" href="#" data-bs-dismiss="modal">Cancel</a>
                                    <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endif

@if (Request::is('main/task/*/list') || Request::is('main/task/manage') || Request::is('main/task/*/edit')||Request::is('main/todo/manage'))
<!-- this is the Add Attachement Modal for tasks -->
<div class="modal fade" id="addAttachementTaskModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Upload Task File</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" id="add_new_task_file" novalidate="" action="{{ route('main.task.file.store') }}" method="POST" enctype='multipart/form-data'>
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" id="taskAttachId" name="task_id">
                                <input type="hidden" id="taskAttachParentTable" name="table">
                                <div class="mb-4">
                                    <label class="text-1000 fw-bold mb-2">Name</label>
                                    <input class="form-control" type="file" name="file_name" id="fileupld" required />
                                </div>
                                <div class="form-group">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
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
@endif

@if (Request::is('main/task/*/list') || Request::is('main/task/manage') || Request::is('main/task/*/edit'))

<!-- this is the Add task Notes Modal -->
<div class="modal fade" id="addTaskNoteModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Add task note</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" id="add_new_task_note" novalidate="" action="{{ route('main.task.note.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" id="taskNoteId" name="task_id" value="">
                                <input type="hidden" id="taskNoteParentTable" name="table">
                                <div class="mb-4">
                                    <label class="text-1000 fw-bold mb-2">Note</label>
                                    <textarea class="form-control mb-3" id="task_note" name="note_text" rows="4" required> </textarea>

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

<!-- Modals for change status in project and task -->
<div class="modal fade" id="taskStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Status</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" novalidate="" action="{{route('main.task.status.update')}}" method="POST" id="task_status">
                <!-- <form class="needs-validation" novalidate="" action="{{url('/main/task/status/update')}}" method="POST" id="task_status"> -->
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
                                            {{ $item->title }}
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


<!--add edit task used in list and manage -->
<div class="offcanvas offcanvas-start" id="offcanvasAddEditTask" tabindex="-1" aria-labelledby="offcanvasWithBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="add_edit_task_modal_label">Edit task for ( )</h5>
        <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <form class="row g-3 needs-validation form-submit-event" id="add_edit_task_form" novalidate="" action="" method="POST">
            @csrf
            <input type="hidden" id="add_edit_task_id_h" name="id" value="">
            <input type="hidden" id="add_edit_task_table_h" name="table" value="">

            <div class="col-md-12">
                <label class="form-label" for="inputEmail4">Title</label>
                <input name="name" id="add_edit_task_name" class="form-control" type="text" placeholder="" required>
            </div>
            @if (Request::is('main/task/manage'))
            <div class="col-12">
                <label class="form-label" for="inputAddress">Project</label>
                <select name="event_id" id="add_edit_task_event_id" class="form-select" id="floatingSelectRating" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($projects as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            @elseif (Request::is('main/task/*/list'))
            <input type="hidden" id="add_edit_task_event_id" name="event_id" value="">
            @endif
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">Start Date</label>
                <input class="form-control datetimepicker" id="add_edit_task_start_date" data-target="#floatingInputStartDate" name="start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">Due Date</label>
                <input class="form-control datetimepicker" id="add_edit_task_due_date" data-target="#floatingInputStartDate" name="due_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>

            <div class="col-6">
                <label class="form-label" for="inputAddress">Status</label>
                <select name="status_id" class="form-select" id="add_edit_task_status" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($statuses as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->title }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->title }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-6">
                <label class="form-label" for="inputAddress">Department</label>
                <select name="department_assignment_id" id="add_edit_task_department_id" class="form-select" id="floatingSelectRating" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($departments as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label" for="inputAddress2">Assigned to (multiple)</label>

                <select required class="form-select js-example-basic-multiple" id="add_edit_task_assigned_to" name="assignment_to_id[]" multiple="multiple" data-with="100%" data-placeholder="<?= get_label('type_to_search', 'Type to search') ?>">
                    <!-- <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required> -->
                    <option value="">Select Assinged to</option>
                    @foreach ($users as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="inputCity">Budget allocated</label>
                <input name="budget_allocation" class="form-control" id="add_edit_task_budget" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputState">Actual budget utilized</label>
                <input name="actual_budget_allocated" class="form-control" id="add_edit_task_budget_utilization" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="gridCheck">Description</label>
                <textarea required name="description" class="form-control tinymce" id="add_edit_task_description" data-tinymce="{}" placeholder=""></textarea>
            </div>
            <div class="col-12 d-flex justify-content-end mt-6">
                <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save" id="submit_btn">Save</button>
                <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                <!-- <a class="btn btn-phoenix-danger me-2 px-6" href="#">Cancel</a> -->
                <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
            </div>
        </form>

    </div>
</div>
<!-- </div> -->

<!-- add new task used in list and manage -->
<div class="offcanvas offcanvas-start" id="offcanvasCreateSubTask" tabindex="-1" aria-labelledby="offcanvasWithBackdropLabel">
    @if (Request::is('main/task/*/list'))
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Create subtask for {{Session::get('record_type')}} ( {{$eventData->name}} )</h5>
        <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    @elseif (Request::is('main/task/manage'))
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Create new task</h5>
        <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    @endif
    <div class="offcanvas-body">

        <form class="row g-3 needs-validation form-submit-event" id="add_new_task" novalidate="" action="{{ route('main.task.subtask.store') }}" method="POST">
            @csrf
            @if (Request::is('main/task/*/list'))
            <input type="hidden" name="event_id" value="{{ $eventData->id }}">
            @endif
            <input type="hidden" name="table" value="task_table">

            <div class="col-md-12">
                <label class="form-label" for="inputEmail4">Title</label>
                <input name="name" class="form-control" type="text" placeholder="" required>
            </div>
            @if (Request::is('main/task/manage'))
            <div class="col-12">
                <label class="form-label" for="inputAddress">Project</label>
                <select name="event_id" class="form-select" id="floatingSelectRating" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($projects as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">Start Date</label>
                <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputEmail4">Due Date</label>
                <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="due_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
            </div>

            <div class="col-6">
                <label class="form-label" for="inputAddress">Status</label>
                <select name="status_id" class="form-select" id="floatingSelectRating" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($statuses as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->title }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->title }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-6">
                <label class="form-label" for="inputAddress">Department</label>
                <select name="department_assignment_id" class="form-select" id="floatingSelectRating" required>
                    <option selected="selected" value="">Select...</option>
                    @foreach ($departments as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label" for="inputAddress2">Assigned to</label>
                <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required>
                    <option value="">Select Assinged to</option>
                    @foreach ($users as $key => $item )
                    @if (Request::old('id') == $item->id )
                    <option value="{{ $item->id  }}" selected>
                        {{ $item->name }}
                    </option>
                    @else
                    <option value="{{ $item->id  }}">
                        {{ $item->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="inputCity">Budget allocated</label>
                <input name="budget_allocation" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputState">Actual budget utilized</label>
                <input name="actual_budget_allocated" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="" value="0" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="gridCheck">Description</label>
                <textarea required name="description" class="form-control tinymce" id="floatingProjectOverview" data-tinymce="{}" placeholder=""></textarea>
            </div>
            <div class="col-12 d-flex justify-content-end mt-6">
                <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save" id="submit_btn">Save</button>
                <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                <a class="btn btn-phoenix-danger me-2 px-6" href="#">Cancel</a>
                <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
            </div>
        </form>

    </div>
</div>

<!-- Subtask modal -->
<div class="modal fade" id="createSubTaskModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Create subtask</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" id="add_new_subtasktask" novalidate="" action="{{ route('main.task.subtask.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" name="parent_task_id" id="subtask_parent_task_id" value="">
                                <input type="hidden" name="table" value="task_table">

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="inputEmail4">Title</label>
                                    <input name="title" class="form-control" type="text" placeholder="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="inputAddress">Status</label>
                                    <select name="priority_id" class="form-select" id="floatingSelectRating" required>
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($priorities as $key => $item )
                                        @if (Request::old('id') == $item->id )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->title }}
                                        </option>
                                        @else
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="gridCheck">Description</label>
                                    <textarea required name="description" class="form-control" id="floatingProjectOverview" data-tinymce="{}" placeholder=""></textarea>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-6">
                                    <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save" id="submit_btn">Save</button>
                                    <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                                    <a class="btn btn-phoenix-danger me-2 px-6" href="#" data-bs-dismiss="modal">Cancel</a>
                                    <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- The main Task overview ***************************************************************************************************-->
<div class="modal fade" id="taskCardViewModal" tabindex="-1" aria-labelledby="taskCardViewModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content overflow-hidden">
            <div class="modal-header position-relative p-0">
                <h5 class="modal-title ms-3">Task quick view</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 px-md-6">
                <div class="row g-5">
                    <div class="col-12 col-md-9">
                        <div class="mb-4">
                            <h3 class="fw-bolder lh-sm" id="overviewtaskTitle">...</h3>
                            <p class="text-body-highlight fw-semibold mb-0">
                            <div id="overviewtaskStatus">
                            </div>
                            </p>
                        </div>
                        <h6 class="text-body-secondary mb-2">Project Name</h6>
                        <div class="text-body-highlight mb-3" id="overviewProjectName">
                        </div>
                        <div class="mb-3">
                            <h6 class="text-body-secondary mb-2">Assigness</h6>
                            <div class="d-flex">
                                <p id="overviewtaskAssignees" class="d-flex"></p>
                                <button class="btn btn-sm btn-phoenix-secondary btn-circle"><span class="fa-solid fa-plus"></span></button>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h6 class="text-body-secondary mb-2">Labels</h6>
                            <div class="d-flex align-items-center"><span class="badge badge-phoenix badge-phoenix-info fs-10 me-2">INFO</span><span class="badge badge-phoenix badge-phoenix-warning fs-10 me-2">URGENT</span><span class="badge badge-phoenix badge-phoenix-success fs-10 me-2">DONE</span><a class="text-body fw-bolder fs-9 lh-1 text-decoration-none" href="#!"> <span class="fa-solid fa-plus me-1"></span>Add another</a></div>
                        </div>
                        <div class="mb-6">
                            <div class="d-flex align-items-center mb-2">
                                <h4 class="me-3">Description</h4>
                                <a href="#"><button class="btn btn-link p-0"><span class="fa-solid fa-pen"></span></button></a>
                            </div>
                            <p class="text-body-highlight" id="overviewtaskDescription"> ...<a class="fw-semibold" href="#!">see more </a></p>
                        </div>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item border-top">
                                <h2 class="accordion-header" id="headingOne">

                                    <button id="noteCount" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Comments/Notes

                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body pt-0">
                                        <div class="bg-body-highlight rounded-2 p-4 mb-6">
                                            <div id="taskTabNotes"></div>
                                        </div>
                                        <div id="add_new_task_note"></div>
                                        <form class="needs-validation form-submit-task-new-note" novalidate="" action="{{ route('main.task.note.store') }}" method="POST" id="form_submit_task_new_note">
                                            @csrf
                                            <input type="hidden" id="note_parent_task_id_overview" name="task_id">
                                            <input type="hidden" id="taskNoteParentTable" name="table" value="task_table">
                                            <textarea class="form-control form-control mb-3" data-tinymce="{}" rows="3" id="task_note_text" name="note_text" placeholder="Add comment" required></textarea>
                                            <div class="d-flex flex-between-center pb-3 border-bottom border-translucent mb-6">
                                                <div class="d-flex">
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary px-6" type="submit" id="add_comment_btn">Save comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">

                                    <button id="subTaskCount" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subTaskCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                        Subtasks</span>

                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="subTaskCollapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body pt-0">
                                        <div class="mb-3">
                                            <!-- <h4 class="mb-4">Check list <span class="text-body-tertiary fw-normal fs-6">(23)</span></h4> -->
                                            <div class="mb-3">
                                                <div id="taskTabSubtasks"></div>
                                            </div>
                                            <a class="fw-bold fs-9 mt-6" href="#!" id="add_subtask_btn"><span class="fas fa-plus me-1"></span>Add new subtask</a>
                                            <div class="card border border-primary" style="display:none" id="add_subtask_block">
                                                <div class="card-body">
                                                    <!-- <h4 class="card-title text-dark">Upload file </h4> -->
                                                    <form class="needs-validation form-submit-task-new-subtask" id="form_submit_task_new_subtask" novalidate="" action="{{ route('main.task.subtask.store') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="modal-body px-0">
                                                                <div class="row g-4">
                                                                    <div class="col-lg-12">
                                                                        <input type="hidden" name="parent_task_id" id="subtask_parent_task_id_overview" value="">
                                                                        <input type="hidden" name="table" value="task_table">

                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label" for="inputEmail4">Title</label>
                                                                            <input name="title" class="form-control" type="text" placeholder="" required>
                                                                        </div>
                                                                        <div class="col-12 mb-3">
                                                                            <label class="form-label" for="inputAddress">Priority</label>
                                                                            <select name="priority_id" class="form-select" id="floatingSelectRating" required>
                                                                                <option selected="selected" value="">Select...</option>
                                                                                @foreach ($priorities as $key => $item )
                                                                                @if (Request::old('id') == $item->id )
                                                                                <option value="{{ $item->id  }}" selected>
                                                                                    {{ $item->title }}
                                                                                </option>
                                                                                @else
                                                                                <option value="{{ $item->id  }}">
                                                                                    {{ $item->title }}
                                                                                </option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label class="form-label" for="gridCheck">Description</label>
                                                                            <textarea required name="description" class="form-control" id="floatingProjectOverview" data-tinymce="{}" placeholder=""></textarea>
                                                                        </div>
                                                                        <div class="col-12 d-flex justify-content-end mt-6">
                                                                            <button class="btn btn-sm btn-outline-primary px-6 action button-submit" type="submit" value="save" id="add_subtask_btn">Save</button>
                                                                            <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                                                                            <!-- <a class="btn btn-phoenix-danger me-2 px-6" href="#" data-bs-dismiss="modal">Cancel</a> -->
                                                                            <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">

                                    <button id="fileCount" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#taskFileCollapse" aria-expanded="false" aria-controls="collapseThree">
                                        Files

                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="taskFileCollapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body pt-0">
                                        <div id="taskTabFiles"></div>
                                        <a class="fw-bold fs-9 mt-6" id="add_file_btn" href="#!"><span class="fas fa-plus me-1"></span>Add file(s)</a>
                                        <div class="card border border-primary" style="display:none" id="upload_file_block">
                                            <div class="card-body">
                                                <!-- <h4 class="card-title text-dark">Upload file </h4> -->
                                                <form id="form_submit_task_new_file" class="needs-validation form-submit-task-new-file" novalidate="" action="{{ route('main.task.file.store') }}" method="POST" enctype='multipart/form-data'>
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="modal-body px-0">
                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <input type="hidden" id="file_parent_task_id_overview" name="task_id">
                                                                    <input type="hidden" id="task_parent_table" name="table" value="task_table">
                                                                    <div class="mb-4">
                                                                        <label class="text-1000 fw-bold mb-2">upload file</label>
                                                                        <input class="form-control" type="file" name="file_name" id="fileupld" required />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="progress">
                                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-outline-primary px-6" type="submit" id="add_file_btn">Upload file</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-3">
                        <h5 class="text-body-secondary mb-3"></h5>
                        <div class="mb-6">
                            <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Start Date" id="overviewtaskStartDate"><span class="me-2 fa-solid fa-calendar-days"></span>Dates</button>
                            <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Due Date" id="overviewtaskDueDate"><span class="me-2 fa-solid fa-calendar-days"></span>Dates</button>
                            <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Department" id="overviewtaskDepartment"><span class="me-2 fa-solid fa-user-plus"></span>Assignee</button>
                            <!-- <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fa-tag"></span>Labels</button> -->
                            <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Budget Allocated" id="overviewtaskAllocatedBudget"><span class="me-2 fa-solid fa-dollar"></span>budget</button>
                            <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Department" id="overviewtaskActualBudget"><span class="me-2 fa-solid fa-donate"></span>actual budget</button>
                            <!-- <button class="btn btn-sm btn-subtle-secondary rounded-3 mb-2 d-flex align-items-center w-100"><span class="me-2 fa-solid fa-square-check"></span>Checklist</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

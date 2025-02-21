<script src="{{ asset ('assets/tracki/js/phoenix.js') }}"></script>
<script src="{{ asset ('assets/js/pages/tasks.js') }}"></script>



<input type="hidden" id="edit_task_id_h" name="id" value="{{$task->id}}">
<input type="hidden" id="edit_task_table_h" name="table" value="task_table">
<input type="hidden" id="edit_task_event_id" name="event_id" value="{{$task->event_id}}">

<div class="modal-body">
    <div class="mb-3 col-md-12">
        <label class="form-label" for="inputEmail4">Title</label>
        <input name="name" id="edit_task_name" class="form-control" value="{{$task->name}}" type="text" placeholder="" required>
    </div>
    <div class="mb-3 row">

        <div class="col-md-6">
            <label class="form-label" for="inputEmail4">Start Date</label>
            <input class="form-control datetimepicker" id="edit_task_start_date" data-target="#floatingInputStartDate" name="start_date"  type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputEmail4">Due Date</label>
            <input class="form-control datetimepicker" id="edit_task_due_date" data-target="#floatingInputStartDate" name="due_date" type="date" placeholder="dd/mm/yyyy"  placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Status</label>
            <select name="status_id" class="form-select" id="edit_task_status" required>
                <option selected="selected" value="">Select...</option>
                @foreach ($statuses as $key => $item )
                @if ($task->status_id == $item->id )
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
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Department</label>
            <select name="department_assignment_id" id="edit_task_department_id" class="form-select" id="floatingSelectRating" required>
                <option selected="selected" value="">Select...</option>
                @foreach ($departments as $key => $item )
                @if ($task->department_assignment_id == $item->id )
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
    </div>
    <div class="col-12 mb-2">
        <label class="form-label" for="inputAddress2">Assigned to (multiple)</label>

        <select required class="form-select js-example-basic-multiple" id="edit_task_assigned_to" name="assignment_to_id[]" multiple="multiple" data-with="100%" data-placeholder="<?= get_label('type_to_search', 'Type to search') ?>">
            <!-- <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required> -->

        </select>
    </div>
    <div class="mb-3 row">

        <div class="col-md-6">
            <label class="form-label" for="inputCity">Budget allocated</label>
            <input name="budget_allocation" class="form-control" id="edit_task_budget" type="number" step="0.01" placeholder="" value="{{$task->budget_allocation}}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputState">Actual budget utilized</label>
            <input name="actual_budget_allocated" class="form-control" id="edit_task_budget_utilization" type="number" step="0.01" placeholder="" value="{{$task->actual_budget_allocated}}" required>
        </div>
    </div>
    <!-- <h4 class="mt-6">Other Information</h4> -->

    <div class="col-12">
        <label class="form-label" for="gridCheck">Description</label>
        <textarea style="height: 200px;" required name="description" class="form-control tinymce" id="edit_task_description" value="{{$task->description}}"  data-tinymce="{}" placeholder=""></textarea>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= get_label('close', 'Close') ?></label></button>
    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('save', 'Save') ?></label></button>
</div>

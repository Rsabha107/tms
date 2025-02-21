<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}

            <div class="row mt-4 mx-2">
                <div class="mb-3 col-md-3">
                    <div class="input-group input-group-merge">
                        <input type="text" id="task_start_date_between" name="task_start_date_between" class="form-control" placeholder="<?= get_label('start_date_between', 'Start date between') ?>" autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 col-md-3">
                    <div class="input-group input-group-merge">
                        <input type="text" id="task_end_date_between" name="task_end_date_between" class="form-control" placeholder="<?= get_label('end_date_between', 'End date between') ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="tasks_project_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_project', 'Select project') ?></option>
                        @foreach ($projects as $proj)
                        <option value="{{$proj->id}}" @if(request()->has('project') && request()->project == $proj->id) selected @endif>{{$proj->name}}</option>
                        @endforeach
                    </select>

                </div>


                <div class="col-md-3">
                    <select class="form-select" id="tasks_person_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_person', 'Select person') ?></option>
                        @foreach ($persons as $person)
                        <option value="{{$person->id}}">{{$person->name}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3">
                    <select class="form-select" id="task_status_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_status', 'Select status') ?></option>
                        @foreach ($statuses as $status)
                        @php
                        $selected = (request()->has('status') && request()->status == $status->id) ? 'selected' : '';
                        @endphp
                        <option value="{{ $status->id }}" {{ $selected }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>


            </div>

            <input type="hidden" id="data_type" value="tags">
            <div class="mx-2 mb-2">
                <table table-stripped id="task_table">
                    <thead>
                        <tr style="background-color: rgb(8 47 73); color: #ffff;">
                            <!-- <th data-checkbox="true"></th> -->
                            <th data-field="attributes"></th>
                            <th class="text-wrap"><?= get_label('task', 'Task') ?></th>
                            <th><?= get_label('project', 'Project') ?></th>
                            <th><?= get_label('department', 'Department') ?></th>
                            <th><?= get_label('assigned_by', 'Assigned by') ?></th>
                            <th><?= get_label('assigned_to', 'Assigned to') ?></th>
                            <th><?= get_label('start_date', 'Start date') ?></th>
                            <th><?= get_label('end_date', 'End date') ?></th>
                            <th><?= get_label('budget', 'Budget') ?></th>
                            <th><?= get_label('status', 'Status') ?></th>
                            <th><?= get_label('description', 'Description') ?></th>
                            <th><?= get_label('created_at', 'Created at') ?></th>
                            <th><?= get_label('updated_at', 'Updated at') ?></th>
                            <!-- <th data-formatter="actionsFormatter"><?= get_label('actions', 'Actions') ?></th> -->
                            <th><?= get_label('actions', 'Actions') ?></th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
    var can_edit = {
        {
            Auth::user() - > can('task.edit')
        }
    };
    var can_delete = {
        {
            Auth::user() - > can('task.delete')
        }
    };
    // var show_task_progress = ({{config('tracki.show_task_progress')}} == '1')?'1':'0';
</script>
<script src="{{asset('assets/js/pages/tasks.js')}}"></script>

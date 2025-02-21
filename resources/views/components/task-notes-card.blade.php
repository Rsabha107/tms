<div class="card mt-3">
    <div class="card-body bg-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <div class="mb-4 mt-2">
                <div class="row g-1 mx-2">
                    <div class=" row col-auto scrollbar overflow-hidden-y flex-grow-1">
                        <caption-top>
                            <h4>Task Notes</h4>
                            </caption>
                    </div>
                    <div class="col-auto">
                        <!-- <a href="#!" class="btn btn-phoenix-primary px-3 px-sm-5 me-2">
                            <span class="fas fa-plus me-2"></span>Add note</a> -->

                        <!-- <a href="#!" id="addTaskNote" data-table="task_table" data-id="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addTaskNoteModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><i class="fa-solid fa-note-sticky text-primary me-1"></i>Add a note</a>' + -->

                        <a href="#!" id="addTaskNote" data-table="task_note_table" data-bs-toggle="modal" data-id="{{$tasks->id}}" data-bs-target="#addTaskNoteModal">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_task_note', 'Create task note') ?>">
                                <i class="bx bx-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <input type="hidden" id="data_type" value="alltasks">
            <div class="mx-2 mb-2">
                <table table-stripped id="task_note_table" data-toggle="table" data-classes="table table-hover fs-9 mb-0 border-top border-translucent" data-loading-template="loadingTemplate" data-buttons-align='right' data-card-view=false data-url="{{ route('tracki.task.note.get', $tasks->id)}}" data-icons-prefix="bx" data-icons="icons" data-show-export="false" data-show-refresh="true" data-show-columns-toggle-all="false" data-show-toggle="false" data-show-fullscreen="false" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-size="10" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-searchable="false" data-side-pagination="server" data-show-pagination-switch="false" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-buttons-class="secondary" data-query-params="queryParams">
                        <thead>
                            <tr>
                                <th data-checkbox="true"></th>
                                <th class="text-wrap" data-sortable="true" data-field="id" data-visible="false"><?= get_label('id', 'Id') ?></th>
                                <th class="text-wrap" data-sortable="true" data-searchable="true" data-field="note_text"><?= get_label('note', 'Note') ?></th>
                                <th data-sortable="true" data-searchable="true" data-field="user_name" data-visible="false"><?= get_label('created_by', 'Create by') ?></th>
                                <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                                <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                                <th data-formatter="actionsFormatterNotes"><?= get_label('actions', 'Actions') ?></th>
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
    var can_edit = <?= (Auth::user()->can('task.edit')) == '' ? '0' : '1' ?>;
    var can_delete = <?= (Auth::user()->can('task.delete')) == '' ? '0' : '1' ?>;
    var show_task_progress = <?= (config('tracki.show_task_progress') == '') ? '0' : '1' ?>;
</script>
<script src="{{asset('assets/js/pages/notes.js')}}"></script>

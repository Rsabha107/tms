<div class="card mt-3">
    <div class="card-body bg-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <div class="mb-4 mt-2">
                <div class="row g-1 mx-2">
                    <div class=" row col-auto scrollbar overflow-hidden-y flex-grow-1">
                        <caption-top>
                            <h4>Task Files</h4>
                            </caption>
                    </div>
                    <div class="col-auto">
                        <!-- <a href="#!" class="btn btn-phoenix-primary px-3 px-sm-5 me-2">
                            <span class="fas fa-plus me-2"></span>Add File</a> -->
                            <a href="#!" id="addTaskAttch" data-table="task_file_table" data-bs-toggle="modal" data-id="{{$tasks->id}}" data-bs-target="#addAttachementTaskModal">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_task_file', 'Create task file') ?>">
                                <i class="bx bx-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <input type="hidden" id="data_type" value="alltasks">
            <div class="mx-2 mb-2">
                <table  table-stripped id="task_file_table"
                        data-toggle="table"
                        data-classes="table table-hover fs-9 mb-0 border-top border-translucent"
                        data-loading-template="loadingTemplate"
                        data-url="{{ route('tracki.task.file.get', $tasks->id)}}"
                        data-icons-prefix="bx"
                        data-icons="icons"
                        data-show-export="false"
                        data-show-refresh="true"
                        data-show-columns-toggle-all="false"
                        data-show-toggle="false"
                        data-show-fullscreen="false"
                        data-total-field="total"
                        data-trim-on-search="false"
                        data-data-field="rows"
                        data-page-size="10"
                        data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-search="false"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-pagination="true"
                        data-sort-name="id"
                        data-sort-order="desc"
                        data-mobile-responsive="true"
                        data-buttons-class="secondary"
                        data-query-params="queryParams">
                    <thead>
                        <tr>
                            <th data-checkbox="true"></th>
                            <th class="text-wrap" data-sortable="true" data-field="id"><?= get_label('id', 'Id') ?></th>
                            <th data-sortable="true" data-field="original_file_name"><?= get_label('file', 'File') ?></th>
                            <th data-sortable="true" data-field="file_size"><?= get_label('size', 'Size') ?></th>
                            <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                            <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                            <th data-formatter="actionsFormatterFiles"><?= get_label('actions', 'Actions') ?></th>
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
<script src="{{asset('assets/js/pages/files.js')}}"></script>

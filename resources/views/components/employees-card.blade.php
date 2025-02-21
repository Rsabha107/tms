<div class="card">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            @if (is_countable($emps) && count($emps) > 0)
            <input type="hidden" id="data_type" value="tags">
            <table  id="employee_table" data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                    data-toggle="table" data-loading-template="loadingTemplate"
                    data-url="{{route('tracki.employee.show')}}"
                    data-icons-prefix="bx"
                    data-icons="icons"
                    data-show-refresh="true" data-total-field="total"
                    data-trim-on-search="false" data-data-field="rows"
                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                    data-side-pagination="server" data-show-columns="true"
                    data-pagination="true" data-sort-name="id" data-sort-order="desc"
                    data-mobile-responsive="true" data-query-params="queryParams">
                <thead>
                    <tr>
                        <th data-checkbox="true" data-halign="left" data-align="center"></th>
                        <th data-sortable="true" data-field="image" data-align="center"></th>
                        <!-- <th data-sortable="true" data-field="id1"><?= get_label('id', 'ID') ?></th> -->
                        <!-- <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th> -->
                        <th class="align-middle white-space-nowrap fs-9 text-body" data-sortable="true" data-field="employee_number"><?= get_label('employee_number', 'Emp Number') ?></th>
                        <th data-sortable="true" data-field="full_name"><?= get_label('full_name', 'Name') ?></th>
                        <!-- <th data-sortable="true" data-field="first_name"><?= get_label('first_name', 'First name') ?></th> -->
                        <!-- <th data-sortable="true" data-field="last_name"><?= get_label('last_name', 'Last Name') ?></th> -->
                        <th data-sortable="true" data-field="email_address"><?= get_label('email', 'Email') ?></th>
                        <th data-sortable="true" data-field="employee_type"><?= get_label('employee_type', 'Emp Type') ?></th>
                        <th data-sortable="true" data-field="reporting_to"><?= get_label('reporting_to', 'Supervisor Name') ?></th>
                        <!-- <th data-sortable="true" data-field="gender"><?= get_label('gender', 'Gender') ?></th> -->
                        <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                        <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                        <th data-formatter="actions2Formatter"><?= get_label('actions', 'Actions') ?></th>
                    </tr>
                </thead>
            </table>
            @else
            <?php
            $type = 'Employees'; ?>
            <x-empty-state-card :type="$type" />

            @endif
        </div>
    </div>
</div>

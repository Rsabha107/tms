@extends('tracki.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-2 mt-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.dashboard')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('employees', 'Employees') ?>
                        </li>

                    </ol>
                </nav>
            </div>
            <div class="d-flex justify-content-center">
                <div id="cover-spin" style="display:none;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div>
                <a href="#!" id="add_employee" data-action="store" data-source="manage" data-type="add" data-table="employee_table" data-id="0">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_employee', 'Create employee') ?>">
                        <i class="bx bx-plus"></i>
                    </button>
                </a>
            </div>
        </div>
        <x-employees-card :emps='$emps' />
    </div>

    <script>
        var label_update = '<?= get_label('update', 'Update') ?>';
        var label_view = '<?= get_label('view', 'Quick view') ?>';
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
        var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
        var can_edit = <?= (Auth::user()->can('employee.edit')) == '' ? '0' : '1' ?>;
        var can_delete = <?= (Auth::user()->can('employee.delete')) == '' ? '0' : '1' ?>;
    </script>
    <script src="{{asset('assets/js/pages/employees.js')}}"></script>

    @endsection

    @push('script')


    @endpush

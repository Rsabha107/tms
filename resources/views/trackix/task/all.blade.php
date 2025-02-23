@extends('tracki.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.project.show.card')}}"><?= get_label('projects', 'Projects') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.task.manage')}}"><?= get_label('tasks', 'Tasks') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('all', 'All') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="javascript:void(0)" id="add_task" data-action="store" data-source="manage" data-type="add" data-table="task_table" data-id="0" >
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_task', 'Create task') ?>">
                        <i class="bx bx-plus"></i>
                    </button>
                </a>
            </div>
        </div>
        <x-tasks-card :users="$users" :projects="$projects" :statuses="$statuses" :departments="$departments" source="manage" showpage="manage" showpageid=""/>
    </div>



    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

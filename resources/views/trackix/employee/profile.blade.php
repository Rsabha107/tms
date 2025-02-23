@extends('tracki.layout.dashboard')
@section('main')

<div class="content">
    <nav class="mb-3" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('tracki.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('tracki.employee')}}">Employee</a></li>
            <li class="breadcrumb-item active">{{$emp->full_name}}</li>
        </ol>
    </nav>
    <div class="mb-9">
        <div class="row align-items-center justify-content-between g-3 mb-3">
            <div class="col-auto">
                <h2 class="mb-0">Profile</h2>
            </div>
            <div class="col-auto">
                <div class="row g-3">
                    <div class="col-auto">
                        <button class="btn btn-phoenix-danger"><span class="fa-solid fa-trash-can me-2"></span>Delete customer</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-phoenix-secondary"><span class="fas fa-key me-2"></span>Reset password</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <!-- <div class="col-12 col-xxl-12"> -->
            <!-- <div class="row g-3 h-100"> -->
            <div class="col-12 col-md-12 col-xxl-12 mb-0">
                <div class="card h-100 h-xxl-auto">
                    <div class="card-body">
                        <!-- <div class="card-body d-flex flex-column justify-content-between pb-3"> -->

                        <div class="row  g-5 mb-3 text-sm-start">
                            <!-- <div class="row align-items-center g-5 mb-3 text-center text-sm-start"> -->
                            <div class="col-12 col-sm-1 mb-sm-1">
                                <div class="avatar avatar-4xl"><img class="rounded-circle" src="{{(!empty($emp->emp_files->file_name)) ? url($emp->emp_files->file_path.$emp->emp_files->file_name) : url('upload/no_image.jpg')}}" alt="" /></div>
                            </div>
                            <div class="col-12 col-sm-3  border-end">
                                <div class="d-flex align-items-center mb-3">
                                    <h3 class="me-1">{{$emp->full_name}}</h3>
                                    <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                </div>
                                <!-- <h3>{{$emp->full_name}}</h3> -->
                                <h6 class="text-body-secondary">{{$emp->departments?->name}}</h6>
                                <h6 class="text-body-secondary">{{$emp->designations?->name}}</h6>
                                <h6 class="text-body-secondary">Employee Number: {{$emp->employee_number}}</h6>
                                <h6 class="text-body-secondary">Join Date: {{format_date($emp->join_date)}}</h6>
                                <!-- <h6 class="text-body-secondary">Employee Type: {{$emp->employee_types->title}}</h6> -->
                                <!-- <span class="badge badge-phoenix fs--2 badge-phoenix-secondary">{{$emp->employee_types->title}}</span> -->
                                <div class="mb-3"><a class="me-2" href="#!"><span class="fab fa-linkedin-in text-body-quaternary text-opacity-75 text-primary-hover"></span></a><a class="me-2" href="#!"><span class="fab fa-facebook text-body-quaternary text-opacity-75 text-primary-hover"></span></a><a href="#!"><span class="fab fa-twitter text-body-quaternary text-opacity-75 text-primary-hover"></span></a></div>
                                <div class="d-flex flex-between-center border-top border-solid pt-3">
                                    <div>
                                        <h6>Projects</h6>
                                        <p class="fs-7 text-body-secondary mb-0">{{$emp->projects->count()}}</p>
                                    </div>
                                    <div>
                                        <h6>Tasks</h6>
                                        <p class="fs-7 text-body-secondary mb-0">{{$emp->tasks->count()}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-7">
                                <table class="lh-sm">
                                    <tbody>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                        </tr>
                                        <tr>
                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-12 col-sm-auto ">
                                    <div style="position:absolute;right:0;top:0;">
                                        <a href="#!" class="text-secondary"><span class="fa-solid fa-edit me-2"></span></a>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
        <div class="col-xl-12 col-xxl-12 g-3 mb-2">
            <div class="card">
                <div class="card-body">


                    <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile" aria-selected="true">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Address</a></li>
                        <li class="nav-item"><a class="nav-link" id="projects-tab" data-employee-id="{{$emp->id}}" data-bs-toggle="tab" href="#tab-projects" role="tab" aria-controls="tab-projects" aria-selected="false">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" id="tasks-tab" data-bs-toggle="tab" href="#tab-tasks" role="tab" aria-controls="tab-tasks" aria-selected="false">Tasks</a></li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">

                        <div class="tab-pane fade" id="tab-projects" role="tabpanel" aria-labelledby="projects-tab">
                            <!-- <div class=" col-12 col-sm-12 col-xl-12 col-xxl-12 g-3 mb-9">
                                <div id="projectCards">projects</div>
                            </div> -->
                            <div class=" col-12 col-sm-12 col-xl-12 col-xxl-12 g-3 mb-9">
                                <div class="container-fluid">
                                    <x-project-list-per :employee="$emp" source="projlist" />
                                </div>

                                <script>
                                    var label_update = '<?= get_label('update', 'Update') ?>';
                                    var label_view = '<?= get_label('view', 'Quick view') ?>';
                                    var label_delete = '<?= get_label('delete', 'Delete') ?>';
                                    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
                                    var can_edit = <?= (Auth::user()->can('employee.edit')) == '' ? '0' : '1' ?>;
                                    var can_delete = <?= (Auth::user()->can('employee.delete')) == '' ? '0' : '1' ?>;
                                </script>
                                <script src="{{asset('assets/js/pages/projects_per.js')}}"></script>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-tasks" role="tabpanel" aria-labelledby="tasks-tab">
                            <!-- <div class=" col-12 col-sm-12 col-xl-12 col-xxl-12 g-3 mb-9">
                                <div id="projectCards">projects</div>
                            </div> -->
                            <div class=" col-12 col-sm-12 col-xl-12 col-xxl-12 g-3 mb-9">
                                <div class="container-fluid">
                                    <x-task-list-per :employee="$emp" source="projlist" />
                                </div>

                                <script>
                                    var label_update = '<?= get_label('update', 'Update') ?>';
                                    var label_view = '<?= get_label('view', 'Quick view') ?>';
                                    var label_delete = '<?= get_label('delete', 'Delete') ?>';
                                    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
                                    var can_edit = <?= (Auth::user()->can('employee.edit')) == '' ? '0' : '1' ?>;
                                    var can_delete = <?= (Auth::user()->can('employee.delete')) == '' ? '0' : '1' ?>;
                                </script>
                                <script src="{{asset('assets/js/pages/projects_per.js')}}"></script>
                            </div>
                        </div>

                        <div class="tab-pane fade show active mb-3" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-2 g-3 mb-9">
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Personal Information</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Emergency Contact</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Leave Information</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Training Information</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Personal Information</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card h-100 ">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="me-1">Emergency Contact</h4>
                                                <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                                            </div>

                                            <div class="col-12 col-sm-auto flex-1">
                                                <table class="lh-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                                            <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                                            <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="tab-address" role="tabpanel" aria-labelledby="address-tab">

                            <div class=" col-12 col-sm-12 col-xl-12 col-xxl-12 g-3 mb-9">
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-between mb-2 mt-4">
                                        <div class="d-flex justify-content-center">
                                            <div id="cover-spin" style="display:none;" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#!" id="add_employee_address" data-action="store" data-source="manage" data-type="add" data-table="employee_address_table" data-id="0">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_employee_address', 'Create employee address') ?>">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <x-employee-addresses-card :emp='$emp' />
                                </div>

                                <script>
                                    var label_update = '<?= get_label('update', 'Update') ?>';
                                    var label_view = '<?= get_label('view', 'Quick view') ?>';
                                    var label_delete = '<?= get_label('delete', 'Delete') ?>';
                                    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
                                    var can_edit = <?= (Auth::user()->can('employee.edit')) == '' ? '0' : '1' ?>;
                                    var can_delete = <?= (Auth::user()->can('employee.delete')) == '' ? '0' : '1' ?>;
                                </script>
                                <script src="{{asset('assets/js/pages/employee_addresses.js')}}"></script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/js/pages/profile.js')}}"></script>

        <!-- <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-2 g-3 mb-9">
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Personal Information</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Emergency Contact</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Leave Information</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Training Information</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Personal Information</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="me-1">Emergency Contact</h4>
                            <button class="btn btn-link p-0"><span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span></button>
                        </div>

                        <div class="col-12 col-sm-auto flex-1">
                            <table class="lh-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Employee Type : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->employee_types->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Email : </td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->work_email_address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Phone :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Gender :</td>
                                        <td class="text-warning fw-semibold ps-3">{{$emp->genders->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Date of Bith :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{format_date($emp->date_of_birth)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Address :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">1861 Bayonne Ave, Manchester Township, NJ, 08759</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-1 text-body text-nowrap fw-bold">Reporting to :</td>
                                        <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">{{$emp->managers?->full_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- </div> -->

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

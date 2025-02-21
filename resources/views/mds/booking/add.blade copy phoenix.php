@extends('mds.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">

    <div class="d-flex justify-content-between m-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{url('/main/dashboard')}}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('tracki.project.show.card')}}">
                            <?= get_label('projects', 'Projects') ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= get_label('card', 'Card') ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-between align-items-end mb-4 g-3">
        <div class="col-12 col-sm-auto">
            <h2 class="mb-0">{{__('traki.employee.create_employee')}}<span class="fw-normal text-700 ms-3"></span></h2>
        </div>
        <div class="col-12 col-sm-auto">
            <div class="d-flex align-items-center">
                <div class="search-box me-3">
                </div>
                <!-- <a class="btn btn-primary px-5" href="#!" id="add_new_project" data-workspace-id=""><i class="bx bx-plus"></i></a> -->
                <!-- <a href="#" id="add_new_project" data-workspace-id=""><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>"><i class="bx bx-plus"></i></button></a> -->
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
            <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
                <ul class="nav justify-content-between nav-wizard nav-wizard-success">
                    <li class="nav-item"><a class="nav-link active fw-semibold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Basic</span></div>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Personal</span></div>
                        </a>
                    </li>
                    <!-- <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-address-card"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Address</span></div>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="4">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-file-alt"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Bank</span></div>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab5" data-bs-toggle="tab" data-wizard-step="5">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-file-alt"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Emergency Contact</span></div>
                        </a>
                    </li> -->
                    <!-- <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab6" data-bs-toggle="tab" data-wizard-step="3">
                            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-check"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Done</span></div>
                        </a>
                    </li> -->
                </ul>
            </div>
            <div class="card-body pt-4 pb-0">
                <form id="basicForm" novalidate="novalidate" method="POST" data-wizard-form="1" action="{{route('mds.booking.store')}}">
                @csrf

                    <div class="tab-content">

                        <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                            <!-- <form class="needs-validation" id="basicForm" novalidate="novalidate" data-wizard-form="1"> -->
                            <div class="row mb-2">
                                <!-- begining of left div -->
                                <div class="col-md-12">
                                    <!-- <div class="mb-2 row"> -->
                                    <div class="mb-2 row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="bootstrap-wizard-validation-gender">Employee Type</label>
                                            <select class="form-select" name="employee_type" id="add_employee_employee_type" required="required">
                                                <option value="">Select ...</option>
                                                @foreach ($schedule as $key => $item )
                                                <option value="{{ $item->id  }}">
                                                    {{ $item->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <!-- <div class="invalid-feedback">This field is required.</div> -->
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="inputAddress">Prefix</label>
                                            <select name="salutation" class="form-select" id="add_employee_salutation">
                                                <option selected="selected" value="">Select...</option>
                                                @foreach ($schedule as $key => $item )
                                                <option value="{{ $item->id  }}">
                                                    {{ $item->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <!-- <div class="invalid-feedback">This field is required.</div> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- end of left div -->
                            </div>
                            <!-- </form> -->
                        </div>
                        <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                            <!-- <form class="needs-validation" id="personalForm" novalidate="novalidate" data-wizard-form="2"> -->
                            <!-- begining of right div -->
                            <div class="row g-4 mb-4" data-dropzone="data-dropzone" data-options='{"maxFiles":1,"data":[{"name":"avatar.webp","size":"54kb","url":"../../assets/img/team"}]}'>
                                <div class="fallback">
                                    <input type="file" name="file" />
                                </div>
                                <div class="col-md-auto">
                                    <div class="dz-preview dz-preview-single">
                                        <div class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                            <div class="avatar avatar-4xl"><img id="showImage" class="rounded-circle avatar-placeholder" src="{{(!empty($emp->emp_files->file_name)) ? url($emp->emp_files->file_path.$emp->emp_files->file_name) : url('upload/no_image.jpg')}}" alt="..." data-dz-thumbnail="data-dz-thumbnail" /></div>
                                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input class="form-control form-control-sm" type="file" name="profile_image_name" id="profile_image_name" />
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="mb-2 row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="inputEmail4">Birth Date *</label>
                                        <input class="form-control datetimepicker" id="add_employee_date_of_birth" data-target="#floatingInputStartDate" name="date_of_birth" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}'>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="inputEmail4">Town of birth</label>
                                        <input name="town_of_birth" id="add_employee_town_of_birth" class="form-control" type="text" placeholder="">
                                        <!-- <div class="invalid-feedback">This field is .</div> -->
                                    </div>
                                </div>

                            </div>

                            <!-- end of right div -->
                            <!-- </form> -->
                        </div>
                        <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6">
                            <!-- <form class="mb-2" id="confirmationForm" novalidate="novalidate" data-wizard-form="4"> -->
                            <div class="row flex-center pb-8 pt-4 gx-3 gy-4">
                                <div class="col-12 col-sm-auto">
                                    <div class="text-center text-sm-start"><img class="d-dark-none" src="../../assets/img/spot-illustrations/38.webp" alt="" width="220" /><img class="d-light-none" src="../../assets/img/spot-illustrations/dark_38.webp" alt="" width="220" /></div>
                                </div>
                                <div class="col-12 col-sm-auto">
                                    <div class="text-center text-sm-start">
                                        <h5 class="mb-2">You are all set!</h5>
                                        <p class="text-body-emphasis fs-9">Now you can access your account<br />anytime anywhere</p><a class="btn btn-primary px-6" href="../../modules/forms/wizard.html">Start Over</a>
                                    </div>
                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </form>

            </div>
            <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
                <div class="d-flex pager wizard list-inline mb-0">
                    <button class="d-none btn btn-link ps-0" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Previous</button>
                    <div class="flex-1 text-end">
                        <button class="btn btn-primary px-6 px-sm-6" type="button" data-wizard-next-btn="data-wizard-next-btn">Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span></button>
                        <button id="store_employee" class="btn btn-primary px-6 px-sm-6 d-none" type="submit" data-wizard-submit-btn="data-wizard-submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Order Placed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Congratulations! Your order is placed.</div>
                <div id="jsonOutput"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeModal()">
                        Ok, close and reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('script')

    <!-- <script src="{{asset('assets/js/pages/employees.js')}}"></script> -->

    <!-- Include SmartWizard JavaScript source -->
    <!-- <script type="text/javascript" src="{{ asset('assets/smartwizard/js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/smartwizard/dist/js/jquery.smartWizard.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/smartwizard/js/smartwizard.js') }}"></script> -->

    @endpush

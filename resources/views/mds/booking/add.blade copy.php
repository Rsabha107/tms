@extends('tracki.layout.dashboard')
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
        <div class="card">
        <!-- SmartWizard html -->
        <div id="smartwizard" dir="rtl-">
            <ul class="nav nav-progress mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="#step-1">
                        <div class="num">1</div>
                        Basic Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2">
                        <span class="num">2</span>
                        Assignment Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        <span class="num">3</span>
                        Personal Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4">
                        <span class="num">4</span>
                        Confirm Order
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#step-5">
                        <span class="num">5</span>
                        Confirm Order
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                    <form class="row g-3  px-3 needs-validation form-submit-event" id="form-1" action="{{route('mds.booking.store')}}" novalidate method="POST">
                        <!-- <form id="form-1" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate> -->
                        <div class="row mb-3">
                            <!-- begining of left div -->
                            <div class="col-md-6">
                                <!-- <div class="mb-3 row"> -->

                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Employee Type</label>
                                    <select class="form-select" name="employee_type" id="add_employee_employee_type" required="required">
                                        <option value="">Select ...</option>
                                        @foreach ($schedules as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="inputAddress">Prefix</label>
                                    <select name="salutation" class="form-select" id="add_employee_salutation">
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($schedules as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>

                                <!-- </div> -->

                                <!-- <div class="mb-3 row"> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">First Name</label>
                                    <input name="first_name" id="add_employee_first_name" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Middle Name</label>
                                    <input name="middle_name" id="add_employee_middle_name" class="form-control" type="text" placeholder="">
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Last Name</label>
                                    <input name="last_name" id="add_employee_last_name" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <!-- </div> -->
                                <!-- <div class="mb-3 row"> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Email</label>
                                    <input name="email_address" id="add_employee_email_address" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">National Identificaton Number</label>
                                    <input name="national_identifier_number" id="add_employee_national_identifier_number" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <!-- </div> -->

                                <!-- <div class="mb-3 row"> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Phone</label>
                                    <input name="phone_number" id="add_employee_phone_number" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label" for="inputEmail4">Alternate Phone</label>
                                    <input name="alt_phone_number" id="add_employee_alt_phone_number" class="form-control" type="text" placeholder="">
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <!-- </div> -->
                                <div class="col-md-12">
                                    <input class="form-control form-control-sm" id="customFileSm" type="file" name="profile_image_name" id="fileupld" />
                                </div>
                            </div>
                            <!-- end of left div -->

                            <!-- begining of right div -->
                            <div class="col-md-6 mb-3">
                                <!-- <div class="mb-3 row"> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Birth Date</label>
                                    <input class="form-control datetimepicker" id="add_employee_date_of_birth" data-target="#floatingInputStartDate" name="date_of_birth" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Town of birth</label>
                                    <input name="town_of_birth" id="add_employee_town_of_birth" class="form-control" type="text" placeholder="" required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <!-- </div> -->
                                <!-- <div class="mb-3 row"> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Hire Date</label>
                                    <input class="form-control datetimepicker" id="edit_employee_date_of_hire" data-target="#floatingInputStartDate" name="date_of_hire" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="inputEmail4">Joining Date</label>
                                    <input class="form-control datetimepicker" id="edit_employee_join_date" data-target="#floatingInputStartDate" name="join_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <!-- </div> -->
                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Gender</label>
                                    <select class="form-select" name="gender" id="add_employee_gender" required="required">
                                        <option value="">Select ...</option>
                                        @foreach ($schedules as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Marital Status</label>
                                    <select class="form-select" name="marital_status" id="add_employee_marital_status" required="required">
                                        <option value="">Select ...</option>
                                        @foreach ($schedules as $key => $item )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Language</label>
                                    <select class="form-select" name="language" id="add_employee_language" required="required">
                                        <option value="">Select ...</option>
                                        <option value="1">English</option>
                                        <option value="2">French</option>
                                        <option value="3">Spanish</option>
                                        <option value="4">Others</option>
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Country of birth</label>
                                    <select class="form-select" name="country_of_birth" id="add_employee_country_of_birth" required="required">
                                        <option value="">Select ...</option>
                                        @foreach ($schedules as $key => $item )
                                        @if (Request::old('id') == $item->id )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->country_name }}
                                        </option>
                                        @else
                                        <option value="{{ $item->id  }}">
                                            {{ $item->country_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>



                                <div class="col-md-12">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Nationality</label>
                                    <select class="form-select" name="nationality" id="add_employee_nationality" required="required">
                                        <option value="">Select ...</option>
                                        @foreach ($schedules as $key => $item )
                                        @if (Request::old('id') == $item->id )
                                        <option value="{{ $item->id  }}" selected>
                                            {{ $item->nationality }}
                                        </option>
                                        @else
                                        <option value="{{ $item->id  }}">
                                            {{ $item->nationality }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                                </div>
                            </div>

                            <!-- end of right div -->
                        </div>

                    </form>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <form id="form-2" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label">Product</label>
                            <select class="form-select" id="sel-products" name="product" multiple required>
                                <option value="Apple iPhone 13" selected>Apple iPhone 13</option>
                                <option value="Apple iPhone 12">Apple iPhone 12</option>
                                <option value="Samsung Galaxy S10">Samsung Galaxy S10</option>
                                <option value="Motorola G5">Motorola G5</option>
                            </select>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please select product.</div>
                        </div>
                    </form>
                </div>
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                    <form id="form-3" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate>
                        <div class="col">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="1234 Main St" placeholder="1234 Main St" required="" />
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>
                        <div class="col">
                            <label for="validationCustom04" class="form-label">State</label>
                            <select class="form-select" id="state" name="state" required>
                                <option selected disabled value="">Choose...</option>
                                <option>State 1</option>
                                <option>State 2</option>
                                <option>State 3</option>
                            </select>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>
                        <div class="col">
                            <label for="validationCustom05" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip" name="zip" value="00000" required />
                            <div class="invalid-feedback">Please provide a valid zip.</div>
                        </div>
                    </form>
                </div>
                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                    <form id="form-4" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate>
                        <div class="col">
                            <div class="mb-3 text-muted">
                                Please confirm your order details
                            </div>

                            <div id="order-detailsx"></div>

                            <h4 class="mt-3">Payment</h4>
                            <hr class="my-2" />

                            <div class="row gy-3">
                                <div class="col-md-3">
                                    <label for="cc-name" class="form-label">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" value="My Name" placeholder="" required="" />
                                    <small class="text-muted">Full name as displayed on card</small>
                                    <div class="invalid-feedback">Name on card is required</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="cc-number" class="form-label">Credit card number</label>
                                    <input type="text" class="form-control" id="cc-number" value="54545454545454" placeholder="" required="" />
                                    <div class="invalid-feedback">
                                        Credit card number is required
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="cc-expiration" class="form-label">Expiration</label>
                                    <input type="text" class="form-control" id="cc-expiration" value="1/28" placeholder="" required="" />
                                    <div class="invalid-feedback">Expiration date required</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="cc-cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cc-cvv" value="123" placeholder="" required="" />
                                    <div class="invalid-feedback">Security code required</div>
                                </div>

                                <div class="col">
                                    <input type="checkbox" checked class="form-check-input" id="save-info" required />
                                    <label class="form-check-label" for="save-info">I agree to the terms and conditions</label>
                                </div>

                                <small class="text-muted">This is an example page, do not enter any real data, even
                                    tho we don't submit this information!</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                    <form id="form-5" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate>
                        <div class="col">
                            <div class="mb-3 text-muted">
                                Please confirm your order details
                            </div>

                            <div id="order-details"></div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <br />
        &nbsp;
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

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="{{ asset('assets/smartwizard/js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/smartwizard/dist/js/jquery.smartWizard.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/smartwizard/js/smartwizard.js') }}"></script>

    @endpush

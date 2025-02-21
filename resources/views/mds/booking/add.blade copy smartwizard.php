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
        <div class="card">
            <!-- SmartWizard html -->
            <div id="smartwizard" dir="rtl-">
                <ul class="nav nav-progress mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#step-1">
                            <div class="num">1</div>
                            Scheduling Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#step-2">
                            <span class="num">2</span>
                            Booking Details
                        </a>
                    </li>

                </ul>
                <form class="row g-3  px-3 needs-validation" action="{{route('mds.booking.store')}}" id="form-1" novalidate method="POST">
                    @csrf

                    <input type="hidden" id="add_schedule_period_id" name="schedule_period_id" value="" required>
                    <div class="tab-content">
                        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                            <!-- <form id="form-1" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate> -->
                            <div class="row mb-3">

<label class="col-sm-2 col-form-label" for="inputEmail3">Email</label>

<div class="col-sm-10">

  <input class="form-control" id="inputEmail3" type="email" />
</div>
</div>
                            <div class="col-md-6" style="margin:0 auto;">
                                <label class="form-label" for="inputEmail4">Date</label>
                                <input class="form-control datetimepicker" id="add_booking_date" data-target="#floatingInputStartDate" name="booking_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                            </div>
                            <div class="col-md-12">
                                <!-- <div class="col-md-6 mt-4 mb-3" style="width:800px; margin:0 auto;">
                                    <h4> Project Details </h4>
                                </div> -->
                                <div class="col-md-6 mb-3" style="margin:0 auto;">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Delivery Areas</label>
                                    <select class="form-select" name="employee_type" id="add_delivery_area" required="required">
                                        <option value="">Select delivery areas...</option>
                                        @foreach ($venues as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="time_alert" class="col-md-6 mb-3 alert alert-subtle-secondary" style="margin:0 auto;" role="alert">No time slot has been selected!</div>
                                <div class="col-md-6 mb-3" style="margin:0 auto;">
                                    <button class="btn btn-subtle-primary d-grid gap-2" id="show_shcedule_times_modal" style="margin:0 auto;" type="button">Get times</button>
                                </div>
                                <div class="col-md-6 mb-5" style="margin:0 auto;">
                                    <label class="form-label" for="bootstrap-wizard-validation-gender">Clients</label>
                                    <select class="form-select" name="employee_type" id="add_employee_employee_type" required="required">
                                        <option value="">Select Clients...</option>
                                        @foreach ($clients as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invisible">.</div>
                            </div>


                </form>
            </div>
            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                <!-- <form id="form-2" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate> -->
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
                <!-- </form> -->
            </div>
            <!-- <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
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
            </div> -->
        </div>
        </form>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <br />
    &nbsp;
</div>
</div>

<!-- Confirm Modal -->
<!-- <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
</div> -->

<script src="{{asset('assets/js/pages/booking.js')}}"></script>

@endsection

@push('script')

<!-- Include SmartWizard JavaScript source -->
<!-- <script type="text/javascript" src="{{ asset('assets/smartwizard/js/demo.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('assets/smartwizard/dist/js/jquery.smartWizard.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/smartwizard/js/smartwizard.js') }}"></script>

<script>
    $(document).ready(function() {
        console.log("ready!");
        // Reset wizard
        $('#smartwizard').smartWizard("reset");

        // Reset form
        document.getElementById("form-1").reset();
        // document.getElementById("form-2").reset();
        // document.getElementById("form-3").reset();
        // document.getElementById("form-4").reset();
    });

</script>

@endpush

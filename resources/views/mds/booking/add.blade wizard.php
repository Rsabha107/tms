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
        <section class="wizard-section">
            <div class="row no-gutters">
                <div class="col-lg-8 col-md-8">
                    <div class="form-wizard">
                        <!-- <form id='myform' action="{{route('mds.booking.store')}}" method="post" role="form"> -->
                        <form class="row g-3  px-3 needs-validation" action="{{route('mds.booking.store')}}" id="myform" novalidate method="POST">
                            @csrf
                            <div class="form-wizard-header">
                                <p>Fill all form field to go next step</p>
                                <ul class="list-unstyled form-wizard-steps clearfix">
                                    <li class="active"><span>1</span></li>
                                    <li><span>2</span></li>
                                    <!-- <li><span>3</span></li>
								<li><span>4</span></li> -->
                                </ul>
                            </div>
                            <fieldset class="wizard-fieldset show">
                                <h5>Personal Information</h5>

                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label" for="inputEmail3">Date</label>
                                    <div class="col-sm-10">
                                    <input class="form-control datetimepicker" id="add_booking_date" data-target="#floatingInputStartDate" name="booking_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="inputEmail3">Delivery Areas</label>
                                    <div class="col-sm-10">
                                    <select class="form-select wizard-required" name="employee_type" id="add_delivery_area" required="required">
                                        <option value="">Select delivery areas...</option>
                                        @foreach ($venues as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div id="time_alert" class="col-md-12 mb-3 alert alert-subtle-secondary" style="margin:0 auto;" role="alert">No time slot has been selected!</div>
                                <div class="col-md-8 mb-3" style="margin:0 auto;">
                                    <button class="btn btn-subtle-primary d-grid gap-2" id="show_shcedule_times_modal" style="margin:0 auto;" type="button">Get times</button>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="inputEmail3">Clients</label>
                                    <div class="col-sm-10">
                                    <select class="form-select" name="employee_type" id="add_delivery_area" required="required">
                                        <option value="">Select clients...</option>
                                        @foreach ($clients as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                                </div>
                            </fieldset>
                            <fieldset class="wizard-fieldset">
                                <h5>Account Information</h5>
                                <div class="form-group">
                                    <input type="email" class="form-control wizard-required" id="email">
                                    <label for="email" class="wizard-form-text-label">Email*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="username">
                                    <label for="username" class="wizard-form-text-label">User Name*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control wizard-required" id="pwd">
                                    <label for="pwd" class="wizard-form-text-label">Password*</label>
                                    <div class="wizard-form-error"></div>
                                    <span class="wizard-password-eye"><i class="far fa-eye"></i></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control wizard-required" id="cpwd">
                                    <label for="cpwd" class="wizard-form-text-label">Confirm Password*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                                <div class="form-group clearfix">
                                    <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                                    <a href="javascript:;" onclick="document.getElementById('myform').submit()" class="form-wizard-submit float-right">Submit</a>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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
    <script src="{{asset('assets/js/wizard.js')}}"></script>

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

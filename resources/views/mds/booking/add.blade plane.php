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
        <div class="card shadow-none border my-4" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom bg-body">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-body mb-0" data-anchor="data-anchor">Basic form</h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-name">Name</label>

                            <input class="form-control" id="basic-form-name" type="text" placeholder="Name" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-email">Email address</label>
                            <input class="form-control" id="basic-form-email" type="email" placeholder="name@example.com" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-password">Password</label>
                            <input class="form-control" id="basic-form-password" type="password" placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-dob">Date of Birth</label>
                            <input class="form-control" id="basic-form-dob" type="date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-gender">Gender</label>
                            <select class="form-select" id="basic-form-gender" aria-label="Default select example">
                                <option selected="selected">Select your gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" id="flexRadioDefault1" type="radio" name="flexRadioDefault" />
                                <label class="form-check-label mb-0" for="flexRadioDefault1">Personal Account</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault" checked="checked" />
                                <label class="form-check-label mb-0" for="flexRadioDefault2">Business Account</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input class="form-control" type="file" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-form-textarea">Description</label>
                            <textarea class="form-control" id="basic-form-textarea" rows="3" placeholder="Description"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" id="basic-form-checkbox" type="checkbox" />
                            <label class="form-check-label" for="basic-form-checkbox">Remember me</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
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

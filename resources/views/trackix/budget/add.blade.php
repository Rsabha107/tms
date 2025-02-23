@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h3 class="mb-4">Create new Budget Entries</h3>
                    <div class="d-flex mb-3">
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.budget.list') }}">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <h4 class="mb-3">Budget Information </h4>
            <form action="{{ route ('main.budget.create') }}" class="row g-3 mb-4 needs-validation form-submit" novalidate="" method="post">
                @csrf
                <div class="col-sm-6 col-md-8">
                    <div class="form-floating">
                        <input name="type" class="form-control" id="floatingInputEventName" type="text" placeholder="" required>
                        <label for="floatingInputEventName">Budget type</label>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-floating">
                        <input name="budget_allocation" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="0" required>
                        <label for="floatingInputLinkedin">Amount</label>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <!-- <div class="d-flex flex-wrap mb-2"> -->
                    <a class="fw-bold fs-9" data-bs-toggle="modal" data-bs-target="#addneworg" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" href="#!">Add new organization</a>
                    <!-- </div> -->
                    <div class="form-floating">
                        <select name="org_id" class="form-select" id="floatingSelectHROrganization" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($hr_org as $key => $item )
                            @if (Request::old('id') == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Organization Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a class="fw-bold fs-9" data-bs-toggle="modal" data-bs-target="#addnewbudgetname" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" href="#!">Add new budget</a>

                    <div class="form-floating">
                        <select name="budget_name" class="form-select" id="floatingSelectBudgetName" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($budget_name as $key => $item )
                            @if (Request::old('id') == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Budget Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a class="fw-bold fs-9 invisible" href="#!">.</a>

                    <div class="form-floating">
                        <select name="active_flag" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($active_flag as $key => $item )
                            @if (Request::old('id') == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="date_from" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">From date</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="date_to" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">To date</label>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end mt-6">
                    <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save">Save</button>
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.budget.list') }}">Cancel</a>
                </div>
            </form>
        </div>
        <!-- </div> -->
    </div>

    <div class="modal fade" id="addneworg" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Add new organization</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <div id="add-messages"></div>
                <form class="needs-validation" novalidate="" action="{{ route('main.budget.create.hrorganization') }}" method="POST" id="submitAddHROrganizationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <input class="form-control" type="text" placeholder="Enter name" name="name" id="addName" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="createHROrganizationBtn" data-loading-text="Loading...">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addnewbudgetname" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content bg-100">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal-header bg-modal-header">
                    <h3 class=" text-white mb-0" id="staticBackdropLabel">Add new budget</h3>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
                </div>
                <div id="add-budget-name-messages"></div>
                <form class="needs-validation" novalidate="" action="{{ route('main.budget.create.budgetname') }}" method="POST" id="submitAddBudgetForm">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body px-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label class="text-1000 fw-bold mb-2">Name</label>
                                        <input class="form-control" type="text" placeholder="Enter name" name="name" id="addName" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal" id="submitAddBudgetForm">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="createBudgetNameBtn" data-loading-text="Loading...">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // submit site form
            $("#submitAddHROrganizationForm").unbind('submit').bind('submit', function() {
                // console.log("inserting new HR Organization");
                // submit loading button
                // $("#createHROrganizationBtn").button('loading');

                var form = $(this);
                var formData = new FormData(this);
                console.log("Before Calling ajax");
                console.log(form.attr('action'));
                console.log(form.attr('method'));
                // console.log($('#createHROrganizationBtn').serialize());

                /*                 console.log(formData.get('siteCode'));
                    console.log(formData.get('siteName'));
                    console.log(formData.get('siteStatus')); */
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        console.log(response.name);
                        console.log(response.success);
                        console.log(response.lastInsertId);
                        if (response.success == true) {
                            // submit loading button
                            // $("#createHROrganizationBtn").button('reset');

                            $("#submitAddHROrganizationForm").trigger("reset");

                            $('#add-messages').html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="fa fa-check"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert

                            $("#floatingSelectHROrganization").append("<option selected value='" + response.lastInsertId + "'>" + response.name + "</option>");
                            $('#addneworg').modal('hide');

                        } else {
                            $('#add-messages').html('<div class="alert alert-danger">' +
                                '<strong><i class="far fa-times-circle"></i></strong> ' + response.messages +
                                '</div>');
                        } // /if response.success

                        // remove the mesages
                        $(".alert-danger").delay(500).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        }); // /.alert

                    }, // /success function
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
                        console.log('Error: ' + errorMessage);
                    } // /error function
                }); // /ajax function

                return false;
            }); // /submit HR Org form

            $("#submitAddBudgetForm").unbind('submit').bind('submit', function() {
                // console.log("inserting new Budget Name");
                // submit loading button
                // $("#createBudgetNameBtn").button('loading');

                var form = $(this);
                var formData = new FormData(this);
                console.log("Before Calling ajax");
                console.log(form.attr('action'));
                console.log(form.attr('method'));
                // console.log($('#createHROrganizationBtn').serialize());

                /*                 console.log(formData.get('siteCode'));
                    console.log(formData.get('siteName'));
                    console.log(formData.get('siteStatus')); */
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        console.log(response.name);
                        console.log(response.success);
                        console.log(response.lastInsertId);
                        if (response.success == true) {
                            // submit loading button
                            // $("#createHROrganizationBtn").button('reset');

                            $("#submitAddBudgetForm").trigger("reset");

                            $('#add-budget-name-messages').html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="fa fa-check"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert

                            $("#floatingSelectBudgetName").append("<option selected value='" + response.lastInsertId + "'>" + response.name + "</option>");
                            $('#addnewbudgetname').modal('hide');

                        } else {
                            $('#add-budget-name-messages').html('<div class="alert alert-danger">' +
                                '<strong><i class="far fa-times-circle"></i></strong> ' + response.messages +
                                '</div>');
                        } // /if response.success

                        // remove the mesages
                        $(".alert-danger").delay(500).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        }); // /.alert

                    }, // /success function
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
                        console.log('Error: ' + errorMessage);
                    } // /error function
                }); // /ajax function

                return false;
            }); // /submit HR Org form
        });
    </script>



    @endpush

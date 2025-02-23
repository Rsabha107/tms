<!-- <form class="row g-3  px-3 needs-validation form-submit-event" id="edit_employee_form" novalidate="" action="{{ route ('tracki.employee.store') }}" method="POST"> -->
<!-- @csrf -->

<!-- <script src="{{asset('assets/js/custom.js')}}"></script> -->
<script src="{{ asset ('assets/tracki/js/phoenix.js') }}"></script>
<!-- <script src="{{asset('assets/js/pages/employees.js')}}"></script> -->


<!-- <form class="row g-3  px-3 needs-validation form-submit-event" id="add_employee_form" novalidate="" action="{{ route ('tracki.employee.store') }}" method="POST"> -->
<!-- @csrf -->

    <!-- <form class="row g-3  px-3 needs-validation form-submit-event" id="add_employee_form" novalidate="" action="{{ route ('tracki.employee.store') }}" method="POST"> -->
    @csrf

    <input type="hidden" id="add_employee_id_h" name="id" value="{{$emp->id}}">
    <input type="hidden" id="add_employee_table_h" name="table" value="employee_table">

    <div class="modal-body">
        <div class="row">
            <!-- begining of left div -->
            <div class="col-md-8">
                <div class="mb-3 row">

                    <div class="col-md-6">
                        <label class="form-label" for="inputAddress">Prefix</label>
                        <select name="salutation" class="form-select" id="edit_employee_salutation">
                            <option selected="selected" value="">Select...</option>
                            @foreach ($salutations as $key => $item )
                            @if ($emp->salutation == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->title }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">National Identificaton Number</label>
                        <input name="national_identifier_number" id="add_employee_national_identifier_number" class="form-control" type="text" placeholder="" value="{{$emp->national_identifier_number}}">
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-12">
                        <label class="form-label" for="inputEmail4">First Name</label>
                        <input name="first_name" id="edit_employee_first_name" class="form-control" type="text" placeholder="" value="{{$emp->first_name}}" required>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="inputEmail4">Middle Name</label>
                        <input name="middle_name" id="edit_employee_middle_name" class="form-control" value="{{$emp->middle_name}}" type="text" placeholder="">
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="inputEmail4">Last Name</label>
                        <input name="last_name" id="edit_employee_last_name" class="form-control" type="text" placeholder="" value="{{$emp->last_name}}" required>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Personal Email</label>
                        <input name="personal_email_address" id="edit_personal_email_address" class="form-control" type="text" placeholder="" value="{{$emp->personal_email_address}}" required>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Work Email</label>
                        <input name="work_email_address" id="edit_work_email_address" class="form-control" type="text" placeholder="" value="{{$emp->work_email_address}}">
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Department</label>
                        <select class="form-select" name="department_id" id="edit_department_id" required>
                            <option value="">Select...</option>
                            @foreach ($departments as $key => $item )
                            @if ($emp->department_id == $item->id )
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
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Designation</label>
                        <select class="form-select" name="designation_id" id="edit_designation_id" required>
                            <option value="">Select...</option>
                            @foreach ($designations as $key => $item )
                            @if ($emp->designation_id == $item->id )
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
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Phone</label>
                        <input name="phone_number" id="edit_employee_phone_number" class="form-control" type="text" placeholder="" value="{{$emp->phone_number}}" required>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Alternate Phone</label>
                        <input name="alt_phone_number" id="edit_employee_alt_phone_number" class="form-control" type="text" value="{{$emp->alt_phone_number}}" placeholder="">
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Birth Date</label>
                        <input class="form-control datetimepicker" id="edit_employee_date_of_birth" data-target="#floatingInputStartDate" name="date_of_birth" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($emp->date_of_birth)->format('d/m/Y') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Town of birth</label>
                        <input name="town_of_birth" id="edit_employee_town_of_birth" class="form-control" type="text" placeholder="" value="{{$emp->town_of_birth}}" >
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Hire Date</label>
                        <input class="form-control datetimepicker" id="edit_employee_date_of_hire" data-target="#floatingInputStartDate" name="date_of_hire" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($emp->date_of_hire)->format('d/m/Y') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="inputEmail4">Joining Date</label>
                        <input class="form-control datetimepicker" id="edit_employee_join_date" data-target="#floatingInputStartDate" name="join_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($emp->join_date)->format('d/m/Y') }}" required>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                </div>
            </div>
            <!-- end of left div -->

            <!-- begining of right div -->
            <div class="col-md-4">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="bootstrap-wizard-validation-gender">Employee Type</label>
                    <select class="form-select" name="employee_type" id="add_employee_employee_type" required="required">
                        <option value="">Select ...</option>
                        @foreach ($employee_types as $key => $item )
                        @if ($emp->employee_type == $item->id )
                        <option value="{{ $item->id  }}" selected>
                            {{ $item->title }}
                        </option>
                        @else
                        <option value="{{ $item->id  }}">
                            {{ $item->title }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    <!-- <div class="invalid-feedback">This field is required.</div> -->
                </div>

                <div class="mb-3 row">

                    <div class="col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender">Report to</label>
                        <select class="form-select" name="reporting_to_id" id="add_employee_reporting_to_id" >
                            <option value="">Select ...</option>
                            @foreach ($emps as $key => $item )
                            @if ($emp->reporting_to_id == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->first_name}} {{$item->last_name }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->first_name}} {{$item->last_name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender">Gender</label>
                        <select class="form-select" name="gender" id="add_employee_gender" required="required">
                            <option value="">Select ...</option>
                            @foreach ($genders as $key => $item )
                            @if ($emp->gender == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->title }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender">Marital Status</label>
                        <select class="form-select" name="marital_status" id="add_employee_marital_status" required="required">
                            @foreach ($marital_statuses as $key => $item )
                            @if ($emp->marital_status == $item->id )
                            <option value="{{ $item->id  }}" selected>
                                {{ $item->title }}
                            </option>
                            @else
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <!-- <div class="invalid-feedback">This field is required.</div> -->
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender">Country of birth</label>
                        <select class="form-select" name="country_of_birth" id="add_employee_country_of_birth" required="required">
                            <option value="">Select ...</option>
                            @foreach ($countries as $key => $item )
                            @if ($emp->country_of_birth == $item->id )
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
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="bootstrap-wizard-validation-gender">Nationality</label>
                        <select class="form-select" name="nationality" id="add_employee_nationality" required="required">
                            <option value="">Select ...</option>
                            @foreach ($nationalities as $key => $item )
                            @if ($emp->nationality == $item->id )
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

                    <div class="col-md-auto mb-3">
                        <div class="dz-preview dz-preview-single">
                            <div class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                <div class="avatar avatar-4xl"><img id="edit_showImage" class="rounded-circle avatar-placeholder" src="{{(!empty($emp->emp_files->file_name)) ? url($emp->emp_files->file_path.$emp->emp_files->file_name) : url('upload/no_image.jpg')}}" alt="..." data-dz-thumbnail="data-dz-thumbnail" /></div>
                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control form-control-sm" type="file" name="profile_image_name" id="edit_profile_image_name" />
                    </div>
                </div>
            </div>
            <!-- end of right div -->
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= get_label('close', 'Close') ?></label></button>
        <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('save', 'Save') ?></label></button>
    </div>
    <!-- </form> -->

    <script>
            $('#edit_profile_image_name').change(function(e) {
        console.log('inside edit profile_image_name')
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#edit_showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
    </script>

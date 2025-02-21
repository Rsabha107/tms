@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">
@php
        $required = null;
@endphp
@if (config('tracki.project_strict_save'))
    @php
        $required = '$required';
    @endphp
@endif

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h2 class="mb-4">{{__('traki.project.create_form_title')}}</h2>
                    <div class="d-flex mb-3">
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.project.show.card') }}">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <h4 class="mb-3">Information </h4>
            <form action="{{ route ('main.project.create') }}" class="row g-3 mb-9 needs-validation" novalidate="" method="post">
                @csrf
                <div class="col-sm-6 col-md-8">
                    <div class="form-floating">
                        <input name="name" class="form-control" id="floatingInputEventName" type="text" placeholder="" required>
                        <label for="floatingInputEventName">{{__('traki.project.name_field')}}</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="project_type" class="form-select" id="floatingSelectOwner" required>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($project_type as $key => $item )
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
                        <label for="floatingSelectOwner">Project Type</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="functional_area_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($functional_area as $key => $item )
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
                        <label for="floatingSelectOwner">Functional Area</label>
                    </div>
                </div> -->
                <!-- <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="operation_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($operation as $key => $item )
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
                        <label for="floatingSelectOwner">Operation</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="segment_id" class="form-select" id="floatingSelectOwner">
                            <option selected="selected" value=""> Select </option>
                            @foreach ($segment as $key => $item )
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
                        <label for="floatingSelectOwner">Segment</label>
                    </div>
                </div> -->

                <!-- <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="fund_category_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($fund_category as $key => $item )
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
                        <label for="floatingSelectOwner">Fund</label>
                    </div>
                </div> -->

                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="category_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_category as $key => $item )
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
                        <label for="floatingSelectOwner">Category</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="audience_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_audience as $key => $item )
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
                        <label for="floatingSelectOwner">Audience</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="planner_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_planner as $key => $item )
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
                        <label for="floatingSelectOwner">Planner</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="venue_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_venue as $key => $item )
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
                        <label for="floatingSelectOwner">Venue</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="location_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_location as $key => $item )
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
                        <label for="floatingSelectOwner">Location</label>
                    </div>
                </div>
                <div class="col-sm-3 col-md-4">
                    <div class="form-floating">
                        <input name="attendance_forcast" class="form-control" id="floatingInputAttendanceForcast" type="number" placeholder="employees" value="0" {{$required}}>
                        <label for="floatingInputAttendanceForcast">Attendance forcast</label>
                    </div>
                </div>
                <h4 class="mt-6">Schedule</h4>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">Start date</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="start_time" class="form-control datetimepicker" id="timepicker1" type="text" {{$required}} placeholder="hour : minute" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'>
                        <label for="floatingInputStartTime">Start time</label>
                    </div>
                </div> -->
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="end_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">End date</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="end_time" class="form-control datetimepicker" id="timepicker1" type="text" placeholder="hour : minute" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' {{$required}}>
                        <label for="floatingInputStartTime">End time</label>
                    </div>
                </div> -->
                <h4 class="mt-6">Other Information</h4>

                <div class="col-sm-6 col-md-3">
                    <div class="form-floating">
                        <select name="fund_category_id" class="form-select" id="floatingSelectFund" required>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($fund_category as $key => $item )
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
                        <label for="floatingSelectOwner">Fund</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-floating">
                        <select name="budget_name_id" class="form-select" id="floatingSelectBudgetName" {{$required}}>
                            <option selected="selected" value=""> Select </option>
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
                        <label for="floatingSelectOwner">Budget Name</label>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="form-floating">
                        <input name="budget_allocation" class="form-control" id="floatingInputBudgetAllocation" type="number" step="0.01" placeholder="linkedin" value="0" {{$required}}>
                        <label for="floatingInputBudgetAllocation">Budget allocation</label>
                    </div>
                </div>
                <!-- <div class="col-sm-3 col-md-3">
                    <div class="form-floating">
                        <input name="attendance_forcast" class="form-control" id="floatingInputAttendanceForcast" type="number" placeholder="employees" value="0" {{$required}}>
                        <label for="floatingInputAttendanceForcast">Attendance forcast</label>
                    </div>
                </div> -->
                <div class="col-sm-3 col-md-3">
                    <div class="form-floating">
                        <input name="project_sales" class="form-control" id="floatingInputProjectSales" type="number" step="0.01" placeholder="employees" value="0" {{$required}}>
                        <label for="floatingInputProjectSales">Total Sales</label>
                    </div>
                </div>
                <!-- <div class="col-sm-3 col-md-3">
                    <div class="form-floating">
                        <select name="status" class="form-select" id="floatingSelectRating" {{$required}}>
                            <option selected="selected" value="">Select</option>
                            @foreach ($event_status as $key => $item )
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
                        <label for="floatingSelectRating">status</label>
                    </div>
                </div> -->

                @if (config('tracki.show_project_status_field'))
                <h4 class="mt-6">Configuration</h4>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="progress" class="form-control" id="floatingInputLinkedin" type="number" placeholder="linkedin" value="0" {{$required}}>
                        <label for="floatingInputLinkedin">Progress %</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <select name="status" class="form-select" id="floatingSelectRating" {{$required}}>
                            <option selected="selected" value="">Select</option>
                            @foreach ($event_status as $key => $item )
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
                        <label for="floatingSelectRating">status</label>
                    </div>
                </div>
                @endif
                <h4 class="mt-6">Description</h4>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea {{$required}} name="description" class="form-control " id="floatingProjectOverview" data-tinymce="{}" placeholder="Leave a comment here" style="height: 128px"></textarea>
                        <label for="floatingProjectOverview"></label>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end mt-6">
                    <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button>
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.project.show.card') }}">Cancel</a>

                    <!-- <button class="btn btn-primary action"  type="submit" value="publish">Publish</button> -->
                </div>
            </form>
        </div>

        <!-- </div> -->
    </div>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')

    <script>
        $(document).ready(function() {
            // console.log('edit project blade ')
            console.log('fund name: ' + $("#floatingSelectFund").val())
            console.log('{{$required}}');

            if ($("#floatingSelectFund").val() == 2) {
                console.log('in fund = 2')
                $("#floatingSelectBudgetName").prop('required', false);
                $("#floatingSelectBudgetName").prop('disabled', true);
            } else {
                console.log('in fund = 1')
                $("#floatingSelectBudgetName").prop('required', true);
                $("#floatingSelectBudgetName").prop('disabled', false);
            }

            $("#floatingSelectFund").change(function() {
                // console.log('changing fund type')
                if ($("#floatingSelectFund").val() == 2) {
                    // console.log('in fund = 2')
                    $("#floatingSelectBudgetName").prop('required', false);
                    $("#floatingSelectBudgetName").prop('disabled', true);
                } else {
                    // console.log('in fund = 1')
                    $("#floatingSelectBudgetName").prop('required', true);
                    $("#floatingSelectBudgetName").prop('disabled', false);
                }
            });

            $("#FASelect").show();
            $("#DepartmentSelect").hide();
            $("#floatingSelectDepartment").prop('required', false);
            $("#floatingSelectFA").prop('required', true);
            $("input[name=usertype]").change(function() {
                console.log('usertype changing')
                if ($("#faUser").is(':checked')) {
                    $("#FASelect").show();
                    $("#DepartmentSelect").hide();
                    $("#floatingSelectDepartment").prop('required', false);
                    $("#floatingSelectFA").prop('required', true);

                } else {
                    $("#DepartmentSelect").show();
                    $("#FASelect").hide();
                    $("#floatingSelectFA").prop('required', false);
                    $("#floatingSelectDepartment").prop('required', true);

                }
            });
        });
    </script>

    @endpush

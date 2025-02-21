@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h2 class="mb-4">Edit Project ({{ $eventData->name}})</h2>
                    <div class="d-flex mb-3">
                        <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ ($source == 'plist'?route('main.task.list', $eventData->id):($source == 'list'? route('main.project.show.list'):route('main.project.show.card'))) }}">Cancel</a>
                        <!-- <button class="btn btn-primary"  type="submit">Create Event</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $required = null;
    @endphp
    @if (config('tracki.project_strict_save'))
    @php
    $required = '$required';
    @endphp
    @endif
    <div class="row">
        <div class="col-xl-8">
            <h4 class="mb-3">Event Information </h4>
            <form action="{{ route ('main.project.update') }}" class="row g-3 mb-9 needs-validation" novalidate="" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $eventData->id }}">
                <input type="hidden" name="source" value="{{ $source }}">
                <div class="col-sm-6 col-md-8">
                    <div class="form-floating">
                        <input name="name" class="form-control" id="floatingInputEventName" type="text" placeholder="" value="{{ $eventData->name }}" required>
                        <label for="floatingInputEventName">name</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="functional_area_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($functional_area as $key => $item )
                            @if ($eventData->functional_area_id == $item->id )
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
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="operation_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($operation as $key => $item )
                            @if ($eventData->operation_id == $item->id )
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
                            @if ($eventData->segment_id == $item->id )
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
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="project_type_id" class="form-select" id="floatingSelectOwner" required>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($project_type as $key => $item )
                            @if ($eventData->project_type_id == $item->id )
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
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="category_id" class="form-select" id="floatingSelectOwner" {{$required}}>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($event_category as $key => $item )
                            @if ($eventData->category_id == $item->id )
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
                            @if ($eventData->audience_id == $item->id )
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
                            @if ($eventData->planner_id == $item->id )
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
                            @if ($eventData->venue_id == $item->id )
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
                            @if ($eventData->location_id == $item->id )
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
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <input name="attendance_forcast" class="form-control" id="floatingInputEmployees" type="number" placeholder="employees" value="{{ $eventData->attendance_forcast }}" {{$required}}>
                        <label for="floatingInputEmployees">Attendance forcast</label>
                    </div>
                </div>
                <h4 class="mt-6">Schedule</h4>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="start_date" type="text" placeholder="dd/mm/yyyy" data-options='{"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($eventData->start_date)->format('d/m/Y') }}" required>
                        <label for="floatingInputStartDate">Start date</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="start_time" class="form-control datetimepicker" id="timepicker1" type="text" {{$required}} placeholder="hour : minute" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' value="{{ \Carbon\Carbon::parse($eventData->start_time)->format('H:i') }}">
                        <label for="floatingInputStartTime">Start time</label>
                    </div>
                </div> -->
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="end_date" type="text" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($eventData->end_date)->format('d/m/Y') }}" required>
                        <label for="floatingInputStartDate">End date</label>
                    </div>
                </div>
                <!-- <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="end_time" class="form-control datetimepicker" id="timepicker1" type="text" placeholder="hour : minute" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' {{$required}} value="{{ \Carbon\Carbon::parse($eventData->end_time)->format('H:i') }}">
                        <label for="floatingInputStartTime">End time</label>
                    </div>
                </div> -->
                <h4 class="mt-6">Other Information</h4>
                <div class="col-sm-6 col-md-3">
                    <div class="form-floating">
                        <select name="fund_category_id" class="form-select" id="floatingSelectFund" required>
                            <option selected="selected" value=""> Select </option>
                            @foreach ($fund_category as $key => $item )
                            @if ($eventData->fund_category_id == $item->id )
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
                        <select name="budget_name_id" class="form-select" id="floatingSelectBudgetName">
                            <option selected="selected" value=""> Select </option>
                            @foreach ($budget_name as $key => $item )
                            @if ($eventData->budget_name_id == $item->id )
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
                <div class="col-sm-6 col-md-3">
                    <div class="form-floating">
                        <input name="budget_allocation" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="{{ $eventData->budget_allocation }}" {{$required}}>
                        <label for="floatingInputLinkedin">Budget allocation</label>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="form-floating">
                        <input name="project_sales" class="form-control" id="floatingInputProjectSales" type="number" step="0.01" placeholder="employees" value="{{ $eventData->total_sales }}" {{$required}}>
                        <label for="floatingInputProjectSales">Total Sales</label>
                    </div>
                </div>
                @if (config('tracki.show_project_status_field'))
                <h4 class="mt-6">Configuration</h4>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <input name="progress" class="form-control" id="floatingInputLinkedin" type="number" placeholder="linkedin" value="{{ $eventData->progress*100 }}" {{$required}}>
                        <label for="floatingInputLinkedin">Progress %</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="status" class="form-select" id="floatingSelectRating" {{$required}}>
                            <option selected="selected" value="">Select</option>
                            @foreach ($event_status as $key => $item )
                            @if ($eventData->event_status == $item->id )
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
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="color_id" class="form-select" id="floatingSelectRating" {{$required}}>
                            <option selected="selected" value="">Select</option>
                            @foreach ($event_color as $key => $item )
                            @if ($eventData->color_id == $item->id )
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
                        <label for="floatingSelectRating">Color</label>
                    </div>
                </div>
                @endif
                <h4 class="mt-6">Description</h4>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea {{$required}} name="description" class="form-control " id="floatingProjectOverview" data-tinymce="{}" placeholder="Leave a comment here" style="height: 128px">{{ $eventData->description }}</textarea>
                        <label for="floatingProjectOverview"></label>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end mt-6">
                    <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button>
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ ($source == 'plist'?route('main.task.list', $eventData->id):route('main.project.show.card')) }}">Cancel</a>
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
            console.log('edit project blade ')
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
                    // $('#floatingSelectBudgetName').empty();
                    $('#floatingSelectBudgetName').append('<option value="" selected>~~SELECT~~</option>');
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

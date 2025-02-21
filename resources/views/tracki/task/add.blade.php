@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h3 class="mb-4">Create a new task for {{Session::get('record_type')}} ( {{$eventData->name}} )</h3>
                    <div class="d-flex mb-3">
                        <!-- <button class="btn btn-success action" type="submit" value="save">Save</button> -->
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.task.list',$event_id) }}">Cancel</a>
                        <!-- <button class="btn btn-primary"  type="submit">Create Event</button> -->
                    </div>
                </div>
                <h5 class="mb-4">{{\Carbon\Carbon::parse($eventData->start_date)->format('d-M-Y')}} to
                    {{\Carbon\Carbon::parse($eventData->end_date)->format('d-M-Y')}}
                </h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <!-- <div class="d-flex align-items-end position-relative mb-7">
              <input class="d-none" id="upload-avatar" type="file" />
              <div class="hoverbox" style="width: 150px; height: 150px">
                <div class="hoverbox-content bg-black rounded-circle d-flex flex-center z-index-1" style="--phoenix-bg-opacity: .56;"><span class="fa-solid fa-camera fs-7 text-300"></span></div>
                <div class="position-relative bg-400 rounded-circle cursor-pointer d-flex flex-center mb-xxl-7">
                  <div class="avatar avatar-5xl"><img class="rounded-circle" src="../../assets/img/team/150x150/58.webp" alt="" /></div>
                  <label class="w-100 h-100 position-absolute z-index-1" for="upload-avatar"></label>
                </div>
              </div>
            </div> -->
            <h4 class="mb-3">Task Information </h4>
            <form action="{{ route ('main.event.task.create') }}" class="row g-1 mb-9 needs-validation form-submit" novalidate="" method="post">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="col-sm-6 col-md-8">
                    <div class="form-floating">
                        <input name="name" class="form-control" id="floatingInputEventName" type="text" placeholder="" required>
                        <label for="floatingInputEventName">Task name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="status_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($task_status as $key => $item )
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
                <h4 class="mt-4">Schedule</h4>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">Start date</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="due_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                        <label for="floatingInputStartDate">End date</label>
                    </div>
                </div>
                <h4 class="mt-4">Assignment</h4>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="department_assignment_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($department as $key => $item )
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
                        <label for="floatingSelectRating">Department</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="assignment_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($person as $key => $item )
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
                        <label for="floatingSelectRating">Assigned by</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required>
                            <option value="">Select Assinged to</option>
                            @foreach ($person as $key => $item )
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
                        <!-- <label for="floatingSelectRating">Assigned to</label> -->
                    </div>
                </div>

                <h5 class="mt-4">Fund Information</h5>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="budget_allocation" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="0" required>
                        <label for="floatingInputLinkedin">Task Budget allocation</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="actual_budget_allocated" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="0" required>
                        <label for="floatingInputLinkedin">Actual Budget allocated</label>
                    </div>
                </div>
                @if (config('tracki.show_task_progress'))
                <h4 class="mt-6">Configuration</h4>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input name="progress" class="form-control" id="floatingInputLinkedin" type="number" placeholder="linkedin" value="0" required>
                        <label for="floatingInputLinkedin">Progress %</label>
                    </div>
                </div>
                @endif
                <!-- <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <select name="color_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($event_color as $key => $item )
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
                        <label for="floatingSelectRating">Color</label>
                    </div>
                </div> -->

                <h4 class="mt-4">Description</h4>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea required name="description" class="form-control " id="floatingProjectOverview" data-tinymce="{}" placeholder="Leave a comment here" style="height: 128px"></textarea>
                        <label for="floatingProjectOverview"></label>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end mt-6">
                    <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save">Save</button>
                    <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.task.list',$event_id) }}">Cancel</a>
                    <!-- <button class="btn btn-primary action" type="submit" value="publish">Publish</button> -->
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


    @endpush

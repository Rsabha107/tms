@extends('tracki.event.layout.event-add-layout')
@section('main')

<div class="content">
    <div class="row g-4 g-xl-0 mt-3">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.project.show.card')}}"><?= get_label('task', 'Tasks') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('tracki.project.show.card')}}"><?= get_label('information', 'Information') ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$taskData->name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">


                <div class="row g-0">
                    <div class="col-12 col-xxl-12 px-0 bg-white border-xxl border-top-sm">
                        <div class="px-4 px-lg-6 pt-6 pb-9">

                            <div class="border-bottom mb-7 mx-n3 px-2 px-lg-6">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="d-sm-flex justify-content-between">
                                            <h3 class="mb-4">Edit task ( {{$taskData->name}} )</h3>
                                            <div class="d-flex mb-3">
                                                <a class="btn btn-subtle-danger me-1 mb-1" href="{{ route('tracki.task.list',$taskData->event_id) }}">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <form action="{{ route ('tracki.task.update') }}" class="row g-3 mb-9 needs-validation form-submit" novalidate="" method="post">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $taskData->event_id }}">
                                        <input type="hidden" name="id" value="{{ $taskData->id }}">
                                        <div class="col-sm-6 col-md-6">
                                            <label class="form-label" for="exampleFormControlInput">Title </label>
                                            <input name="name" class="form-control" id="exampleFormControlInput" type="text" value="{{ $taskData->name }}" required>
                                            <!-- <div class="form-floating">
                                                <input name="name" class="form-control" id="floatingInputEventName" type="text" placeholder="" value="{{ $taskData->name }}" required>
                                                <label for="floatingInputEventName">Task name</label>
                                            </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingSelectRating">Assign to</label>

                                            <select name="assignment_to_id[]" class="form-select" data-choices="data-choices" size="1" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' id="floatingSelectRating" required>
                                                <option value="">Select assigned to</option>
                                                @foreach ($users as $key => $item )
                                                @if (in_array($item->id, old('assignment_to_id') ? old('assignment_to_id') : explode(',', $taskData->assignment_to_id)))
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
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingInputStartDate">Start date</label>
                                            <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="start_date" type="text" placeholder="dd/mm/yyyy" data-options='{"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($taskData->start_date)->format('d/m/Y') }}" required>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingInputStartDate">End date</label>
                                            <input class="form-control datetimepicker" id="floatingInputStartDate" data-target="#floatingInputStartDate" name="due_date" type="text" placeholder="dd/mm/yyyy" data-options='{"dateFormat":"d/m/Y"}' value="{{ \Carbon\Carbon::parse($taskData->due_date)->format('d/m/Y') }}" required>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingSelectRating">Project</label>
                                            <select name="project_id" class="form-select" id="floatingSelectRating" required>
                                                <option selected="selected" value="">Select</option>
                                                @foreach ($project as $key => $item )
                                                @if ($taskData->event_id == $item->id )
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
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingSelectRating">Department</label>
                                            <select name="department_assignment_id" class="form-select" id="floatingSelectRating" required>
                                                <option selected="selected" value="">Select</option>
                                                @foreach ($departments as $key => $item )
                                                @if ($taskData->department_assignment_id == $item->id )
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
                                            <!-- <label for="floatingSelectRating">Department</label> -->
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <label class="form-label" for="exampleFormControlInput">Status </label>

                                            <!-- <div class="form-floating"> -->
                                            <select name="status_id" class="form-select" id="floatingSelectRating" required>
                                                <option selected="selected" value="">Select</option>
                                                @foreach ($task_status as $key => $item )
                                                @if ($taskData->status_id == $item->id )
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
                                            <!-- <label for="floatingSelectRating">status</label> -->
                                            <!-- </div> -->
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingSelectRating">Task Budget allocation</label>
                                            <input name="budget_allocation" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="{{ $taskData->budget_allocation }}" required>
                                            <!-- <label for="floatingInputLinkedin">Task Budget allocation</label> -->
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingInputLinkedin">Actual Budget allocated</label>
                                            <input name="actual_budget_allocated" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="{{ $taskData->actual_budget_allocated }}" required>
                                            <!-- </div> -->
                                        </div>
                                        <!-- <h4 class="mt-6">Description</h4> -->
                                        <div class="col-12">
                                            <!-- <div class="form-floating"> -->
                                            <label class="form-label" for="floatingInputLinkedin">Description</label>
                                            <textarea required name="description" class="form-control tinymce" id="floatingProjectOverview" data-tinymce="{}" placeholder="Leave a comment here" style="height: 128px">{{ strip_tags($taskData->description) }}</textarea>
                                            <!-- <label for="floatingProjectOverview"></label> -->
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-6">
                                            <button class="btn btn-subtle-primary me-1 mb-1 action button-submit" type="submit" value="save">Save</button>
                                            <a class="btn btn-subtle-danger me-1 mb-1" href="{{ route('tracki.task.list',$taskData->event_id) }}">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                <x-task-notes-card :tasks="$taskData" />
                                </div>
                                <div class="col-xl-6">
                            <x-task-files-card :tasks="$taskData" />
                                </div>
                            </div>


                            <!-- <p class="text-body-secondary mb-0">Join us in celebrating the massive success of data transferring and getting us a huge revenue by eating out. Free public viewing and a buffet is offered for the great team as well as for the other teams working with us. We’ll be checking out places for the best option available at hands and we’ll let you know the schedule once we decide on one.<a class="fw-semibold" href="#!">read more </a></p> -->
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        @endsection

        @push('script')


        @endpush

@extends('main.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="mt-4">
        <div class="row g-4">
            <!-- this controls the size of the table  -->
            <div class="col-12 col-sm-12 order-1 order-xl-0">
                <div class="mb-9">

                    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="col-12 col-md">
                                    <h2 class="text-900 mb-0" ><span class="uil fs-5 lh-1 uil-ambulance text-danger px-2"></span>ALL Tasks</h2>
                                </div>
                                <div class="col col-md-auto">
                                    <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                        <!-- <button class="btn btn-primary me-4" type="button" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" aria-haspopup="true" aria-expanded="false"
                                            data-bs-reference="parent"><span class="fas fa-plus me-2"></span>Add
                                            Deal</button> -->
                                        <!-- <a class="btn btn-sm btn-phoenix-primary preview-btn ms-2" href="{{ route('main.sec.adminuser.add')}}"><span class="fa-solid fa-add"></span>Add</a> -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="collapse code-collapse" id="ajax-table-code">
                                <pre class="scrollbar" style="max-height:420px"><code class="language-html"></code></pre>
                            </div>
                            <div class="p-4 code-to-copy">
                                <div class="table-list">
                                    <div class="table-responsive scrollbar mb-3">
                                        <table class="table table-sm table-bordered table-responsive fs--1 mb-0 overflow-hidden" id="dataList">
                                            <thead class="text-900 thead">
                                                <tr>
                                                    <th class="sort align-middle text-end" scope="col" style="width:1%;">SL</th>
                                                    <th class="sort white-space-nowrap align-middle ps-2" scope="col" data-sort="name" style="width:10%;">PROJECT</th>
                                                    <th class="sort white-space-nowrap align-middle ps-2" scope="col" data-sort="name" style="width:10%;">TASK</th>
                                                    <th class="sort white-space-nowrap align-middle ps-5" scope="col" data-sort="department" style="width:15%;">DEPARTMENT</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNED BY</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNED TO</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:10%;">DEADLINE</th>
                                                    <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:10%;">BUDGET</th>
                                                    <!-- <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:1%;">PROGRESS</th> -->
                                                    <th class="sort align-middle text-center" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                                                    <th class="sort align-middle text-start ps-4" scope="col" data-sort="description" style="width:52%; max-width: 100px;">DESCRIPTION</th>
                                                    <!-- <th class="sort align-middle text-end" scope="col" style="width:10%;"></th> -->
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="order-table-body">
                                                @foreach ($taskData as $key => $item )
                                                @php
                                                $assigntonames = App\Http\Controllers\UtilController::getAssignedToName($item->assignment_to_id);
                                                $asg_to_names = '';
                                                foreach($assigntonames as $key1 => $item1){
                                                $asg_to_names = $asg_to_names.', '. $item1->assigned_to_name;
                                                }
                                                $asg_to_names = ltrim($asg_to_names, ',');
                                                @endphp
                                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0"><a href="#!"><span class="fas fa-paperclip me-1"></span><span class="fas fa-file-alt me-1"></span></a>
                                                    </td>
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0"><a href="{{route('main.task.list', $item->event_id)}}" id="taskCardView" data-id="{{$item->id}}" data-assignees="{{ $asg_to_names }}"> {{$item->project_name}}</a></td>
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0">{{$item->task_name}}</td>
                                                    <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0 ms-5">{{$item->department_name}}</a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-2"><a class="d-flex align-items-center text-900" href="#!">
                                                            <!-- <div class="avatar avatar-m">
                                                                <div class="avatar-name rounded-circle"><span>{{substr($item->person_name, 0, 1)}}</span></div>
                                                            </div> -->
                                                            <p class="mb-0 ms-3 text-900"> {{$item->person_name}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-wrap ps-2"><a class="d-flex align-items-center text-900" href="#!">
                                                            <!-- <div class="avatar avatar-m">
                                                                <div class="avatar-name rounded-circle"><span>{{substr($asg_to_names, 1, 1)}}</span></div>
                                                            </div> -->
                                                            <p class="mb-0 ms-3 text-900"> {{$asg_to_names}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-1">
                                                        <p class="mb-0 ms-3 fs--1 text-900"> {{\Carbon\Carbon::parse($item->start_date)->format('d-M-Y')}}</p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-0 text-900"> {{\Carbon\Carbon::parse($item->due_date)->format('d-M-Y')}} </p>
                                                        </a>
                                                    </td>
                                                    <td class="customer align-middle white-space-nowrap ps-3">
                                                        <p class="mb-0 ms-3 text-900"> {{$item->actual_budget_allocated}}</p>
                                                        </a>
                                                    </td>
                                                    <!-- <td class="align-middle white-space-nowrap ps-3 projectprogress">
                                                        <p class="text-800 fs--2 mb-0">{{$item->progress*100}}%</p>
                                                        <div class="progress" style="height:3px;">
                                                            <div class="progress-bar bg-success" style="width: {{$item->progress*100}}%" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$item->progress*100}}%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </td> -->
                                                    @if ($item->status_name === 'Completed')
                                                    @php
                                                    $badge_color = 'badge-phoenix-success'
                                                    @endphp
                                                    @else
                                                    @php
                                                    $badge_color = 'badge-phoenix-secondary'
                                                    @endphp
                                                    @endif
                                                    @php
                                                    $taskDateDiff = App\Http\Controllers\UtilController::getDateDiff($item->start_date, $item->due_date);
                                                    if (($item->status_name != 'Completed') && ($taskDateDiff <= 3)){ $badge_color='badge-phoenix-danger' ; } @endphp <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-700">
                                                        <span class="badge badge-phoenix fs--2 {{$badge_color}} ms-5"><span class="badge-label">{{$item->status_name}}</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>
                                                        </td>

                                                        <td class="align-middle white-space-wrap text-700 fs--1 ps-4 text-start">
                                                            <p class="longname">{{ $item->description }}</p>
                                                        </td>
                                                        <!-- <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>

                                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                                @if (Auth::user()->can('task.edit'))
                                                                <a class="dropdown-item" href="{{ route('main.task.edit',$item->id) }}">Edit</a>
                                                                @endif
                                                                <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#progressModal" id="editTaskProgress" data-id="{{ $item->id }}" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Progress</a>
                                                                <a href="#!" id="addTaskNote" data-id="{{ $item->id }}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addTaskNoteModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Add a note</a>
                                                                <a href="#!" id="addTaskAttch" data-id="{{ $item->id }}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addAttachementTaskModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">Upload a file</a>
                                                                @if (Auth::user()->can('task.delete'))
                                                                <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="{{ route('main.task.delete',$item->id)}}" id="delete">Remove</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- add event modal 1-->
    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">Launch demo modal 2</button> -->



    @endsection

    @push('script')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#dataList').DataTable({
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdf',
                //     // 'colvis'
                // ]
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 5]
                            }
                        },
                        'colvis'
                    ],
                }]
            });
        });
    </script>

    @include('main.partials.event-js')

    @endpush

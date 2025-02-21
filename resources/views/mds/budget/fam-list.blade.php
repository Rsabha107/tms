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
                                    <h2 class="text-900 mb-0" ><span class="uil fs-5 lh-1 uil-calculator text-info px-2"></span>Budget Functional Area Mapping</h2>
                                </div>
                                <div class="col col-md-auto">
                                    <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                        <!-- <button class="btn btn-primary me-4" type="button" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" aria-haspopup="true" aria-expanded="false"
                                            data-bs-reference="parent"><span class="fas fa-plus me-2"></span>Add
                                            Deal</button> -->
                                        <a class="btn btn-sm btn-phoenix-primary preview-btn ms-2" href="{{ route('main.budget.fam.add')}}"><span class="fa-solid fa-add"></span>Add</a>
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
                                        <table class="table table-sm table-responsive fs--1 mb-0 overflow-hidden" id="dataList">
                                            <thead class="text-900 thead">
                                                <tr>
                                                    <th class="sort white-space-wrap align-middle ps-2" scope="col" data-sort="name" style="width:15%;">BUDGET NAME</th>
                                                    <th class="sort white-space-wrap align-middle ps-2" scope="col" data-sort="name" style="width:10%;">FA NAME</th>
                                                    <th class="sort white-space-wrap align-middle ps-5" scope="col" data-sort="name" style="width:5%;">STATUS</th>
                                                    <th class="sort align-middle text-end" scope="col" style="width:5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="order-table-body">
                                                @foreach ($data as $key => $item )
                                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0"> {{$item->budget_name}}</td>
                                                    <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0"> {{$item->fa_name}}</td>
                                                    @if ( $item->active_flag_id == 1)
                                                    <td><span class="align-middle  badge badge-phoenix badge-phoenix-success">Active</span>
                                                    </td>
                                                    @else
                                                    <td><span class="align-middle badge badge-phoenix badge-phoenix-warning">Inactive</span>
                                                    </td>
                                                    @endif
                                                    <!-- <td class="align-middle time white-space-wrap ps-2 projectName py-4 fw-bold fs-0">{{$item->active_flag}}</td> -->
                                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                                            <div class="font-sans-serif btn-reveal-trigger position-static">
                                                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>

                                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                                    @if (Auth::user()->can('task.edit'))
                                                                    <a class="dropdown-item" href="{{ route('main.budget.fam.edit',$item->id) }}">Edit</a>
                                                                    @endif
                                                                    @if (Auth::user()->can('task.delete'))
                                                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="{{ route('main.budget.fam.delete',$item->id)}}" id="delete">Remove</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
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

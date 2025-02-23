@extends('tracki.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-12 col-sm-auto">
                <h2 class="mb-0">{{__('traki.project.card_title')}}<span class="fw-normal text-700 ms-3">({{$project_count}})</span></h2>
            </div>
            <div class="col-12 col-sm-auto">
                <div class="d-flex align-items-center">
                    <div class="search-box me-3">
                    </div>
                    <!-- <a class="btn btn-primary px-5" href="#!" id="add_new_project" data-workspace-id=""><i class="bx bx-plus"></i></a> -->
                    <!-- <a href="#" id="add_new_project" data-workspace-id=""><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>"><i class="bx bx-plus"></i></button></a> -->
                    <a class="btn btn-sm btn-phoenix-secondary preview-btn ms-2 me-3" href="{{ route('tracki.project.export.now') }}"><span class="fa-solid fas fa-download me-2"></span>Download all projects</a>
                    @if (Auth::user()->can('project.create'))
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2 me-3" data-bs-toggle="tooltip" data-bs-original-title=" <?= get_label('create_project', 'Create project') ?>" id="add_edit_project" data-action="store" data-redirect="card" data-type="add" data-table="none" data-id="" data-workspace_id="{{session()->get('workspace_id')}}">
                    <i class="bx bx-plus"></i>
                </a>
                    @endif
                    <a class="btn btn-phoenix-primary px-3" href="{{route('tracki.project.show.card')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Card view">
                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0.5C0 0.223858 0.223858 0 0.5 0H3.5C3.77614 0 4 0.223858 4 0.5V3.5C4 3.77614 3.77614 4 3.5 4H0.5C0.223858 4 0 3.77614 0 3.5V0.5Z" fill="currentColor"></path>
                            <path d="M0 5.5C0 5.22386 0.223858 5 0.5 5H3.5C3.77614 5 4 5.22386 4 5.5V8.5C4 8.77614 3.77614 9 3.5 9H0.5C0.223858 9 0 8.77614 0 8.5V5.5Z" fill="currentColor"></path>
                            <path d="M5 0.5C5 0.223858 5.22386 0 5.5 0H8.5C8.77614 0 9 0.223858 9 0.5V3.5C9 3.77614 8.77614 4 8.5 4H5.5C5.22386 4 5 3.77614 5 3.5V0.5Z" fill="currentColor"></path>
                            <path d="M5 5.5C5 5.22386 5.22386 5 5.5 5H8.5C8.77614 5 9 5.22386 9 5.5V8.5C9 8.77614 8.77614 9 8.5 9H5.5C5.22386 9 5 8.77614 5 8.5V5.5Z" fill="currentColor"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>


        <x-project-list-card :statuses="$statuses" source="projlist"/>
    </div>



    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

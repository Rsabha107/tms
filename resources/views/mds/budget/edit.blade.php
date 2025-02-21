@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h3 class="mb-4">Edit Budget Entry</h3>
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
            <form action="{{ route ('main.budget.update') }}" class="row g-3 mb-4 needs-validation form-submit" novalidate="" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $main_data->id }}">
                <div class="col-sm-6 col-md-8">
                    <div class="form-floating">
                        <input name="type" value="{{$main_data->type}}" class="form-control" id="floatingInputEventName" type="text" placeholder="" required>
                        <label for="floatingInputEventName">Budget type</label>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-floating">
                        <input name="budget_amount" value="{{$main_data->budget_amount}}" class="form-control" id="floatingInputLinkedin" type="number" step="0.01" placeholder="linkedin" value="0" required>
                        <label for="floatingInputLinkedin">Budget Amount</label>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-floating">
                        <select name="org_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($hr_org as $key => $item )

                            <option value="{{ $item->id  }}" {{($main_data->org_id == $item->id)? "selected":""}}>
                                {{ $item->name }}
                            </option>

                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Organization Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="budget_name_id" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($budget_name as $key => $item )
                            <option value="{{ $item->id  }}" {{($main_data->budget_name_id == $item->id)? "selected":""}}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Budget Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="active_flag" class="form-select" id="floatingSelectRating" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($active_flag as $key => $item )
                            <option value="{{ $item->id  }}" {{($main_data->active_flag == $item->id)? "selected":""}}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate"
                                data-target="#floatingInputStartDate" name="date_from" type="text"
                                placeholder="dd/mm/yyyy"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}'
                                value="{{ \Carbon\Carbon::parse($main_data->date_from)->format('d/m/Y') }}" required>
                        <label for="floatingInputStartDate">From date</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control datetimepicker" id="floatingInputStartDate"
                                data-target="#floatingInputStartDate" name="date_to" type="text"
                                placeholder="dd/mm/yyyy" data-options='{"dateFormat":"d/m/Y"}'
                                value="{{ \Carbon\Carbon::parse($main_data->date_to)->format('d/m/Y') }}" required>
                        <label for="floatingInputStartDate">To date</label>
                    </div>
                </div>



                <div class="col-12 d-flex justify-content-end mt-6">
                    <button class="btn btn-phoenix-secondary action button-submit" type="submit" value="save">Save</button>
                    <!-- <button class="btn btn-phoenix-secondary action" type="submit" value="save">Save</button> -->
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.budget.list') }}">Cancel</a>
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

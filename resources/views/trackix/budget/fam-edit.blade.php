@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h3 class="mb-4">Edit Functional Area</h3>
                    <div class="d-flex mb-3">
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.budget.fam.list') }}">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <!-- <h4 class="mb-3">Budget Information </h4> -->
            <form action="{{ route ('main.budget.fam.update') }}" class="row g-3 mb-4 needs-validation form-submit" novalidate="" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $mapping->id }}">
                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="fa_name" class="form-select" id="floatingSelectBudgetName" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($fa as $key => $item )
                            <option value="{{ $item->id  }}" {{($mapping->fa_name_id == $item->id)? "selected":""}}>
                            {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Functional Area Name</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-floating">
                        <select name="budget_name" class="form-select" id="floatingSelectBudgetName" required>
                            <option selected="selected" value="">Select</option>
                            @foreach ($budget_name as $key => $item )
                            <option value="{{ $item->id  }}" {{($mapping->budget_name_id == $item->id)? "selected":""}}>
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
                            <option value="{{ $item->id  }}" {{($mapping->active_flag == $item->id)? "selected":""}}>
                            {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelectRating">Status</label>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end mt-6">
                    <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.budget.fam.list') }}">Cancel</a>
                    <button class="btn btn-primary action button-submit" type="submit" value="save">Save</button>

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

<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="schedules_table" />
<input type="hidden" id="edit_schedule_id" name="id" value="{{$schedule->id}}">
<!-- <input type="hidden" id="page_refresh_type" value="page_refresh"> -->

<div>
    <div class="card">
        <div class="card-header d-flex align-items-center border-bottom">
            <div class="ms-3">
                <h5 class="mb-0 fs-sm">Add Booking Schedule</h5>
            </div>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-sm-12 col-md-12  mb-3">
                    <div class="form-floating input-group">
                        <select name="event_id"
                            class="form-select  @error('project_type_id') is-invalid @enderror"
                            id="add_project_project_type" required>
                            <option selected="selected" value="">Select event...</option>
                            @foreach ($events as $key => $item)
                            <option value="{{ $item->id }}" @if ($item->id == $schedule->event_id) selected @endif>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-plus-circle text-success"></i>
                        </button>
                        <div class="invalid-feedback">
                            Please select event.
                        </div>
                        <label for="floatingSelectPrivacy">Event</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12 col-md-12 mb-3">
                    <div class="flatpickr-input-container">
                        <div class="form-floating">
                            <input class="form-control datetimepicker" id="floatingInputBookingDate"
                                type="text" placeholder="dd/mm/yyyy" placeholder="booking date"
                                name="booking_date"
                                value="{{ $schedule->booking_date ? \Carbon\Carbon::parse($schedule->booking_date)->format('d/m/Y') : null }}"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required />
                            <div class="invalid-feedback">
                                Please enter booking date.
                            </div>
                            <label class="ps-6" for="floatingInputBookingDate">Booking date</label><span
                                class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 mb-3">
                    <div class="form-floating">
                        <input name="booking_slot" class="form-control" id="add_booking_slot"
                            type="text" placeholder="Booking Slot" value="{{ $schedule->booking_slot }}" />
                        <label for="floatingInputBookingSlot">Booking Slot</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-sm-12 col-md-12 mb-3">
                    <div class="form-floating">
                        <input name="maximum_slots" class="form-control" id="add_available_slots"
                            type="number" step="1" placeholder="Budget"  value="{{ $schedule->maximum_slots }}" />
                        <label for="floatingInputBudget">Maximum Slots</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 mb-3">
                    <div class="form-floating">
                        <input name="available_slots" class="form-control" id="add_available_slots"
                            type="number" step="1" placeholder="Budget"  value="{{ $schedule->available_slots }}" />
                        <label for="floatingInputBudget">Available Slots</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 mb-3">
                    <div class="form-floating">
                        <input name="used_slots" class="form-control" id="add_used_slots" type="number"
                            step="1" placeholder="Budget"  value="{{ $schedule->used_slots }}" />
                        <label for="floatingInputBudget">Used Slots</label>
                    </div>
                </div>
            </div>

            <div class="col-12 gy-3">
                <div class="row g-3 justify-content-end">
                    <a href="javascript:void(0)" class="col-auto">
                        <button type="button" class="btn btn-phoenix-danger px-5"
                            data-bs-toggle="tooltip" data-bs-placement="right"
                            data-bs-dismiss="offcanvas">
                            Cancel
                        </button>
                    </a>
                    <div class="col-auto">
                        <button class="btn btn-primary px-5" id="submit_btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-global-modal in" id="offcanvas-edit-booking-slot-modal" tabindex="-1"
    aria-labelledby="offcanvasWithBackdropLabel">
    <a class="close-task-detail in" id="close-task-detail" style="display: block;" data-bs-dismiss="offcanvas">
        <span><svg class="svg-inline--fa fa-times fa-w-11" aria-hidden="true" focusable="false" data-prefix="fa"
                data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"
                data-fa-i2svg="">
                <path fill="currentColor"
                    d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                </path>
            </svg><!-- <i class="fa fa-times"></i> Font Awesome fontawesome.com --></span>
    </a>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="row g-3 needs-validation form-submit-event" id="edit_booking_slot_form" novalidate=""
                    action="{{ route('mds.setting.schedule.update') }}" method="POST">
                    @csrf
                    <div id="global-edit-booking-slot-content"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-global-modal in" id="offcanvas-add-booking-slot-modal" tabindex="-1"
    aria-labelledby="offcanvasWithBackdropLabel">
    <a class="close-task-detail in" id="close-task-detail" style="display: block;" data-bs-dismiss="offcanvas">
        <span>
            <i class="fa fa-times"></i>
        </span>
    </a>
    <x-mds.admin.admin-booking-slot-drawer id="" formAction="{{ route('mds.setting.schedule.store') }}"
        formId="add_booking_slot_form"
        :events="$events" :venues="$venues" :rsps="$rsps" :schedules="$schedules" />


</div>



{{-- <div class="modal fade" id="create_schedules_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel"><?= get_label('create_schedules', 'Create schedule') ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form novalidate="" class="modal-content form-submit-event needs-validation" id="form_submit_event" action="{{route('mds.setting.schedule.store')}}" method="POST">
                @csrf
                <input type="hidden" name="table" value="schedules_table">
                <div class="modal-body">

                    <div class="col-md-12 mb-2">
                        <label class="form-label" for="inputEmail4"><?= get_label('regime_start_date', 'Regime start date') ?></label>
                        <input class="form-control datetimepicker" data-target="#floatingInputStartDate" name="regime_start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label" for="inputEmail4"><?= get_label('regime_end_date', 'Regime end date') ?></label>
                        <input class="form-control datetimepicker" data-target="#floatingInputEndDate" name="regime_end_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                    </div>

                    <div class="mb-2 col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender"><?= get_label('venue', 'Venue') ?><span class="asterisk">*</span></label>
                        <select class="form-select" name="schedule_venue_id" required>
                            <option value="" selected>Select venue...</option>
                            @foreach ($venues as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2 col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender"><?= get_label('rsp', 'RSP') ?><span class="asterisk">*</span></label>
                        <select class="form-select" name="schedule_rsp_id" required>
                            <option value="" selected>Select RSP...</option>
                            @foreach ($rsps as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('timeslots', 'Timeslots') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="nameBasic" class="form-control" name="time_slots" placeholder="<?= get_label('please_enter_timeslots', 'Please enter timeslots') ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <?= get_label('close', 'Close') ?></label>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_schedules_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class="mb-0" id="staticBackdropLabel">Edit</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form novalidate="" class="modal-content form-submit-event needs-validation" id="edit_form_submit_event" action="{{route('mds.setting.schedule.update')}}" method="POST">
                @csrf
                <input type="hidden" id="edit_schedules_id" name="id" value="">
                <input type="hidden" id="edit_schedules_table" name="table">
                <div class="modal-body">

                    <div class="col-md-12 mb-2">
                        <label class="form-label" for="inputEmail4"><?= get_label('regime_start_date', 'Regime start date') ?></label>
                        <input class="form-control datetimepicker" data-target="#floatingInputStartDate" id="edit_regime_start_date" name="regime_start_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label" for="inputEmail4"><?= get_label('regime_end_date', 'Regime end date') ?></label>
                        <input class="form-control datetimepicker" data-target="#floatingInputEndDate" id="edit_regime_end_date" name="regime_end_date" type="date" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required>
                    </div>

                    <div class="mb-2 col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender"><?= get_label('venue', 'Venue') ?><span class="asterisk">*</span></label>
                        <select class="form-select" name="schedule_venue_id" id="edit_schedule_venue_id" required>
                            <option value="" selected>Select venue...</option>
                            @foreach ($venues as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2 col-md-12">
                        <label class="form-label" for="bootstrap-wizard-validation-gender"><?= get_label('rsp', 'RSP') ?><span class="asterisk">*</span></label>
                        <select class="form-select" name="schedule_rsp_id" id="edit_schedule_rsp_id" required>
                            <option value="" selected>Select RSP...</option>
                            @foreach ($rsps as $key => $item )
                            <option value="{{ $item->id  }}">
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('timeslots', 'Timeslots') ?> <span class="asterisk">*</span></label>
                        <input required type="text" class="form-control" id="edit_time_slots" name="time_slots" placeholder="<?= get_label('please_enter_timeslots', 'Please enter timeslots') ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <?= get_label('close', 'Close') ?></label>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
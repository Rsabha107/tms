@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <!-- <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
        <div class="row">
            <div class="col-xl-8">
                <div class="d-sm-flex justify-content-between">
                    <h2 class="mb-4">{{__('traki.project.create_form_title')}}</h2>
                    <div class="d-flex mb-3">
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.project.show.card') }}">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <form class="mb-9 needs-validation" novalidate="">
        <div class="border-bottom mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">

            <div class="row justify-content-between align-items-end g-3 mb-5">
                <div class="col-12 col-sm-auto col-xl-8">
                    <h2 class="mb-0">{{__('traki.project.create_form_title')}}</h2>
                </div>
                <div class="col-12 col-sm-auto col-xl-4">
                    <div class="d-flex">
                        <a class="btn btn-phoenix-danger me-2 px-6" href="{{ route('main.project.show.card') }}">Cancel</a>
                        <button class="btn btn-primary px-5 me-2">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-xl-8">
                <div class="row gx-3 gy-4">
                    <h4 class="fs-7 mb-0">Event Details</h4>
                    <div class="col-sm-6 col-md-12">
                        <div class="form-floating">
                            <input name="name" class="form-control" id="floatingInputEventName" type="text" placeholder="" required>
                            <label for="floatingInputEventName">{{__('traki.project.name_field')}}</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-floating">
                            <select name="functional_area_id" class="form-select" id="floatingSelectOwner" required>
                                <option selected="selected" value=""> Select </option>
                                @foreach ($functional_area as $key => $item )
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
                            <label for="floatingSelectOwner">Functional Area</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectPrivacy">
                                <option selected="selected">Select topic</option>
                                <option value="1">Data select topic One</option>
                                <option value="2">Data select topic Two</option>
                                <option value="3">Data select topic Three</option>
                            </select>
                            <label for="floatingSelectPrivacy">topic</label>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio1" type="radio" name="inlineRadioOptions" value="option1" checked="checked" />
                            <label class="form-check-label" for="inlineRadio1">Online</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio2" type="radio" name="inlineRadioOptions" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">Offline</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio3" type="radio" name="inlineRadioOptions" value="option3" />
                            <label class="form-check-label" for="inlineRadio3">Both</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-12 mt-md-0 mt-lg-1">
                        <div class="form-floating">
                            <input class="form-control" id="floatingVenueInput" type="text" placeholder="Venue" />
                            <label for="floatingVenueInput">Venue</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectCountry">
                                <option selected="selected">Select Country</option>
                                <option value="1">Country One</option>
                                <option value="2">Country Two</option>
                                <option value="3">Country Three</option>
                            </select>
                            <label for="floatingSelectCountry">Country</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectState">
                                <option selected="selected">Select State </option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <label for="floatingSelectState"> State</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectCity">
                                <option selected="selected">Select city</option>
                                <option value="1">Data Privacy One</option>
                                <option value="2">Data Privacy Two</option>
                                <option value="3">Data Privacy Three</option>
                            </select>
                            <label for="floatingSelectCity">City</label>
                        </div>
                    </div>
                    <h4 class="fs-7 mt-7">Schedule</h4>
                    <div class="col-sm-6">
                        <div class="flatpickr-input-container">
                            <div class="form-floating">
                                <input class="form-control datetimepicker" id="startDatepicker" type="text" placeholder="start date" data-options='{"disableMobile":true}' /><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                <label class="ps-6" for="startDatepicker">Start date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <input class="form-control datetimepicker" id="timepickerEvent" type="text" placeholder="H:i" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                            <label for="timepickerEvent">Start Time</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="flatpickr-input-container">
                            <div class="form-floating">
                                <input class="form-control datetimepicker" id="endDatepicker" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                <label class="ps-6" for="endDatepicker">End date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <input class="form-control datetimepicker" id="timepickerEvent2" type="text" placeholder="H:i" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                            <label for="timepickerEvent2">End Time</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectTimeZone">
                                <option selected="selected">Select time zone</option>
                                <option value="1">Data Privacy One</option>
                                <option value="2">Data Privacy Two</option>
                                <option value="3">Data Privacy Three</option>
                            </select>
                            <label for="floatingSelectTimeZone">Time zone</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="flatpickr-input-container">
                            <div class="form-floating">
                                <input class="form-control datetimepicker" id="datepicker" type="text" placeholder="registration deadline" data-options='{"disableMobile":true}' />
                                <label for="datepicker">Registration deadline</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 gy-6">
                        <div class="form-floating">
                            <textarea class="form-control" id="floatingProjectDescription" placeholder="Leave a comment here" style="height: 128px"></textarea>
                            <label for="floatingProjectDescription">Description</label>
                        </div>
                    </div>
                    <div class="col-sm-6 gy-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingOrganizersInput" type="text" placeholder="ORGANIZERS" />
                            <label for="floatingOrganizersInput">ORGANIZERS</label>
                        </div>
                    </div>
                    <div class="col-sm-6 gy-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingSponsorsInput" type="text" placeholder="SPONSORS" />
                            <label for="floatingSponsorsInput">SPONSORS</label>
                        </div>
                    </div>
                    <div class="col-12 gy-6">
                        <div class="dropzone dropzone-multiple p-0 mb-5" id="my-awesome-dropzone" data-dropzone="data-dropzone">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple" />
                            </div>
                            <div class="dz-preview d-flex flex-wrap">
                                <div class="border border-translucent bg-body-emphasis rounded-3 d-flex flex-center position-relative me-2 mb-2" style="height:80px;width:80px;"><img class="dz-image" src="../../assets/img/products/23.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" /><a class="dz-remove text-body-quaternary" href="#!" data-dz-remove="data-dz-remove"><span data-feather="x"></span></a></div>
                            </div>
                            <div class="dz-message text-body-tertiary text-center" data-dz-message="data-dz-message">
                                Drag your photo here <span class="text-body-secondary">or </span>
                                <button class="btn btn-link p-0" type="button">Browse from device </button><br /><img class="mt-3 me-2" src="../../assets/img/icons/image-icon.png" width="40" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="--phoenix-choices-inner-min-height: 128px;">
                            <select class="form-select mb-3" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Add tags</option>
                                <option value="MUSIC">Music</option>
                                <option value="CONCEERT">CONCEERT</option>
                                <option value="GREATEST SHOW ON EARTH">GREATEST SHOW ON EARTH </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="border-bottom border-translucent pb-6 mb-6">
                    <h4 class="fs-7 mb-4">Privacy</h4>
                    <div class="form-check mb-2">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating">
                                <select name="functional_area_id" class="form-select" id="floatingSelectOwner" required>
                                    <option selected="selected" value=""> Select </option>
                                    @foreach ($functional_area as $key => $item )
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
                                <label for="floatingSelectOwner">Functional Area</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-0">
                        <input class="form-check-input" id="exampleRadios2" type="radio" name="exampleRadios" value="option2" />
                        <label class="form-check-label fw-normal" for="exampleRadios2">Only the individuals you select have access to it.</label>
                    </div>
                </div>
                <div class="border-bottom border-translucent mb-6">
                    <div class="form-check">
                        <input class="form-check-input" id="flexChecked" type="checkbox" checked="checked" />
                        <label class="form-check-label fw-bold fs-8 mb-5" for="flexChecked">Show the number of available tickets</label>
                    </div>
                </div>
                <h4 class="fs-7 mb-4">Ticket pricing</h4>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="freeTicket" type="radio" name="ticketPricing" value="freeTicket" checked="checked" />
                    <label class="form-check-label" for="freeTicket">Free</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="paidTicket" type="radio" name="ticketPricing" value="paidTicket" />
                    <label class="form-check-label" for="paidTicket">Paid</label>
                </div>
                <div class="row g-3 mb-7 mt-1 border-bottom border-translucent pb-5">
                <div class="col-sm-6 col-md-12">
                            <div class="form-floating">
                                <select name="functional_area_id" class="form-select" id="floatingSelectOwner" required>
                                    <option selected="selected" value=""> Select </option>
                                    @foreach ($functional_area as $key => $item )
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
                                <label for="floatingSelectOwner">Functional Area</label>
                            </div>
                        </div>
                </div>
                <h4 class="fs-7 mb-3">Custom fields</h4>
                <div class="row g-3 mb-3">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <label class="form-label" for="inputName">Name</label>
                        <input class="form-control" id="inputName" type="text" placeholder="Item name (e.g. Special T-shirt)" />
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <label class="form-label" for="inputState1">Type</label>
                        <select class="form-select" id="inputState1">
                            <option value="">Choose...</option>
                            <option value="">Type One</option>
                            <option value="">Type Two</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="filedOptions">Field options</label>
                        <textarea class="form-control" id="filedOptions" placeholder="Description" rows="6"></textarea>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <label class="form-label" for="inputName2">Name</label>
                        <input class="form-control" id="inputName2" type="text" placeholder="Item name (e.g. Special T-shirt)" />
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <label class="form-label" for="inputState2">Type</label>
                        <select class="form-select" id="inputState2">
                            <option value="">Choose...</option>
                            <option value="">Type Three</option>
                            <option value="">Type Four</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="filedOptions2">Field options</label>
                        <textarea class="form-control" id="filedOptions2" placeholder="Description" rows="6"></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-link p-0" type="button"><span class="fa-solid fa-plus me-2"></span>Add an item</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')


    @endpush

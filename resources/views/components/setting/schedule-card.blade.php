<!-- meetings -->

<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            @if (is_countable($schedules) && count($schedules) > 0)
            <input type="hidden" id="data_type" value="schedule">
            <div class="mx-2 mb-2">
                <table id="schedules_table"
                    data-toggle="table"
                    data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                    data-loading-template="loadingTemplate"
                    data-url="{{ route('mds.setting.schedule.list')}}"
                    data-icons-prefix="bx"
                    data-icons="icons"
                    data-show-export="true"
                    data-show-columns-toggle-all="true"
                    data-show-refresh="true"
                    data-total-field="total"
                    data-trim-on-search="false"
                    data-data-field="rows"
                    data-page-list="[5, 10, 20, 50, 100, 200,4000]"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-pagination="true"
                    data-sort-name="id"
                    data-sort-order="asc"
                    data-mobile-responsive="true"
                    data-buttons-class="secondary"
                    data-query-params="mdsScheduleQueryParams">
                    <thead>
                        <tr>
                            <!-- <th data-checkbox="true"></th> -->
                            <!-- <th data-sortable="true" data-field="id" class="align-middle white-space-wrap fw-bold fs-9"><?= get_label('id', 'ID') ?></th> -->
                            <th data-sortable="true" data-field="event" class="align-middle white-space-wrap fw-bold fs-9">Event</th>
                            <th data-sortable="true" data-field="venue" class="align-middle white-space-wrap fw-bold fs-9">Venue</th>
                            <th data-sortable="true" data-field="booking_date" class="align-middle white-space-wrap fw-bold fs-9">Booking Date</th>
                            <th data-sortable="true" data-field="rsp_booking_slot" class="align-middle white-space-wrap fw-bold fs-9">RSP Booking Slot</th>
                            <th data-sortable="true" data-field="venue_arrival_time" class="align-middle white-space-wrap fw-bold fs-9">Venue Arrival Time</th>
                            <th data-sortable="true" data-field="bookings_slots_all" class="align-middle white-space-wrap fw-bold fs-9">Booking Slots (ALL)</th>
                            <th data-sortable="true" data-field="available_slots" class="align-middle white-space-wrap fw-bold fs-9">Available Slots</th>
                            <th data-sortable="true" data-field="used_slots" class="align-middle white-space-wrap fw-bold fs-9">Used Slots</th>
                            <th data-sortable="true" data-field="bookings_slots_cat" class="align-middle white-space-wrap fw-bold fs-9">Booking Slots (CAT)</th>
                            <th data-sortable="true" data-field="slot_visibility" class="align-middle white-space-wrap fw-bold fs-9">Slot Visibility</th>
                            <th data-sortable="true" data-field="remote_search_park" class="align-middle white-space-wrap fw-bold fs-9">RSP</th>
                            <th data-sortable="true" data-field="match_day" class="align-middle white-space-wrap fw-bold fs-9">Match Day</th>
                            <th data-sortable="true" data-field="comments" class="align-middle white-space-wrap fw-bold fs-9">Comments</th>
                            <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                            <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                            <th data-formatter="actionsFormatter" class="text-end"><?= get_label('actions', 'Actions') ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
            @else
            <?php
            $type = 'Schedules'; ?>
            <x-empty-state-card :type="$type" />
            @endif
        </div>
    </div>
</div>

<script>
    ("use strict");

    function mdsScheduleQueryParams(p) {
        return {
            mds_schedule_event_filter: $("#mds_schedule_event_filter").val(),
            mds_schedule_venue_filter: $("#mds_schedule_venue_filter").val(),
            mds_schedule_rsp_filter: $("#mds_schedule_rsp_filter").val(),
            page: p.offset / p.limit + 1,
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search,
        };
    }
    window.icons = {
        refresh: "bx-refresh",
        toggleOn: "bx-toggle-right",
        toggleOff: "bx-toggle-left",
        fullscreen: "bx-fullscreen",
        columns: "bx-list-ul",
        export_data: "bx-list-ul",
        paginationSwitch: "bx-list-ul",
    };

    function loadingTemplate(message) {
        return '<i class="bx bx-loader-circle bx-spin bx-flip-vertical" ></i>';
    }

    $("#mds_schedule_event_filter,#mds_schedule_venue_filter,#mds_schedule_rsp_filter").on("change", function(e) {
        e.preventDefault();
        console.log("tasks.js on change");
        $("#schedules_table").bootstrapTable("refresh");
    });
</script>
$(document).ready(function () {
    var team_id = $("#tms_team_id").val();
    var event_id = 4;
    var destination_id = $("#tms_destination_id").val();
    console.log("team_id: " + team_id);
    console.log("event_id: " + event_id);
    var calendarEl = document.getElementById("calendar");
    console.log("calendarEl", calendarEl);
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            // contentHeight: "auto",
            themeSystem: "bootstrap5",
            selectable: true,
            handleWindowResize: true,
            // eventTextColor: "#3788d8",
            loading: function (bool) {
                if (bool) {
                    // loading starts
                    $("#loading").show();
                } else {
                    // loading ends
                    $("#loading").hide();
                }
            },
            eventDidMount: function (info) {
                // console.log("eventDidMount", info);
                if (info.event.extendedProps.background) {
                    // console.log("background", info.event.extendedProps.background);
                    info.el.style.background =
                        info.event.extendedProps.background;
                }
                if (info.event.extendedProps.textColor) {
                    // console.log("textColor", info.event.extendedProps.textColor);
                    info.el.style.textColor =
                        info.event.extendedProps.textColor;
                }
            },
            events: function (info, successCallback, failureCallback) {
                $.ajax({
                    url: "/tms/admin/booking/schedule",
                    method: "post", // Change to GET if you want
                    data: {
                        // Our data
                        event_id: event_id, // Team ID
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        successCallback(data);
                    },
                    error: function (error) {
                        $("#loading").hide();
                        alert(error);
                    },
                });
            },
            dateClick: function (info) {
                console.log("dateClick", info);

                $("#tms_booking_date").val(info.dateStr);

                console.log(
                    "destination_id: " + $("#tms_destination_id").val()
                );
                console.log("team_id: " + $("#tms_team_id").val());
                console.log(
                    "tms_booking_date: " + $("#tms_booking_date").val()
                );

                let team_id = $("#tms_team_id").val();
                let destination_id = $("#tms_destination_id").val();

                if (info.date < new Date()) {
                    message = "You cannot select a past date";
                    toastr.error(message);
                    return;
                }

                if (!team_id || !destination_id) {
                    message = "Please select a team and destination first";
                    toastr.error(message);
                    return;
                }

                $("#cover-spin").show();
                console.log("eventObj start", info.dateStr);

                // clear the available time slots
                $("#show_schedule_times").empty("");

                $.ajax({
                    url: "/tms/admin/booking/times/cal",
                    method: "post",
                    data: {
                        date: info.dateStr,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        console.log("response length: " + response.ops.length);
                        let isExists = response.ops.length;
                        // var len = response.length;

                        let html =
                            '<ul class="list-group mb-5" id="myTab" role="tablist">';

                        $.each(response.ops, function (key, value) {
                            var grey = null;
                            if (value.available_slots == 0) {
                                grey = "disabled";
                            } else {
                                grey = null;
                            }

                            html +=
                                '<li class="list-group-item d-flex justify-content-between align-items-start">' +
                                '<div class="ms-2 me-auto">' +
                                '<input class="form-check-input me-1" type="radio" name="time_slot_id"' +
                                'value="' +
                                value.id +
                                '" ' +
                                'id="timeSlotsRadio' +
                                value.id +
                                '" required>' +
                                '<label class="form-check-label"' +
                                'for="timeSlotsRadio' +
                                value.id +
                                '">' +
                                value.booking_slot +
                                "</label>" +
                                "</div>" +
                                '<span class="badge text-bg-primary rounded-pill">' +
                                value.available_slots +
                                "</span>" +
                                "</li>";
                        });
                        html +=
                            '<div class="invalid-feedback">Please select one or multiple</div>';
                        html += "</ul>";

                        $("#tms_form")[0].reset();
                        $("#tms_form").removeClass("was-validated");

                        // $("#div3_title").html("Available time slots for " + info.dateStr);
                        console.log("team_id: " + team_id);
                        console.log("destination_id: " + destination_id);
                        $("#show_schedule_times").html(html);
                        if (isExists > 0 && team_id && destination_id) {
                            $("#div3_title").html(
                                '<h5 class="mb-4" id="div3_title">Available time slots for ' +
                                    info.dateStr +
                                    "</h5>"
                            );
                            $("#submit_booking").prop("disabled", false);
                        } else {
                            $("#div3_title").html(
                                '<h3 class="mb-4" id="div3_title">Select a date to see available times</h3>'
                            );
                            $("#submit_booking").prop("disabled", true);
                        }

                        console.log("before available-time");

                        $("#cover-spin").hide();
                    },
                }).done(function () {
                    // $("#delivery_schedule_times_modal").modal("show");
                });

                // $("#delivery_schedule_times_modal").modal("show");
            },
            eventClick: function (info) {
                console.log("eventClick", info);
                if (info.date < new Date()) {
                    message = "You cannot select a past date";
                    toastr.error(message);
                    return;
                }
                $("#cover-spin").show();

                var eventObj = info.event;
                console.log("eventObj start", eventObj.start);
                console.log("venue_id id", venue_id);
                var convertedDate = moment(eventObj.start).format("YYYY-MM-DD");
                var convertedDateDMY = moment(eventObj.start).format(
                    "DD/MM/YYYY"
                );

                $("#add_schedule_times_cal")
                    .empty("")
                    .html('<option value="">-- Select time --</option>');

                $("#available-time").html(
                    "<h5>Available time slots for " + convertedDate + "</h5>"
                );

                console.log("convertedDate", convertedDate);
                console.log("eventObj id", eventObj.id);
                $.ajax({
                    url: "/mds/admin/booking/times/cal",
                    method: "post",
                    data: {
                        venue_id: venue_id,
                        date: info.dateStr,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        console.log(
                            "response length: " + response.venue.length
                        );
                        // var len = response.length;

                        $("#add_schedule_times_cal")
                            .empty("")
                            .html(
                                '<option value="">-- Select time --</option>'
                            );
                        $.each(response.venue, function (key, value) {
                            var grey = null;
                            if (value.available_slots == 0) {
                                grey = "disabled";
                            } else {
                                grey = null;
                            }

                            $("#tms_booking_date").val(info.dateStr);

                            $("#add_schedule_times_cal").append(
                                '<option value="' +
                                    value.id +
                                    '" ' +
                                    grey +
                                    ">" +
                                    value.rsp_booking_slot +
                                    " (" +
                                    value.available_slots +
                                    ")</option>"
                            );
                        });
                        console.log("before available-time");

                        $("#cover-spin").hide();
                    },
                }).done(function () {
                    // $("#delivery_schedule_times_modal").modal("show");
                });

                // $("#delivery_schedule_times_modal").modal("show");
            },
            // events: '/tms/booking/schedule/' + event_id,
            // events: {function() {
            //     $.ajax({
            //         url: '/tms/booking/schedule',
            //         method: 'post',
            //         data: {
            //             event_id: event_id,
            //         },
            //         headers: {
            //             "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            //         },
            //         dataType: "json",
            //         success: function(data) {
            //             console.log(data);
            //             return data;
            //         },
            //         error: function(error) {
            //             alert(error);
            //         }
            //     });
            // }},
            // eventSources:{
            //     url: 'http://localhost:8000/tms/booking/schedule',
            //     method: 'POST',
            //     // data: {
            //     //     event_id: event_id,
            //     // },
            //     // headers: {
            //     //     "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            //     // },
            //     // extraParams: {
            //     //     event_id: event_id,
            //     // },
            //     // dataType: "json",
            //     // extraParams: function() {
            //     //     return {
            //     //         team_id: team_id,
            //     //         destination_id: destination_id
            //     //     };
            //     failure: function() {
            //         alert('there was an error while fetching events!');
            //     },
            //     color: 'green',
            //     textColor: 'white'
            // }
            // any other sources...
            // events: "/tms/booking/schedule/" + team_id,
            // eventBackgroundColor: "green",
            // eventDisplay: "block",
            // selectable: true,
            // showNonCurrentDates: false,
        });
        // calendar.eventSources('/tms/booking/schedule/' + team_id + '/' + destination_id);
        calendar.render();
    }

    $('#tms_team_select_id').on('change', function() {
        console.log( this.value );
        $("#tms_team_id").val(this.value);
        calendar.refetchEvents();
      });

      $('#tms_destination_select_id').on('change', function() {
        console.log( this.value );
        $("#tms_destination_id").val(this.value);
        calendar.refetchEvents();
      });

    // $(".team-list").click(function () {
    //     console.log("team-list clicked");
    //     $("li.list-group-item.team-list.active").removeClass("active");
    //     $(this).addClass("active");
    //     $("#tms_team_id").val($(this).data("team-id"));
    //     console.log("team_id: " + $("#tms_team_id").val());
    //     calendar.refetchEvents();
    // });

    // $(".destination-list").click(function () {
    //     console.log("destination-list clicked");
    //     $("li.list-group-item.destination-list.active").removeClass("active");
    //     $(this).addClass("active");
    //     $("#tms_destination_id").val($(this).data("destination-id"));
    //     console.log("destination_id: " + $("#tms_destination_id").val());
    //     calendar.refetchEvents();
    // });

    $("body").on("click", "#deleteBooking", function (e) {
        var id = $(this).data("id");
        var tableID = $(this).data("table");
        e.preventDefault();
        // alert('in deleteStatus '+tableID);
        var link = $(this).attr("href");
        Swal.fire({
            title: "Are you sure?",
            text: "Delete This Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/tms/admin/booking/delete/" + id,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (result) {
                        if (!result["error"]) {
                            toastr.success(result["message"]);
                            // divToRemove.remove();
                            // $("#fileCount").html("File ("+result["count"]+")");
                            $("#" + tableID).bootstrapTable("refresh");
                            // Swal.fire(
                            //     'Deleted!',
                            //     'Your file has been deleted.',
                            //     'success'
                            //   )
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
        });
    });
});

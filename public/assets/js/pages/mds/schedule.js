$(document).ready(function () {
    // console.log("all tasksJS file");

    // ************************************************** task venues

    $("body").on("click", "#editSchedule", function () {
        console.log('inside editSchedule')
        var id = $(this).data("id");
        var table = $(this).data("table");
        // console.log('edit venues in venues.js');
        // console.log('id: '+id);
        // console.log('table: '+table);
        // var target = document.getElementById("edit_venues_modal");
        // var spinner = new Spinner().spin(target);
        // $("#edit_venues_modal").modal("show");
        $.ajax({
            url: "/mds/setting/schedule/get/" + id,
            type: "get",
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            },
            dataType: "json",
            success: function (response) {
                console.log(response)
                var formatted_regime_start_date = moment(response.venue.regime_start_date).format("DD/MM/YYYY");
                var formatted_regime_end_date = moment(response.venue.regime_end_date).format("DD/MM/YYYY");

                $("#edit_schedules_id").val(response.venue.id);
                $("#edit_regime_start_date").val(formatted_regime_start_date);
                $("#edit_regime_end_date").val(formatted_regime_end_date);
                $("#edit_schedule_venue_id").val(response.venue.venue_id);
                $("#edit_schedule_rsp_id").val(response.venue.rsp_id);
                $("#edit_time_slots").val(response.venue.time_slots);
                $("#edit_schedules_table").val(table);
                // $("#edit_vehicle_types_modal").modal("show");
            },
        }).done(function () {
            $("#edit_schedules_modal").modal("show");
        });
    });
});

$("body").on("click", "#deleteSchedule", function (e) {
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
                url: "/mds/setting/schedule/delete/" + id,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                },
                dataType: "json",
                success: function (result) {
                    if (!result["error"]) {
                        toastr.success(result["message"]);
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

$("body").on("click", "#editScheduleStatus", function (event) {
    // console.log("inside sec click edit");
    // event.preventDefault();
    var id = $(this).data("id");
    var table = $(this).data("table");
    // var route = $(this).data("route");
    // console.log("id: " + id);
    // console.log("table: " + table);

    $.get("/mds/schedule/status/edit/" + id , function (data) {
        //  console.log('event name: ' + data);
        $.each(data, function (index, value) {
            // console.log(value[0]);
            $("#editScheduleId").val(value[0].id);
            $("#editScheduleStatusSelection").val(value[0].status_id);
            $("#scheduleStatusTable").val(table);
            $("#scheduleStatusModal").modal("show");
        });

        // $('#staticBackdropLabel').html("Edit category");
        // $('#submit').val("Edit category");
    });
});


function actions2Formatter(value, row, index) {
    return [
        '<a href="javascript:void(0);" class="edit-schedules" id="editSchedule" data-id=' +
            row.id +
            " title=" +
            label_intervals +
            ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
            '<a href="javascript:void(0);" class="edit-schedules" id="editSchedule" data-id=' +
            row.id +
            " title=" +
            label_update +
            ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
            "<button title=" +
            label_delete +
            ' type="button" data-table="schedules_table" class="btn delete" id="deleteSchedule" data-id=' +
            row.id +
            ' data-type="status">' +
            '<i class="bx bx-trash text-danger mx-1"></i>' +
            "</button>",
    ];
}

function actionsFormatter(value, row, index) {
    console.log("tasks.js inside actions2Formatter");
    html = "";
    // html =
    //     html +
    //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
    //     '<a href="/mds/setting/interval/manage/'+ row.id + '" class="btn btn-sm" id="schedule_intervals" data-id="' +
    //     row.id +
    //     '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
    //     label_intervals +
    //     '">' +
    //     '<i class="fa-solid fas fa-network-wired text-warning"></i></a>';


        // html =
        //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
        //     '<a href="/tracki/task/' +
        //     row.id +
        //     '/edit" class="btn btn-sm" id="editX" data-route="category" data-id="">' +
        //     '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
        html =
            html +
            // '<div class="font-sans-serif btn-reveal-trigger position-static">' +
            '<a href="javascript:void(0)" class="btn btn-sm" id="editSchedule" data-id="' +
            row.id +
            '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
            label_update +
            '">' +
            '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
        // html ='<a href="javascript:voice(0)" id="edit_task" data-id ="'+ row.id +'"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="'+ label_update +'"><i class="bx bx-plus"></i></button></a>'

        html =
            html +
            '<a href="javascript:void(0)" class="btn btn-sm delete" data-table="schedules_table" data-id="' +
            row.id +
            '" id="deleteSchedule" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
            label_delete +
            '">' +
            '<i class="bx bx-trash text-danger"></i></a>';

html = html + "</div></div>";

    return [html];
}

$(document).ready(function() {
    var team_id = $("#bookapp_team_id").val();
    var event_id = 4;
    var destination_id = $("#bookapp_destination_id").val();
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        contentHeight: "auto",
        selectable: true,
        handleWindowResize: true,
        loading: function(bool) {
            if (bool) { // loading starts
                $("#loading").show();
            } else { // loading ends
                $("#loading").hide();
            }
        },
        events: function(info, successCallback, failureCallback) {
            $.ajax({
                url: '/bookapp/booking/schedule',
                method: 'post', // Change to GET if you want
                data: { // Our data
                    event_id: event_id,   // Team ID
                },
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    successCallback(data);
                },
                error: function(error) {
                    alert(error);
                }
            });
        },
        // events: '/bookapp/booking/schedule/' + event_id,
        // events: {function() {
        //     $.ajax({
        //         url: '/bookapp/booking/schedule',
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
        //     url: 'http://localhost:8000/bookapp/booking/schedule',
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
        // events: "/bookapp/booking/schedule/" + team_id,
            // eventBackgroundColor: "green",
            // eventDisplay: "block",
            // selectable: true,
            // showNonCurrentDates: false,
    });
    // calendar.eventSources('/bookapp/booking/schedule/' + team_id + '/' + destination_id);
    calendar.render();

    $('.team-list').click(function() {
        console.log('team-list clicked');
        $('li.list-group-item.team-list.active').removeClass("active");
        $(this).addClass("active");
        $('#bookapp_team_id').val($(this).data('team-id'));
        console.log('team_id: ' + $('#bookapp_team_id').val());
        calendar.refetchEvents();
    });

    $('.destination-list').click(function() {
        console.log('destination-list clicked');
        $('li.list-group-item.destination-list.active').removeClass("active");
        $(this).addClass("active");
        $('#bookapp_destination_id').val($(this).data('destination-id'));
        console.log('destination_id: ' + $('#bookapp_destination_id').val());
        calendar.refetchEvents();
    });
});
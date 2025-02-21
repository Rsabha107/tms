<!DOCTYPE html>

<head>
    <!-- <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=6.0.0"></script>
    <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.css?v=6.0.0"> -->

    <script src="{{ asset ('assets/js/dhtmlxgantt.js?v=8.0.6') }}"></script>
    <link href="{{ asset ('assets/css/dhtmlxgantt.css?v=8.0.6') }}" type="text/css" rel="stylesheet" id="user-style-rtl">


    <style type="text/css">
        html,
        body {
            height: 90%;
            /* height:100%; */
            padding: 0px;
            margin: 0px;
            /* margin: unset; */
            /* overflow: hidden; */
        }

        .status_line {
            background-color: #0ca30a;
        }

        #gantt_here {
            width: 90%;
            height: 90%;
        }

        .gantt_grid_scale .gantt_grid_head_cell,
        .gantt_task .gantt_task_scale .gantt_scale_cell {
            font-weight: bold;
            font-size: 14px;
            color: rgba(0, 0, 0, 0.7);
        }

        .resource_marker {
            text-align: center;
        }

        .resource_marker div {
            width: 28px;
            height: 28px;
            line-height: 29px;
            display: inline-block;
            border-radius: 15px;
            color: #FFF;
            margin: 3px;
        }

        .gantt_task_line.gantt_task_inline_color .gantt_task_progress {
            background-color: rgb(54, 54, 54);
            opacity: 0.2;
        }

        .resource_marker.workday_ok div {
            background: #51c185;
        }

        .resource_marker.workday_over div {
            background: #ff8686;
        }

        .weekend {
            background: #f4f7f4 !important;
        }
    </style>
</head>

<body>
    <!-- <form class="gantt_control">
        <input type="button" value="Zoom In" onclick="zoomIn()">
        <input type="button" value="Zoom Out" onclick="zoomOut()">

        <input type="radio" id="scale1" class="gantt_radio" name="scale" value="day">
        <label for="scale1">Day scale</label>

        <input type="radio" id="scale2" class="gantt_radio" name="scale" value="week">
        <label for="scale2">Week scale</label>

        <input type="radio" id="scale3" class="gantt_radio" name="scale" value="month">
        <label for="scale3">Month scale</label>

        <input type="radio" id="scale4" class="gantt_radio" name="scale" value="quarter">
        <label for="scale4">Quarter scale</label>

        <input type="radio" id="scale5" class="gantt_radio" name="scale" value="year" checked>
        <label for="scale5">Year scale</label>

    </form> -->
    <div id="gantt_here" style="width: 100%; height:100%;"></div>


    <script type="text/javascript">
        gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
        // gantt.scrollLayoutCell("resourceTimeline", 500);
        gantt.config.scales = [
            // {
            //     unit: "year",
            //     step: 1,
            //     format: "%Y"
            // },
            {
                unit: "month",
                step: 1,
                format: "%F, %Y"
            },
            {
                unit: "day",
                step: 1,
                format: "%d, %D" // "%j, %D"
            }
        ];
        gantt.config.fit_tasks = false;
        // gantt.config.scale_offset_minimal = false;
        gantt.config.branch_loading = true;
        gantt.config.drag_move = false;

        gantt.plugins({
            tooltip: true
        });
        gantt.attachEvent("onGanttReady", function() {
            var tooltips = gantt.ext.tooltips;
            tooltips.tooltip.setViewport(gantt.$task_data);
        });

        gantt.templates.tooltip_text = function(start, end, task) {
            $tp = "<b>name:</b> " + task.text +
                "<br/><b>Department:</b> " + task.department +
                "<br/><b>Start:</b> " + task.start_date +
                "<br/><b>End:</b> " + task.end_date +
                "<br/><b>Duration:</b> " + task.duration;
            return $tp;
            // "<b>Taskxxx:</b> " + task.text + "<br/><b>Duration:</b> " + task.duration;
        };

        gantt.plugins({
		marker: true
	});

	var dateToStr = gantt.date.date_to_str(gantt.config.task_date);
	var today = new Date;
    console.log(today);
	gantt.addMarker({
		start_date: today,
		css: "today",
		text: "Today",
		title: "Today: " + dateToStr(today)
	});

        gantt.init("gantt_here");
        // gantt.init("gantt_here", new Date(2022, 8, 1), new Date(2024, 10, 1));
        // gantt.scrollLayoutCell("resourceTimeline", 500);
        // gantt.scrollTo(30, null);

        // gantt.config.scales = [{
        //     // unit: "year",
        //     // step: 0,
        //     // format: "%M, %Y",

        //     unit: "day",
        //     step: 1,
        //     format: "%W, %D"
        //     // "%j, %D"
        // }];

        // gantt.templates.scale_cell_class = function(date) {
        //     if (date.getDay() == 0 || date.getDay() == 6) {
        //         return "weekend";
        //     }
        // };
        // gantt.render();
        // gantt.config.scale_height = 70;
        // gantt.config.min_column_width = 10;
        gantt.config.columns = [{
                name: "text",
                label: "name",
                tree: true,
                width: "*"
            },
            {
                name: "start_date",
                label: "Start date",
                align: "center"
            },
            // {name:"end_date",   label:"End date",   align:"center" },
            {
                name: "duration",
                label: "duration",
                align: "center"
            },
            {
                name: "progress",
                label: "Progress",
                align: "center"
            },
        ]

        gantt.load("/api/data/8");

        var dp = new gantt.dataProcessor("/api");

        // console.log(dp);

        // gantt.config.layout = without_grids_layout;
        // ********************* initiate **********************//
        dp.init(gantt);
        dp.setTransactionMode("REST");
    </script>
</body>

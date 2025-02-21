@extends('main.event.layout.gantt-layout')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->


<div class="content">

<div class="mt-4">
        <div class="row g-4">
            <!-- this controls the size of the table  -->
            <div class="col-12 col-sm-10 order-1 order-xl-0">
                <div class="mb-9">

                    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Audience List</h4>
                                </div>
    <div id="gantt_here" style="width: 100%; height:100%;"></div>

    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@include('main.partials.event-js')

<script type="text/javascript">
    console.log('gantt');
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
    // gantt.config.fit_tasks = false;
    // gantt.config.scale_offset_minimal = false;

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

    console.log('before load api');
    gantt.load("/api/data");
    console.log('after load api');

    var dp = new gantt.dataProcessor("/api");

    console.log(dp);

    // gantt.config.layout = without_grids_layout;
    // ********************* initiate **********************//
    dp.init(gantt);
    dp.setTransactionMode("REST");
</script>

@endpush

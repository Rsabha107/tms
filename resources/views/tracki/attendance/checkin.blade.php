@extends('main.attendance.layout.dashboard')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<section class="bg-body dark__bg-gray-1000 pb-10 pt-15 overflow-hidden">

<div class="container-small px-lg-7 px-xxl-3">
  <div class="position-absolute w-100 h-100 start-0 end-0 opacity-50" style="bottom: -350px; transform: skewY(-8deg); background: linear-gradient(102.27deg, #38ABFF 4.69%, #3874FF 106.27%)"></div>
  <div class="bg-holder" style="background-image:url(../../assets/img/bg/bg-left-24.png);background-size:auto;background-position:left center;">
  </div>
  <!--/.bg-holder-->

  <div class="bg-holder" style="background-image:url(../../assets/img/bg/bg-right-24.png);background-size:auto;background-position:right center;">
  </div>
  <!--/.bg-holder-->

  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <div class="card py-md-9 px-md-13 border-0 z-1 shadow-lg">
        <div class="bg-holder" style="background-image:url(../../assets/img/bg/bg-38.png);background-position:center;background-size:100%;">
        </div>
        <!--/.bg-holder-->

        <div class="card-body position-relative"><img class="img-fluid mb-5 d-dark-none" src="../../assets/img/spot-illustrations/37.png" width="260" alt="..." /><img class="img-fluid mb-5 d-light-none" src="../../assets/img/spot-illustrations/37_2.png" width="260" alt="..." />
          <p class="fw-bold">Come Join us <span class="text-primary fs-6">.</span> Come SPRING with us</p>
          <h1 class="fs-6 fs-sm-4 fs-lg-2 fw-bolder lh-sm mb-3">Join<span class="gradient-text-primary mx-2">PRINTEMPS</span><span>Today</span></h1>
          <form class="d-flex justify-content-center mb-3 px-xxl-15" action="{{route('main.attendance.info')}}" method="post">
          @csrf
            <div class="d-grid d-sm-block"></div>
            <input class="form-control me-3" name="document_id" id='documentID' onmouseover='this.focus();' id="ctaEmail1" type="text" placeholder="Attendee Number" aria-describedby="ctaEmail1" />
            <button class="btn btn-primary" type="submit">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of .container-->

</section>


    @endsection

    @push('script')

    <script type="text/javascript">
        $(document).ready(function() {

            var selectEventAssignment = $("#selectedEventAssignment").val();

            console.log(selectEventAssignment);

            $('#selectedEventAssignment').change(function() {
                // alert($(this).val());
                selectEventAssignment = $(this).val();
                console.log(selectEventAssignment);

            })

            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
                console.log(selectEventAssignment);
            });

            $('#assignToEvent').click(function(e) {

                var all_selected_ids = [];
                $('input:checkbox[name=ids]:checked').each(function() {
                    all_selected_ids.push($(this).val());
                    console.log('pushing in array: ' + $(this).val() + ' for event: ' + selectEventAssignment);
                });

                $.ajax({
                    url: "{{ route('main.attendance.assignevents') }}",
                    type: "post",
                    data: {
                        ids: all_selected_ids,
                        event_id: selectEventAssignment,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // $notification = array(
                        //     'message' => 'Event created successfully',
                        //     'alert-type' => 'success'
                        // );
                        x = "{{route('main.task.list',':selectEventAssignment')}}"
                        rt = x.replace (':selectEventAssignment', selectEventAssignment)
                        window.location.href = rt;
                        console.log('event id: '+ x)
                        $.each(all_selected_ids, function(key, val) {
                            // $('#attendance_ids'+val).remove();
                        })
                    }
                });
            });

            $('#dataList').DataTable({
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdf',
                //     // 'colvis'
                // ]
                // buttons: [{
                //     extend: 'collection',
                //     text: 'Export',
                //     buttons: [{
                //             extend: 'copyHtml5',
                //             exportOptions: {
                //                 columns: [0, ':visible']
                //             }
                //         },
                //         {
                //             extend: 'excelHtml5',
                //             exportOptions: {
                //                 columns: ':visible'
                //             }
                //         },
                //         {
                //             extend: 'csvHtml5',
                //             exportOptions: {
                //                 columns: ':visible'
                //             }
                //         },
                //         {
                //             extend: 'pdfHtml5',
                //             exportOptions: {
                //                 columns: [0, 1, 2, 5]
                //             }
                //         },
                //         'colvis'
                //     ],
                // }]
            });
        });
    </script>

    @include('main.partials.event-js')

    @endpush

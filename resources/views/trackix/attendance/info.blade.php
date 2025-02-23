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

                    <div class="row flex-between-center px-xl-11 false">
                        <div class="col-md-6 order-1 order-md-0 text-center text-md-start">
                            <h4 class="mb-3">Checked 'n'</h4>
                            @forelse ($attendData as $item )
                            <div class="alert alert-subtle-success" role="alert">thank you for attending!.. say it</div>
                            <div class="d-flex flex-column align-items-center align-items-md-start gap-3 gap-md-0">
                                <div class="d-md-flex align-items-center">
                                    <div class="icon-wrapper shadow-info"><span class="uil uil-smile text-primary fs-4 z-1 ms-2" data-bs-theme="light"></span></div>
                                    <div class="flex-1 ms-3"><a class="link-900" href="tel:+871406-7509">{{ $item->first_name }}&nbsp; {{ $item->last_name }}</a></div>
                                </div>
                                <div class="d-md-flex align-items-center">
                                    <div class="icon-wrapper shadow-info"><span class="uil uil-phone text-primary fs-4 z-1 ms-2" data-bs-theme="light"></span></div>
                                    <div class="flex-1 ms-3"><a class="link-900" href="tel:+871406-7509">{{$item->phone_number}}</a></div>
                                </div>
                                <div class="d-md-flex align-items-center">
                                    <div class="icon-wrapper shadow-info"><span class="uil uil-envelope text-primary fs-4 z-1 ms-2" data-bs-theme="light"></span></div>
                                    <div class="flex-1 ms-3"><a class="fw-semibold text-body" href="mailto:phoenix@email.com">{{$item->email_address}}</a></div>
                                </div>
                                <div class="mb-6 d-md-flex align-items-center">
                                    <div class="icon-wrapper shadow-info"><span class="uil uil-map-marker text-primary fs-4 z-1 ms-2" data-bs-theme="light"></span></div>
                                    <div class="flex-1 ms-3"><a class="fw-semibold text-body" href="#!">{{$item->address}}</a></div>
                                </div>
                                <!-- <div class="d-flex"><a href="#!"><span class="fa-brands fa-facebook fs-6 text-primary me-3"></span></a><a href="#!"><span class="fa-brands fa-twitter fs-6 text-primary me-3"></span></a><a href="#!"><span class="fa-brands fa-linkedin-in fs-6 text-primary"></span></a></div> -->
                            </div>
                            @empty
                            <div class="alert alert-subtle-danger" role="alert"><span class="fas fa-info-circle text-warning fs-5 me-3"></span>I could find the invitation.  please take down the person's information.  NAME, EMAIL, PHONE NUMBER</div>
                            @endforelse
                            <!-- <p class="mb-5">Grow with Phoenix. We help you with everything you might need, We make it easy and keep it simple.</p><a class="btn btn-link me-2 p-0 fs-9" href="#!" role="button">Check Demo<i class="fa-solid fa-angle-right ms-2"></i></a> -->
                        </div>
                        <div class="col-md-5 mb-5 mb-md-0 text-center"><img class="w-75 w-md-100 d-dark-none" src="{{asset('assets/img/spot-illustrations/36.png')}}" alt="" /><img class="w-75 w-md-100 d-light-none" src="{{asset('assets/img/spot-illustrations/36_2.png')}}" alt="" /></div>
                    </div>
                </div>


                <div class="card-body position-relative">
                    <!-- <p class="fw-bold">Come Join us <span class="text-primary fs-6">.</span> Come SPRING with us</p> -->
                    <h1 class="fs-6 fs-sm-4 fs-lg-2 fw-bolder lh-sm mb-3 mt-3">Join<span class="gradient-text-primary mx-2">PRINTEMPS</span><span>Today</span></h1>
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

        $('#documentID').focus();
    });
</script>

@include('main.partials.event-js')

@endpush

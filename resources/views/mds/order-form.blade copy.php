@extends('main.layout.dashboard')
@section('main')


<div class="content">
    <div class="position-fixed w-100 z-index-5 mx-n4 mx-lg-n6 bg-white border-bottom border-300" style="top: 65px">
        <nav class="simplebar-scrollspy navbar py-0 scrollbar-overlay" id="widgets-scrollspy">
            <ul class="nav">
                <li class="nav-item"> <a class="test nav-link text-700 fw-bold py-3 lh-1 text-nowrap"
                        href="#scrollspyOrderform">Order Details</a></li>
                <li class="nav-item"> <a class="test nav-link text-700 fw-bold py-3 lh-1 text-nowrap"
                        href="#scrollspyOrderItems">Order Items</a></li>

            </ul>
        </nav>
    </div>
    <div class="mb-9" data-bs-spy="scroll" data-bs-target="#widgets-scrollspy">


        <div class="d-flex mb-5 pt-7" id="scrollspyOrderform"><span class="fa-stack me-2 ms-n1"><i
                    class="fas fa-circle fa-stack-2x text-primary"></i><i
                    class="fa-inverse fa-stack-1x text-primary-soft fas fa-user-friends"
                    data-fa-transform="shrink-4"></i></span>
            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold"><span class="bg-soft pe-2">Order Details</span><span
                        class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                </h3>
                <p class="mb-0">User engagement and personalized content presentation.</p>
            </div>
        </div>
        <!-- <form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm"> -->
        <form class="row g-3 needs-validation" novalidate="" method="POST" action="#" id="createOrderForm">
            @csrf
            <div class="card mb-5">
                <!-- <div class="card-header"> -->
                <!-- <h5 class="fs-1 mb-0">Orders Details</h2> -->
                <!-- </div> -->
                <!-- <div class="card-body">
                        <h1 class="lh-sm fs-2 fs-xxl-4 mb-2">Brandmyth presents- Shironamhin 25 years celebration with
                            symphony orchestra</h1> -->
                <div class="card-body">
                    <!-- <h5 class="fs-1 mb-5">Orders Details</h2> -->

                    <div class="row justify-content-xl-between">
                        <div class="col-auto">
                            <div class="col-xxl-12">
                                <div class="row gx-3 gy-4">
                                    <!-- <h4 class="fs-1 mb-0">Event Details</h4> -->
                                    <!-- <div class="col-sm-6 col-md-12">
                                        <div class="form-floating">
                                            <input name="venue_name" class="form-control" id="floatingVenueNameInput" type="text"
                                                placeholder="Event title" required="">
                                            <label for="floatingEventInput">Venue Name</label>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">Please provide a value.</div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="site_type" class="form-select" id="floatingSiteType">
                                                <option selected="selected">Select site type</option>
                                                <option value="1">technical</option>
                                                <option value="2">external</option>
                                                <option value="3">organizational</option>
                                            </select>
                                            <label for="floatingSelectTask">Site type</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="site_category" class="form-select" id="floatingSiteCategory">
                                                <option selected="selected">Select site category</option>
                                                <option value="1">technical</option>
                                                <option value="2">external</option>
                                                <option value="3">organizational</option>
                                            </select>
                                            <label for="floatingSelectTask">Site category</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="site_code" class="form-select" id="floatingSiteCode">
                                                <option selected="selected">Select site code</option>
                                                <option value="1">technical</option>
                                                <option value="2">external</option>
                                                <option value="3">organizational</option>
                                            </select>
                                            <label for="floatingSelectTask">Site code</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="site_name" class="form-select" id="floatingSelectSiteName">
                                                <option selected="selected">Select site name</option>
                                                <option value="1">Data select topic One</option>
                                                <option value="2">Data select topic Two</option>
                                                <option value="3">Data select topic Three</option>
                                            </select>
                                            <label for="floatingSelectPrivacy">Site name</label>
                                        </div>
                                    </div>
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="validation-example">
                                        Logical Space<a class="anchorjs-link " aria-label="Anchor"
                                            data-anchorjs-icon="#" href="javascript void(0)"
                                            style="padding-left: 0.375em;"></a></h4>
                                    <!-- <h4>Logical Space</h4> -->
                                    <div class="col-12 mt-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="inlineRadio1" type="radio"
                                                name="inlineRadioOptions" value="option1" checked="checked" />
                                            <label class="form-check-label" for="inlineRadio1">Online</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="inlineRadio2" type="radio"
                                                name="inlineRadioOptions" value="option2" />
                                            <label class="form-check-label" for="inlineRadio2">Offline</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="inlineRadio3" type="radio"
                                                name="inlineRadioOptions" value="option3" />
                                            <label class="form-check-label" for="inlineRadio3">Both</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-12 mt-md-0 mt-lg-1">
                                        <div class="form-floating">
                                            <input class="form-control" id="floatingVenueInput" type="text"
                                                placeholder="Venue" />
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
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="d-flex mb-5 pt-1" id="scrollspyOrderItems"><span class="fa-stack me-2 ms-n1"><i
                        class="fas fa-circle fa-stack-2x text-primary"></i><i
                        class="fa-inverse fa-stack-1x text-primary-soft fas fa-file-alt"
                        data-fa-transform="shrink-2"></i></span>
                <div class="col">
                    <h3 class="mb-0 text-primary position-relative fw-bold"><span class="bg-soft pe-2">
                            Item Selection</span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    <p class="mb-0">Get different types of data from the user by using Phoenix's customizable form.</p>
                </div>
            </div>
            <div class="row g-1">
                <div class="col-xxl-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <!-- <h5 class="fs-1 mb-5">Item Selection</h2> -->

                            <!-- </div> -->
                            <div class="row g-3">
                                <table class="table" id="productTable">
                                    <tr>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Delivery Date</th>
                                        <th>Comment</th>
                                        <th></th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                    <tr>
                                        <td>

                                            <select class="form-select" data-width="100%" data-select2-id="1"
                                                tabindex="-1" aria-hidden="true" id="item_category"
                                                name="item_category[0]" required>
                                                <option value="" selected>-- Select Country --</option>
                                                @foreach ($item_category as $item_cat)
                                                @if (Request::old('item_category') == $item_cat->item_category_id )
                                                <option value="{{ $item_cat->item_category_id  }}" selected>
                                                    {{ $item_cat->item_category_name }}
                                                </option>
                                                @else
                                                <option value="{{ $item_cat->item_category_id  }}">
                                                    {{ $item_cat->item_category_name }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>

                                        <td><input type="text" name="item_subcategory[0]" placeholder="Enter title"
                                                class="form-control" required></td>
                                        <td><input type="text" name="item_name[0]" placeholder="Enter title"
                                                class="form-control" required></td>
                                        <td><input type="text" name="quatity[0]" placeholder="Enter title"
                                                class="form-control" required></td>
                                        <td><input type="text" name="delivery_date[0]" placeholder="Enter title"
                                                class="form-control" required></td>
                                        <td><input type="text" name="comment[0]" placeholder="Enter title"
                                                class="form-control" required></td>
                                        <td><button class="btn btn-phoenix-primary w-100 add-select" type="button"><span
                                                    class="fa-solid fa-add"></span></button></td>
                                    </tr>
                                </table>

                                <div class="row g-2 mt-7">
                                    <div class="col-12 col-md-auto flex-md-grow-1">
                                        <button class="btn btn-primary w-100" type="submit">Save</button>
                                    </div>
                                    <div class="col-12 col-sm-auto flex-sm-grow-1 flex-md-grow-0">
                                        <button class="btn btn-phoenix-primary w-100" type="button"><span
                                                class="fa-regular fa-calendar-plus me-2"></span>Add to Calendar
                                        </button>
                                    </div>
                                    <div class="col-6 col-sm-auto">
                                        <button class="btn btn-phoenix-primary w-100" type="button"><span
                                                class="fa-solid fa-heart me-2"></span>3677</button>
                                    </div>
                                    <div class="col-6 col-sm-auto">
                                        <button class="btn btn-phoenix-primary w-100 add-select" type="button"><span
                                                class="fa-solid fa-add"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

    </div>


    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')

    <script>
    console.log('here')

    var i = 0;
    var count = 0;

    $('.btn-del-select').hide();
    $(document).on('click', '.add-select', function() {

        count++;
        var html = '';
        html += '<tr>';

        html += '<td>';
        html +=
            '<select class="form-select" data-width="100%" data-select2-id="1" tabindex="-1" aria-hidden="true" id="item_category" name="item_category[' +
            count + ']" required>';
        html += '<option value="">-- Select Country --</option>';
        html += '@foreach ($item_category as $item_cat)';
        html += '@if (Request::old("item_category") == $item_cat->item_category_id )';
        html += '<option value="{{ $item_cat->id }}" selected>';
        html += ' {{ $item_cat->item_category_id }}';
        html += '</option>';
        html += '@else';
        html += '<option value="{{ $item_cat->id }}">';
        html += '{{ $item_cat->item_category_id }}';
        html += '</option>';
        html += ' @endif';
        html += '@endforeach';
        html += '</select>';
        html += '</td>';


        html += '<td><input type="text" name="item_subcategory[' + count +
            '][title]" placeholder="Enter title"  class="form-control" aria-label="Group" required></td>'
        html += '<td><input type="text" name="item_name[' + count +
            '][title]" placeholder="Enter title"  class="form-control" aria-label="Group" required></td>'
        html += '<td><input type="text" name="quatity[' + count +
            '][title]" placeholder="Enter title"  class="form-control" aria-label="Group" required></td>'
        html += '<td><input type="text" name="delivery_date[' + count +
            '][title]" placeholder="Enter title"  class="form-control" aria-label="Group" required></td>'
        html += '<td><input type="text" name="comment[' + count +
            '][title]" placeholder="Enter title"  class="form-control" aria-label="Group" required></td>'
        html +=
            '<td><button class="btn btn-phoenix-danger w-100 remove"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>'

        console.log(html)
        $('#productTable').append(html);
    });

    $(document).on('click', '.remove', function() {
        console.log('remove')
        $(this).closest('tr').remove();
    });
    </script>

    @endpush

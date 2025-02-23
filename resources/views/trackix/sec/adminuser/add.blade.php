@extends('tracki.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="container-fluid bg-body-tertiary dark__bg-gray-1200">
        <div class="bg-holder bg-auth-card-overlay" style="background-image:url(../../../assets/img/bg/37.png);">
        </div>
        <!--/.bg-holder-->

        <div class="row flex-center position-relative min-vh-100 g-0 py-5">
            <div class="col-11 col-sm-10 col-xl-8">
                <div class="card border border-translucent auth-card">
                    <div class="card-body pe-md-0">
                        <div class="row align-items-center gx-0 gy-7">
                            <div class="col mx-auto">
                                <div class="auth-form-box">
                                    <div class="text-center mb-5"><a class="d-flex flex-center text-decoration-none mb-4" href="{{route('tracki.dashboard')}}">
                                            <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                                                <img src="../../../assets/img/icons/LogoPrintemps_2022_vert.png" alt="Printemps" width="58" />
                                            </div>
                                        </a>
                                        <h3 class="text-body-highlight">Create User</h3>
                                        <p class="text-body-tertiary">Create account today</p>
                                    </div>
                                    @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form method="POST" action="{{ route('tracki.sec.adminuser.create') }}" class="needs-validation validatedForm" novalidate>
                                        @csrf
                                        <div class="mb-3 text-start">
                                            <label class="form-label" for="name">User Name</label>
                                            <input class="form-control" name="username" id="user_name" type="text" placeholder="User Name" value="{{ old('user_name') }}" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label class="form-label" for="name">Name</label>
                                            <input class="form-control" id="name" name="name" type="text" placeholder="Name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label class="form-label" for="email">Email address</label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label class="form-label" for="phone">Phone</label>
                                            <input class="form-control" id="phone" name="phone" type="phone" placeholder="phone number" value="{{ old('phone') }}" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label class="form-label" for="photo"><?= get_label('photo', 'photo') ?></label>
                                            <input class="form-control" id="profile_image" name="photo" type="file" placeholder="photo">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="">
                                                <?= get_label('require_email_verification', 'Require email verification?') ?>
                                                <i class='bx bx-info-circle text-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="If 'Yes' is selected, user will receive a verification link via email. Please ensure that email settings are configured and operational."></i>
                                            </label>
                                            <div class="">
                                                <div class="btn-group btn-group d-flex justify-content-center" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" id="require_ev_yes" name="require_ev" value="1" checked>
                                                    <label class="btn btn-outline-primary" for="require_ev_yes"><?= get_label('yes', 'Yes') ?></label>
                                                    <input type="radio" class="btn-check" id="require_ev_no" name="require_ev" value="0">
                                                    <label class="btn btn-outline-primary" for="require_ev_no"><?= get_label('no', 'No') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for=""><?= get_label('status', 'Status') ?> (<small class="text-muted mt-2">If Deactive, user won't be able to log in to their account</small>)</label>
                                            <div class="">
                                                <div class="btn-group btn-group d-flex justify-content-center" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" id="user_active" name="status" value="1">
                                                    <label class="btn btn-outline-primary" for="user_active"><?= get_label('active', 'Active') ?></label>
                                                    <input type="radio" class="btn-check" id="user_deactive" name="status" value="0" checked>
                                                    <label class="btn btn-outline-primary" for="user_deactive"><?= get_label('deactive', 'Deactive') ?></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <!-- <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="faUser" type="radio" name="usertype" value="functional" checked="checked" required/>
                                                <label class="form-check-label" for="inlineRadio1">Functional
                                                    Area</label>
                                            </div> -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="userUser" type="radio" name="usertype" value="user" checked="checked" required/>
                                                <label class="form-check-label" for="inlineRadio2">User</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="adminUser" type="radio" name="usertype" value="admin" required/>
                                                <label class="form-check-label" for="inlineRadio2">Admin</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 text-start" id="WorkspaceSelect">
                                            <label class="form-label" for="email">Initial Workspace</label>
                                            <select name="workspace_id" class="form-select" id="floatingSelectWorkspace">
                                                <option selected="selected" value=""> Select workspace
                                                </option>
                                                @foreach ($workspace as $key => $item )
                                                @if (Request::old('id') == $item->id )
                                                <option value="{{ $item->id  }}" selected>
                                                    {{ $item->title }}
                                                </option>
                                                @else
                                                <option value="{{ $item->id  }}">
                                                    {{ $item->title }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 text-start" id="DepartmentSelect">
                                            <label class="form-label" for="email">Department</label>
                                            <select name="department_id" class="form-select" id="floatingSelectDepartment">
                                                <option selected="selected" value=""> Select department </option>
                                                @foreach ($departments as $key => $item )
                                                @if (Request::old('id') == $item->id )
                                                <option value="{{ $item->id}}" selected>
                                                    {{ $item->name }}
                                                </option>
                                                @else
                                                <option value="{{ $item->id}}">
                                                    {{ $item->name }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-label" for="password">Password</label>
                                                <input class="form-control form-icon-input" name="password" id="password" type="password" placeholder="Password" required>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-label" for="password_confirmation">Confirm
                                                    Password</label>
                                                <input class="form-control form-icon-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-9 mb-3">
                                            @foreach ($roles as $key => $item )
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="inlineCheckbox{{$item->id}}" type="checkbox" name="roles[]" value="{{$item->id}}">
                                                <label class="form-check-label" for="inlineCheckbox{{$item->id}}">{{$item->name}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <!-- <div class="form-check mb-3">
                                            <input class="form-check-input" id="termsService" type="checkbox" required>
                                            <label class="form-label fs-9 text-transform-none" for="termsService">I
                                                accept the <a href="#!">terms </a>and <a href="#!">privacy
                                                    policy</a></label>
                                        </div> -->
                                        <button class="btn btn-primary w-100 mb-3" type="submit">Create now</button>
                                        <!-- <div class="text-center"><a class="fs-9 fw-bold" href="{{route('tracki.auth.login')}}">Sign in to an existing account</a></div> -->
                                        <div class="text-center"><a class="fs-9 fw-bold" href="{{route('tracki.sec.adminuser.list')}}">Go back to list</a></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')
    <script>
        $(document).ready(function() {
            console.log('fauser checked ')
            $("#WorkspaceSelect").show();
            $("#DepartmentSelect").show();
            $("#floatingSelectDepartment").prop('required', true);
            $("#floatingSelectWorkspace").prop('required', true);
            $("input[name=usertype]").change(function() {
                console.log('usertype changing')
                if ($("#userUser").is(':checked')) {
                    $("#WorkspaceSelect").show();
                    $("#DepartmentSelect").show();
                    $("#floatingSelectDepartment").prop('required', true);
                    $("#floatingSelectWorkspace").prop('required', true);

                } else {
                    $("#DepartmentSelect").hide();
                    $("#WorkspaceSelect").hide();
                    $("#floatingSelectWorkspace").prop('required', false);
                    $("#floatingSelectDepartment").prop('required', false);
                }
            });
        });
    </script>
    @endpush

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CommunicationChannels;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Mds\Setting\BookingStatusController;
use App\Http\Controllers\Mds\Setting\DeliveryCargoController;
use App\Http\Controllers\Mds\Setting\DeliveryDriverController;
use App\Http\Controllers\Mds\Setting\DeliveryTypeController;
use App\Http\Controllers\Mds\Setting\DeliveryVehicleController;
use App\Http\Controllers\GeneralSettings\AttachmentController;
use App\Http\Controllers\Mds\Setting\FunctionalAreaController;
use App\Http\Controllers\Mds\Setting\IntervalController;
use App\Http\Controllers\Mds\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Mds\Auth\AdminController as AuthAdminController;
use App\Http\Controllers\Mds\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Mds\Setting\BookingEventController;
use App\Http\Controllers\Mds\Setting\BookingRspController;
use App\Http\Controllers\Mds\Setting\BookingSlotController;
use App\Http\Controllers\Mds\Setting\ScheduleController;
use App\Http\Controllers\StatusController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Mds\Setting\VehicleTypeController;
use App\Http\Controllers\Mds\Setting\VenueController;
use App\Http\Controllers\Mds\Setting\ZoneController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/onedrivetest', [AdminController::class, 'testonedrive']);

Route::get('/tracki/event/gantt/gantt', function () {
    return view('tracki/event/gantt/gantt');
});

// Route::get('/gantt', function () {
//     return view('gantt');
// })->name('gantt');

Route::get('/ganttok', function () {
    return view('ganttok');
});

// Route::get('tracki/users/create-new', function () {
//     return view('tracki/users/create-new');
// });

// Route::get('/manualupdateadminuser', function () {
//     return view('manualupdateadminuser');
// });

// Route::post('mupdateadminuser', [RoleController::class, 'manualUpdateAdminUser'])->name('tracki.sec.adminuser.mupdate');

// Route::get('qrcode', function () {

//     return QrCode::size(100)->generate('A basic example of QR code!');
// });

// Route::get('/data', [GanttController::class, 'get']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::group(['middleware' => 'prevent-back-history', 'XssSanitizer'], function () {

    // PROJECT MANAGEMENT ******************************************************************** Admin All Route
    Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'role:SuperAdmin|SuperMDS', 'roles:admin', 'prevent-back-history', 'auth.session'])->group(function () {

        // Projects Routes
        Route::controller(AdminBookingController::class)->group(function () {

            // booking routes
            Route::get('/', 'index')->name('mds');
            Route::get('/mds/admin/booking', 'index')->name('mds.admin.booking');
            Route::get('/mds/admin/booking/list', 'list')->name('mds.admin.booking.list');
            Route::get('/mds/admin/booking/schedule/{id}', 'listEvent')->name('mds.admin.booking.schedule'); // for calendar
            Route::get('/mds/admin/booking/create', 'create')->name('mds.admin.booking.create');
            Route::get('/mds/admin/booking/manage/{id}', 'manage')->name('mds.admin.booking.manage');
            Route::get('/mds/admin/booking/get/{id}', 'get')->name('mds.admin.booking.get');
            Route::get('/mds/admin/booking/get_times/{date}/{venue_id}', 'get_times')->name('mds.admin.booking.get_times');
            Route::get('/mds/admin/booking/times/cal/{date}/{venue_id}', 'get_times_cal')->name('mds.admin.booking.times.cal');
            Route::post('mds/admin/booking/update', 'update')->name('mds.admin.booking.update');
            Route::get('mds/admin/booking/edit/{id}', 'edit')->name('mds.admin.booking.edit');
            Route::delete('/mds/admin/booking/delete/{id}', 'delete')->name('mds.admin.booking.delete');
            Route::post('/mds/admin/booking/store', 'store')->name('mds.admin.booking.store');
            Route::get('/mds/admin/booking/mv/detail/{id}', 'detail')->name('mds.admin.mv.detail');
            Route::get('/mds/admin/booking/pass/pdf/{id?}', 'passPdf')->name('mds.admin.booking.pass.pdf');

            Route::get('/mds/admin/events/{id}/switch',  'switch')->name('mds.admin.booking.switch');
        });

        Route::controller(VehicleTypeController::class)->group(function () {

            // Vehicle Type
            Route::get('/mds/setting/vehicle_type', 'index')->name('mds.setting.vehicle_type');
            Route::get('/mds/setting/vehicle_type/list', 'list')->name('mds.setting.vehicle_type.list');
            Route::get('/mds/setting/vehicle_type/get/{id}', 'get')->name('mds.setting.vehicle_type.get');
            Route::post('mds/setting/vehicle_type/update', 'update')->name('mds.setting.vehicle_type.update');
            Route::delete('/mds/setting/vehicle_type/delete/{id}', 'delete')->name('mds.setting.vehicle_type.delete');
            Route::post('/mds/setting/vehicle_type/store', 'store')->name('mds.setting.vehicle_type.store');
        });

        // schedules
        Route::controller(ScheduleController::class)->group(function () {
            Route::get('/mds/setting/schedule', 'index')->name('mds.setting.schedule');
            Route::get('/mds/setting/schedule/list', 'list')->name('mds.setting.schedule.list');
            Route::get('/mds/setting/schedule/get/{id}', 'get')->name('mds.setting.schedule.get');
            Route::post('mds/setting/schedule/update', 'update')->name('mds.setting.schedule.update');
            Route::delete('/mds/setting/schedule/delete/{id}', 'delete')->name('mds.setting.schedule.delete');
            Route::post('/mds/setting/schedule/store', 'store')->name('mds.setting.schedule.store');
        });

        // schedules
        Route::controller(BookingSlotController::class)->group(function () {
            Route::get('/mds/setting/schedule/import', 'showImportForm')->name('mds.setting.schedule.import');
            Route::post('/import', 'import')->name('mds.setting.scheudle.import');
        });

        // intervals
        Route::controller(IntervalController::class)->group(function () {
            Route::get('/mds/setting/interval', 'index')->name('mds.setting.interval');
            Route::get('/mds/setting/interval/list/{id?}', 'list')->name('mds.setting.interval.list');
            Route::get('/mds/setting/interval/manage/{id}', 'manage')->name('mds.setting.interval.manage');
            Route::get('/mds/setting/interval/get/{id}', 'get')->name('mds.setting.interval.get');
            Route::post('mds/setting/interval/update', 'update')->name('mds.setting.interval.update');
            Route::delete('/mds/setting/interval/delete/{id}', 'delete')->name('mds.setting.interval.delete');
            Route::post('/mds/setting/interval/store', 'store')->name('mds.setting.interval.store');
        });

        // Drivers
        Route::controller(DeliveryDriverController::class)->group(function () {
            Route::get('/mds/setting/driver', 'index')->name('mds.setting.driver');
            Route::get('/mds/setting/driver/list', 'list')->name('mds.setting.driver.list');
            Route::get('/mds/setting/driver/get/{id}', 'get')->name('mds.setting.driver.get');
            Route::post('mds/setting/driver/update', 'update')->name('mds.setting.driver.update');
            Route::delete('/mds/setting/driver/delete/{id}',  'delete')->name('mds.setting.driver.delete');
            Route::post('/mds/setting/driver/store', 'store')->name('mds.setting.driver.store');
            Route::post('mds/driver/status/update', 'updateStatus')->name('mds.driver.status.update');
            Route::get('mds/driver/status/edit/{id}', 'editStatus')->name('mds.driver.status.edit');
        });

        // vehicles
        Route::controller(DeliveryVehicleController::class)->group(function () {
            Route::get('/mds/setting/vehicle', 'index')->name('mds.setting.vehicle');
            Route::get('/mds/setting/vehicle/list', 'list')->name('mds.setting.vehicle.list');
            Route::get('/mds/setting/vehicle/get/{id}', 'get')->name('mds.setting.vehicle.get');
            Route::post('mds/setting/vehicle/update', 'update')->name('mds.setting.vehicle.update');
            Route::delete('/mds/setting/vehicle/delete/{id}', 'delete')->name('mds.setting.vehicle.delete');
            Route::post('/mds/setting/vehicle/store', 'store')->name('mds.setting.vehicle.store');
            Route::post('mds/vehicle/status/update', 'updateStatus')->name('mds.vehicle.status.update');
            Route::get('mds/vehicle/status/edit/{id}', 'editStatus')->name('mds.vehicle.status.edit');
        });

        // Venue
        Route::controller(VenueController::class)->group(function () {
            Route::get('/mds/setting/venue', 'index')->name('mds.setting.venue');
            Route::get('/mds/setting/venue/list', 'list')->name('mds.setting.venue.list');
            Route::get('/mds/setting/venue/get/{id}', 'get')->name('mds.setting.venue.get');
            Route::post('mds/setting/venue/update', 'update')->name('mds.setting.venue.update');
            Route::delete('/mds/setting/venue/delete/{id}', 'delete')->name('mds.setting.venue.delete');
            Route::post('/mds/setting/venue/store', 'store')->name('mds.setting.venue.store');
        });

        // loading zone
        Route::controller(ZoneController::class)->group(function () {
            Route::get('/mds/setting/zone', 'index')->name('mds.setting.zone');
            Route::get('/mds/setting/zone/list', 'list')->name('mds.setting.zone.list');
            Route::get('/mds/setting/zone/get/{id}', 'get')->name('mds.setting.zone.get');
            Route::post('mds/setting/zone/update', 'update')->name('mds.setting.zone.update');
            Route::delete('/mds/setting/zone/delete/{id}', 'delete')->name('mds.setting.zone.delete');
            Route::post('/mds/setting/zone/store', 'store')->name('mds.setting.zone.store');
        });


        // Delivery Type
        Route::controller(DeliveryTypeController::class)->group(function () {
            Route::get('/mds/setting/delivery_type', 'index')->name('mds.setting.delivery_type');
            Route::get('/mds/setting/delivery_type/list', 'list')->name('mds.setting.delivery_type.list');
            Route::get('/mds/setting/delivery_type/get/{id}', 'get')->name('mds.setting.delivery_type.get');
            Route::post('mds/setting/delivery_type/update', 'update')->name('mds.setting.delivery_type.update');
            Route::delete('/mds/setting/delivery_type/delete/{id}', 'delete')->name('mds.setting.delivery_type.delete');
            Route::post('/mds/setting/delivery_type/store', 'store')->name('mds.setting.delivery_type.store');
        });

        // Cargo Type
        Route::controller(DeliveryCargoController::class)->group(function () {
            Route::get('/mds/setting/cargo', 'index')->name('mds.setting.cargo');
            Route::get('/mds/setting/cargo/list', 'list')->name('mds.setting.cargo.list');
            Route::get('/mds/setting/cargo/get/{id}', 'get')->name('mds.setting.cargo.get');
            Route::post('mds/setting/cargo/update', 'update')->name('mds.setting.cargo.update');
            Route::delete('/mds/setting/cargo/delete/{id}', 'delete')->name('mds.setting.cargo.delete');
            Route::post('/mds/setting/cargo/store', 'store')->name('mds.setting.cargo.store');
        });

        // Functional Area
        Route::controller(FunctionalAreaController::class)->group(function () {
            Route::get('/mds/setting/funcareas', 'index')->name('mds.setting.funcareas');
            Route::get('/mds/setting/funcareas/list', 'list')->name('mds.setting.funcareas.list');
            Route::get('/mds/setting/funcareas/get/{id}', 'get')->name('mds.setting.funcareas.get');
            Route::post('mds/setting/funcareas/update', 'update')->name('mds.setting.funcareas.update');
            Route::delete('/mds/setting/funcareas/delete/{id}', 'delete')->name('mds.setting.funcareas.delete');
            Route::post('/mds/setting/funcareas/store', 'store')->name('mds.setting.funcareas.store');
        });

        //Event
        Route::controller(BookingEventController::class)->group(function () {
            Route::get('/mds/setting/event', 'index')->name('mds.setting.event');
            Route::get('/mds/setting/event/list', 'list')->name('mds.setting.event.list');
            Route::get('/mds/setting/event/get/{id}', 'get')->name('mds.setting.event.get');
            Route::post('mds/setting/event/update', 'update')->name('mds.setting.event.update');
            Route::delete('/mds/setting/event/delete/{id}', 'delete')->name('mds.setting.event.delete');
            Route::post('/mds/setting/event/store', 'store')->name('mds.setting.event.store');
        });

        //Event
        Route::controller(BookingRspController::class)->group(function () {
            Route::get('/mds/setting/rsp', 'index')->name('mds.setting.rsp');
            Route::get('/mds/setting/rsp/list', 'list')->name('mds.setting.rsp.list');
            Route::get('/mds/setting/rsp/get/{id}', 'get')->name('mds.setting.rsp.get');
            Route::post('mds/setting/rsp/update', 'update')->name('mds.setting.rsp.update');
            Route::delete('/mds/setting/rsp/delete/{id}', 'delete')->name('mds.setting.rsp.delete');
            Route::post('/mds/setting/rsp/store', 'store')->name('mds.setting.rsp.store');
        });

        //Booking Status
        Route::controller(BookingStatusController::class)->group(function () {
            Route::get('/mds/setting/status/booking', 'index')->name('mds.setting.status.booking');
            Route::get('/mds/setting/status/booking/list', 'list')->name('mds.setting.status.booking.list');
            Route::get('/mds/setting/status/booking/get/{id}', 'get')->name('mds.setting.status.booking.get');
            Route::post('mds/setting/status/booking/update', 'update')->name('mds.setting.status.booking.update');
            Route::delete('/mds/setting/status/booking/delete/{id}', 'delete')->name('mds.setting.status.booking.delete');
            Route::post('/mds/setting/status/booking/store', 'store')->name('mds.setting.status.booking.store');
        });
    });

    // PROJECT MANAGEMENT ******************************************************************** Admin All Route
    Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'role:Customer', 'roles:user', 'prevent-back-history', 'auth.session'])->group(function () {

        // Projects Routes
        Route::controller(CustomerBookingController::class)->group(function () {

            // booking routes
            Route::get('/', 'index')->name('mds');
            Route::get('/mds/customer/booking', 'index')->name('mds.customer.booking');
            Route::get('/mds/customer/booking/list', 'list')->name('mds.customer.booking.list');
            Route::get('/mds/customer/booking/schedule/{id}', 'listEvent')->name('mds.customer.booking.schedule'); // for calendar
            Route::get('/mds/customer/booking/create', 'create')->name('mds.customer.booking.create');
            Route::get('/mds/customer/booking/manage/{id}', 'manage')->name('mds.customer.booking.manage');
            Route::get('/mds/customer/booking/get/{id}', 'get')->name('mds.customer.booking.get');
            Route::get('/mds/customer/booking/get_times/{date}/{venue_id}', 'get_times')->name('mds.customer.booking.get_times');
            Route::get('/mds/customer/booking/times/cal/{date}/{venue_id}', 'get_times_cal')->name('mds.customer.booking.times.cal');
            Route::post('mds/customer/booking/update', 'update')->name('mds.customer.booking.update');
            Route::get('mds/customer/booking/edit/{id}', 'edit')->name('mds.customer.booking.edit');
            Route::delete('/mds/customer/booking/delete/{id}', 'delete')->name('mds.customer.booking.delete');
            Route::post('/mds/customer/booking/store', 'store')->name('mds.customer.booking.store');
            Route::get('/mds/customer/booking/mv/detail/{id}', 'detail')->name('mds.customer.mv.detail');
            Route::get('/mds/customer/booking/pass/pdf/{id?}', 'passPdf')->name('mds.customer.booking.pass.pdf');

            Route::get('/mds/customer/events/{id}/switch',  'switch')->name('mds.customer.booking.switch');

    
        });

    });
});


// ****************** ADMIN *********************
Route::group(['middleware' => 'prevent-back-history'], function () {

    // Add User
    Route::get('/mds/auth/signup', [AuthAdminController::class, 'signUp'])->name('mds.auth.signup');
    Route::post('/signup/store', [UserController::class, 'store'])->name('admin.signup.store');

    Route::middleware(['auth', 'prevent-back-history'])->group(function () {
        // Route::get('/', function () {
        //     return view('/mds/admin/booking');
        // });

        Route::get('/mds/admin/booking/pick', function () {
            return view('/mds/admin/booking/pick');
        })->name('mds.admin.booking.pick')->middleware('role:SuperAdmin');
        Route::post('/mds/admin/events/switch', [AdminBookingController::class, 'pickEvent'])->name('mds.admin.booking.event.switch')->middleware('role:SuperAdmin');

        Route::get('/mds/customer/booking/pick', function () {
            return view('/mds/customer/booking/pick');
        })->name('mds.customer.booking.pick')->middleware('role:Customer');
        Route::post('/mds/customer/events/switch', [CustomerBookingController::class, 'pickEvent'])->name('mds.customer.booking.event.switch')->middleware('role:Customer');

        Route::get('/mds/logout', [AuthAdminController::class, 'logout'])->name('mds.logout');

        Route::get('/mds/admin/booking/confirmation', function () {
            return view('/mds/admin/booking/confirmation');
        })->name('mds.admin.booking.confirmation');

        Route::get('/mds/booking/pass/pdf/{id}', [BookingController::class, 'passPdf'])->name('mds.booking.pass.pdf');

        //Booking note
        Route::get('/mds/admin/booking/mv/notes/{id}', [BookingController::class, 'getNotesView'])->name('mds.admin.booking.mv.notes');
        Route::post('mds/admin/booking/note/store', [BookingController::class, 'noteStore'])->name('mds.admin.booking.note.store');
        Route::delete('mds/admin/booking/note/delete/{id}', [BookingController::class, 'deleteNote'])->name('mds.admin.booking.note.delete');

        //Booking file upload
        Route::post('mds/admin/booking/file/store', [BookingController::class, 'fileStore'])->name('mds.admin.booking.file.store');
        Route::delete('mds/admin/booking/file/{id}/delete', [BookingController::class, 'fileDelete'])->name('mds.admin.booking.file.delete');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/mds/users/profile', [UserController::class, 'profile'])->name('mds.users.profile');

        // yajra datatabels
        Route::get('/mds/booking/test', [BookingController::class, 'test'])->name('mds.booking.test');

        //Status
        Route::get('/mds/setup/status/manage', [StatusController::class, 'index'])->name('mds.setup.status.manage');
        Route::get('/mds/setup/status/list', [StatusController::class, 'list'])->name('mds.setup.status.list');
        Route::get('/mds/setup/status/{id}/get', [StatusController::class, 'get'])->name('mds.setup.status.get');
        Route::post('mds/setup/status/update', [StatusController::class, 'update'])->name('mds.setup.status.update');
        Route::delete('/mds/setup/status/{id}/delete', [StatusController::class, 'delete'])->name('mds.setup.status.delete');
        Route::post('/mds/setup/status/store', [StatusController::class, 'store'])->name('mds.setup.status.store');

        // Charts
        Route::get('/charts/piechart', [ChartsController::class, 'pieChart'])->name('charts.pie');
        Route::get('/charts/piechart2', [ChartsController::class, 'pieChart'])->name('charts.pie2');
        Route::get('/charts/charts', [ChartsController::class, 'eventDash'])->name('charts.dashboard');
    });

    require __DIR__ . '/auth.php';

    // file manager routes
    Route::middleware(['auth', 'otp', 'XssSanitizer', 'role:SuperAdmin|Procurement', 'roles:admin', 'prevent-back-history', 'auth.session'])->group(function () {
        Route::controller(AttachmentController::class)->group(function () {
            Route::post('file/store', 'store')->name('file.store');
            Route::get('/global/files/list/{id?}', 'list')->name('global.files.list')->middleware('permission:employee.file.list');
            // Route::get('/global/files/list/{project?}', 'list')->name('global.files.list')->middleware('permission:employee.file.list');
            Route::get('/global/file/serve/{file}', 'serve')->name('global.file.serve');
            Route::delete('/global/files/delete/{id}', 'delete')->name('global.files.delete');
        });
    });

    // Admin Group Middleware
    Route::middleware(['auth', 'role:admin', 'prevent-back-history'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
        Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    });  // End groupd admin middleware

    // Route::middleware(['auth', 'role:agent'])->group(function () {
    //     Route::get('/agent/dashboard', [AgentController::class, 'agentDashboard'])->name('agent.dashboard');
    // });  // End groupd agent middleware

    Route::middleware(['prevent-back-history'])->group(function () {

        // Route::get('/tracki/auth/login', [AdminController::class, 'login'])->name('tracki.auth.login')->middleware('prevent-back-history');
        Route::get('/mds/auth/login', [AuthAdminController::class, 'login'])->name('mds.auth.login')->middleware('prevent-back-history');

        Route::get('/mds/auth/forgot', [AdminController::class, 'forgotPassword'])->name('mds.auth.forgot');
        Route::post('forget-password', [AdminController::class, 'submitForgetPasswordForm'])->name('forgot.password.post');
        Route::get('tracki/auth/reset/{token}', [AdminController::class, 'showResetPasswordForm'])->name('reset.password.get');
        Route::post('reset-password', [AdminController::class, 'submitResetPasswordForm'])->name('reset.password.post');


        Route::get('/send-mail', [SendMailController::class, 'index']);
        Route::get('/send-mail2', [SendMailController::class, 'sendTaskAssignmentEmail']);

        Route::get('/send', [SendMailController::class, 'sendTaskAssignmentNotifcation']);
        Route::get('/whatsapp', [CommunicationChannels::class, 'sendWhatsapp'])->name('whatsapp.send');
    });

    // HR Security Settings all routes
    Route::middleware(['auth', 'otp', 'XssSanitizer', 'role:SuperAdmin', 'roles:admin', 'prevent-back-history', 'auth.session'])->group(function () {

        Route::controller(RoleController::class)->group(function () {
            //Admin User
            Route::get('/sec/adminuser/list', 'listAdminUser')->name('sec.adminuser.list');
            Route::post('updateadminuser', 'updateAdminUser')->name('sec.adminuser.update');
            Route::post('createadminuser', 'createAdminUser')->name('sec.adminuser.create');
            Route::get('/sec/adminuser/{id}/edit', 'editAdminUser')->name('sec.adminuser.edit');
            Route::get('/sec/adminuser/{id}/delete', 'deleteAdminUser')->name('sec.adminuser.delete');
            Route::get('/sec/adminuser/add', 'addAdminUser')->name('sec.adminuser.add');
            Route::get('/sec/adminuser/add2', 'addAdminUser2')->name('sec.adminuser.add2');

            // Roles
            Route::get('/sec/roles/add', function () {
                return view('/sec/roles/add');
            })->name('sec.roles.add');
            Route::get('/sec/roles/roles/list', 'listRole')->name('sec.roles.list');
            Route::post('updaterole', 'updateRole')->name('sec.roles.update');
            Route::post('createrole', 'createRole')->name('sec.roles.create');
            Route::get('/sec/roles/{id}/edit', 'editRole')->name('sec.roles.edit');
            Route::get('/sec/roles/{id}/delete', 'deleteRole')->name('sec.roles.delete');

            // group
            Route::get('/sec/groups/add', function () {
                return view('/sec/groups/add');
            })->name('sec.groups.add');
            Route::get('/sec/groups/groups/list', 'listGroup')->name('sec.groups.list');
            Route::post('updategroup', 'updateGroup')->name('sec.groups.update');
            Route::post('creategroup', 'createGroup')->name('sec.groups.create');
            Route::get('/sec/groups/{id}/edit', 'editGroup')->name('sec.groups.edit');
            Route::get('/sec/groups/{id}/delete', 'deleteGroup')->name('sec.groups.delete');

            // Permission
            Route::get('/sec/permissions/list', 'listPermission')->name('sec.perm.list');
            Route::post('updatepermission', 'updatePermission')->name('sec.perm.update');
            Route::post('createpermission', 'createPermission')->name('sec.perm.create');
            Route::get('/sec/perm/{id}/edit', 'editPermission')->name('sec.perm.edit');
            Route::get('/sec/perm/{id}/delete', 'deletePermission')->name('sec.perm.delete');
            Route::get('/sec/permissions/add', 'addPermission')->name('sec.perm.add');

            Route::get('/sec/perm/import', 'ImportPermission')->name('sec.perm.import');
            Route::post('importnow', 'ImportNowPermission')->name('sec.perm.import.now');


            // Roles in Permission
            Route::get('/sec/rolesetup/list', 'listRolePermission')->name('sec.rolesetup.list');
            Route::post('updaterolesetup', 'updateRolePermission')->name('sec.rolesetup.update');
            Route::post('createrolesetup', 'createRolePermission')->name('sec.rolesetup.create');
            Route::get('/sec/rolesetup/{id}/edit', 'editRolePermission')->name('sec.rolesetup.edit');
            Route::get('/sec/rolesetup/{id}/delete', 'deleteRolePermission')->name('sec.rolesetup.delete');
            Route::get('/sec/rolesetup/add', 'addRolePermission')->name('sec.rolesetup.add');
        });  //
    });  //
    // Route::get('/run-migration', function () {
    //     Artisan::call('optimize:clear');

    //     Artisan::call('migrate:refresh --seed');
    //     return "Migration executed successfully";
    // });

    // Route::get('echarts', [EchartController::class,'echart']);


    // Route::get("/charts/piechart", "Controller@Piechart");

});

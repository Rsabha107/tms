<?php

use App\Http\Controllers\AddressTypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CommunicationChannels;
// use App\Http\Controllers\GanttController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingStatusController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryCargoController;
use App\Http\Controllers\DeliveryDriverController;
use App\Http\Controllers\DeliveryTypeController;
use App\Http\Controllers\DeliveryVehicleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DriverStatusController;
use App\Http\Controllers\EmployeeAddressController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FunctionalAreaController;
use App\Http\Controllers\IntervalController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ZoneController;
use App\Models\AddressType;
use App\Models\DeliveryCargoType;
use App\Models\DeliveryType;

// use App\Http\Controllers\ProjectController;

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

Route::get('tracki/users/create-new', [ProjectController::class, 'test'])->name('tracki.users.createnew');

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

// ****************** ADMIN *********************
Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::middleware(['auth', 'roles:admin', 'role:SuperAdmin', 'prevent-back-history'])->group(function () {

        Route::get('/tracki/test', function () {
            return view('tracki/test');
        });

        Route::get('/tracki/users/create', function () {
            return view('tracki/users/create');
        });


        // Role
        Route::get('/tracki/sec/roles/add', function () {
            return view('/tracki/sec/roles/add');
        })->name('tracki.sec.roles.add');
        Route::get('/tracki/sec/roles/roles/list', [RoleController::class, 'listRole'])->name('tracki.sec.roles.list');
        Route::post('updaterole', [RoleController::class, 'updateRole'])->name('tracki.sec.roles.update');
        Route::post('createrole', [RoleController::class, 'createRole'])->name('tracki.sec.roles.create');
        Route::get('/tracki/sec/roles/{id}/edit', [RoleController::class, 'editRole'])->name('tracki.sec.roles.edit');
        Route::get('/tracki/sec/roles/{id}/delete', [RoleController::class, 'deleteRole'])->name('tracki.sec.roles.delete');

        // group
        Route::get('/tracki/sec/groups/add', function () {
            return view('/tracki/sec/groups/add');
        })->name('tracki.sec.groups.add');
        Route::get('/tracki/sec/groups/groups/list', [RoleController::class, 'listGroup'])->name('tracki.sec.groups.list');
        Route::post('updategroup', [RoleController::class, 'updateGroup'])->name('tracki.sec.groups.update');
        Route::post('creategroup', [RoleController::class, 'createGroup'])->name('tracki.sec.groups.create');
        Route::get('/tracki/sec/groups/{id}/edit', [RoleController::class, 'editGroup'])->name('tracki.sec.groups.edit');
        Route::get('/tracki/sec/groups/{id}/delete', [RoleController::class, 'deleteGroup'])->name('tracki.sec.groups.delete');

        // Permission
        Route::get('/tracki/sec/permissions/list', [RoleController::class, 'listPermission'])->name('tracki.sec.perm.list');
        Route::post('updatepermission', [RoleController::class, 'updatePermission'])->name('tracki.sec.perm.update');
        Route::post('createpermission', [RoleController::class, 'createPermission'])->name('tracki.sec.perm.create');
        Route::get('/tracki/sec/perm/{id}/edit', [RoleController::class, 'editPermission'])->name('tracki.sec.perm.edit');
        Route::get('/tracki/sec/perm/{id}/delete', [RoleController::class, 'deletePermission'])->name('tracki.sec.perm.delete');
        Route::get('/tracki/sec/permissions/add', [RoleController::class, 'addPermission'])->name('tracki.sec.perm.add');

        Route::get('/tracki/sec/perm/import', [RoleController::class, 'ImportPermission'])->name('tracki.sec.perm.import');
        Route::post('importnow', [RoleController::class, 'ImportNowPermission'])->name('tracki.sec.perm.import.now');


        // Roles in Permission
        Route::get('/tracki/sec/rolesetup/list', [RoleController::class, 'listRolePermission'])->name('tracki.sec.rolesetup.list');
        Route::post('updaterolesetup', [RoleController::class, 'updateRolePermission'])->name('tracki.sec.rolesetup.update');
        Route::post('createrolesetup', [RoleController::class, 'createRolePermission'])->name('tracki.sec.rolesetup.create');
        Route::get('/tracki/sec/rolesetup/{id}/edit', [RoleController::class, 'editRolePermission'])->name('tracki.sec.rolesetup.edit');
        Route::get('/tracki/sec/rolesetup/{id}/delete', [RoleController::class, 'deleteRolePermission'])->name('tracki.sec.rolesetup.delete');
        Route::get('/tracki/sec/rolesetup/add', [RoleController::class, 'addRolePermission'])->name('tracki.sec.rolesetup.add');

        // Add User
        Route::get('/tracki/auth/signup', [AdminController::class, 'signUp'])->name('tracki.auth.signup');
        Route::post('/admin/signup/create', [AdminController::class, 'createUser'])->name('admin.signup.create');
    });  // End group Admin middleware

    Route::middleware(['auth',  'role:Admin|SuperAdmin|Functional Admin', 'roles:admin', 'prevent-back-history'])->group(function () {
        // Admin User
        Route::get('/tracki/sec/adminuser/list', [RoleController::class, 'listAdminUser'])->name('tracki.sec.adminuser.list');
        Route::post('updateadminuser', [RoleController::class, 'updateAdminUser'])->name('tracki.sec.adminuser.update');

        Route::post('createadminuser', [RoleController::class, 'createAdminUser'])->name('tracki.sec.adminuser.create');
        Route::get('/tracki/sec/adminuser/{id}/edit', [RoleController::class, 'editAdminUser'])->name('tracki.sec.adminuser.edit');
        Route::get('/tracki/sec/adminuser/{id}/delete', [RoleController::class, 'deleteAdminUser'])->name('tracki.sec.adminuser.delete');
        Route::get('/tracki/sec/adminuser/add', [RoleController::class, 'addAdminUser'])->name('tracki.sec.adminuser.add');
    });  //

    Route::middleware(['auth', 'prevent-back-history'])->group(function () {
        Route::get('/', function () {
            return view('/tracki/layout/dashboard');
        });

        Route::middleware(['auth', 'role:showGantt'])->group(function () {
            Route::get('/gantt', function () {
                return view('gantt');
            })->name('gantt');
        });

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/tracki/dashboard', [AdminController::class, 'trackiDashboard'])->name('tracki.dashboard');
        Route::get('/tracki/logout', [AdminController::class, 'logout'])->name('tracki.logout');
        Route::get('/tracki/profile', [AdminController::class, 'userProfile'])->name('tracki.profile');
        Route::get('/tracki/orderform', [AdminController::class, 'orderForm'])->name('tracki.orderform');
        Route::post('/tracki/profile/store', [AdminController::class, 'trackiProfileStore'])->name('tracki.profile.store');

        // Calendar
        Route::middleware(['auth', 'role:showCalendar'])->group(function () {
            Route::get('/tracki/calendar/calendar', [EventController::class, 'showCalendar'])->name('tracki.project.show.calendar');
            Route::get('/tracki/calendar/calendardata', [EventController::class, 'showCalendarData'])->name('tracki.project.calendar.data');
        });

        // kanban
        Route::get('/tracki/kanban/{id}/list', [KanbanController::class, 'index'])->name('tracki.kanban.show');
        Route::get('/tracki/kanban/{task_id}/update-status/{status_id}/', [KanbanController::class, 'updateStatus'])->name('tracki.kanban.status.change');

        Route::get('/tracki/project/card/{status?}', [ProjectController::class, 'showCard'])->name('tracki.project.show.card')->middleware('permission:project.show');
        Route::get('/tracki/project/list/{status?}', [ProjectController::class, 'showList'])->name('tracki.project.show.list')->middleware('permission:project.show');
        Route::get('/tracki/project/dtable/{project_id?}', [ProjectController::class, 'getProjectData'])->name('tracki.project.dtable');

        //Project
        Route::middleware(['auth',  'role:Admin|SuperAdmin|Functional Admin', 'roles:admin', 'prevent-back-history'])->group(function () {

            Route::get('Exportnowprojects', [ProjectController::class, 'ExportNowProjects'])->name('tracki.project.export.now');
            Route::get('/tracki/project/archive', [ProjectController::class, 'showArchive'])->name('tracki.project.show.archive');
            Route::get('/tracki/project/{id}/get', [ProjectController::class, 'getProject'])->name('tracki.project.get');
            Route::get('/tracki/project/getwsuser', [ProjectController::class, 'getWsUsers'])->name('tracki.project.get.wsuser');
            Route::get('/tracki/project/{id}/getprojov', [ProjectController::class, 'getProjectOv'])->name('tracki.project.get.getprojov');
            Route::get('tracki/project/add', [ProjectController::class, 'addProject'])->name('tracki.project.add');
            Route::post('/tracki/project/store', [ProjectController::class, 'createProject'])->name('tracki.project.create');
            Route::post('/tracki/project/update', [ProjectController::class, 'updateProject'])->name('tracki.project.update');
            Route::get('/tracki/project/{id}/edit/{source?}', [ProjectController::class, 'editProject'])->name('tracki.project.edit');
            Route::get('/tracki/project/{id}/delete', [ProjectController::class, 'deleteProject'])->name('tracki.project.delete');
            Route::get('/tracki/project/{id}/restore', [ProjectController::class, 'restoreProject'])->name('tracki.project.restore');
            Route::get('/tracki/project/mv/cards/{id?}', [ProjectController::class, 'getProjectCards'])->name('tracki.project.vw.cards');


            //add project note
            Route::post('eventnotestore', [ProjectController::class, 'noteStore'])->name('tracki.event.note.store');
            Route::get('tracki/event/note/{id}/delete', [ProjectController::class, 'deleteEventNote'])->name('tracki.event.delete.note');

            //file project upload
            Route::post('eventfilestore', [ProjectController::class, 'fileStore'])->name('tracki.event.file.store');
            Route::get('tracki/event/file/{id}/delete', [ProjectController::class, 'fileDelete'])->name('tracki.event.file.delete');

            //budget
            Route::get('tracki/budget/utilization', [BudgetController::class, 'budgetUtilization'])->name('tracki.budget.utilization');
            Route::get('tracki/budget/list', [BudgetController::class, 'showBudget'])->name('tracki.budget.list');
            Route::get('tracki/budget/add', [BudgetController::class, 'addBudget'])->name('tracki.budget.add');
            Route::get('tracki/budget/{id}/edit', [BudgetController::class, 'editBudget'])->name('tracki.budget.edit');
            Route::get('tracki/budget/{id}/delete', [BudgetController::class, 'deleteBudget'])->name('tracki.budget.delete');
            Route::post('budgetcreate', [BudgetController::class, 'createBudget'])->name('tracki.budget.create');
            Route::post('budgetupdate', [BudgetController::class, 'updateBudget'])->name('tracki.budget.update');
            Route::post('budgethrocreate', [BudgetController::class, 'createHROrganization'])->name('tracki.budget.create.hrorganization');
            Route::post('budgetnamecreate', [BudgetController::class, 'createBudgetName'])->name('tracki.budget.create.budgetname');

            //buaget to FA mapping
            Route::get('tracki/budget/fam-list', [BudgetController::class, 'showFamBudget'])->name('tracki.budget.fam.list');
            Route::get('tracki/budget/fam-add', [BudgetController::class, 'addFamBudget'])->name('tracki.budget.fam.add');
            Route::get('tracki/budget/{id}/fam-edit', [BudgetController::class, 'editFamBudget'])->name('tracki.budget.fam.edit');
            Route::get('tracki/budget/{id}/fam-delete', [BudgetController::class, 'deleteFamBudget'])->name('tracki.budget.fam.delete');
            Route::post('fambudgetcreate', [BudgetController::class, 'createFamBudget'])->name('tracki.budget.fam.create');
            Route::post('fambudgetupdate', [BudgetController::class, 'updateFamBudget'])->name('tracki.budget.fam.update');
        });

        // Employees
        Route::get('/tracki/employee/', [EmployeeController::class, 'index'])->name('tracki.employee')->middleware('permission:employee.show');
        Route::get('/tracki/employee/add', [EmployeeController::class, 'add'])->name('tracki.employee.add')->middleware('permission:employee.create');
        Route::get('/tracki/employee/list', [EmployeeController::class, 'list'])->name('tracki.employee.show')->middleware('permission:employee.show');
        Route::post('/tracki/employee/store', [EmployeeController::class, 'store'])->name('tracki.employee.store');
        Route::get('/tracki/employee/profile/{id}', [EmployeeController::class, 'profile'])->name('tracki.employee.profile');
        Route::get('tracki/employee/{id}/delete', [EmployeeController::class, 'delete'])->name('tracki.employee.delete');
        Route::post('/tracki/employee/update', [EmployeeController::class, 'update'])->name('tracki.employee.update');
        Route::get('/tracki/employee/mv/edit/{id}', [EmployeeController::class, 'getEmpEditView'])->name('tracki.employee.rv.edit');
        Route::get('/tracki/employee/create', [EmployeeController::class, 'create'])->name('tracki.employee.create');
        Route::get('/tracki/employee/project/{id?}', [EmployeeController::class, 'getProjectData'])->name('tracki.employee.project');
        Route::get('/tracki/employee/task/{id?}', [EmployeeController::class, 'getTaskData'])->name('tracki.employee.task');


        // Employee Address
        Route::get('/tracki/employee/address/{id}', [EmployeeAddressController::class, 'index'])->name('tracki.employee.address')->middleware('permission:employee.show');
        Route::get('/tracki/employee/address/add', [EmployeeAddressController::class, 'add'])->name('tracki.employee.address.add')->middleware('permission:employee.create');
        Route::get('/tracki/employee/address/list/{id?}', [EmployeeAddressController::class, 'list'])->name('tracki.employee.address.show')->middleware('permission:employee.show');
        // Route::get('/tracki/employee/address/show', [EmployeeAddressController::class, 'list'])->name('tracki.employee.address.show')->middleware('permission:employee.show');
        Route::post('/tracki/employee/address/store', [EmployeeAddressController::class, 'store'])->name('tracki.employee.address.store');
        Route::get('tracki/employee/address/delete/{id}', [EmployeeAddressController::class, 'delete'])->name('tracki.employee.address.delete');
        Route::post('/tracki/employee/address/address/update', [EmployeeAddressController::class, 'update'])->name('tracki.employee.address.update');
        Route::get('/tracki/employee/address/mv/edit/{id}', [EmployeeAddressController::class, 'getEmpEditView'])->name('tracki.employee.address.rv.edit');
        // Route::get('/tracki/employee/address/create', [EmployeeAddressController::class, 'create'])->name('tracki.employee.address.create');

        // Tasks
        Route::get('/tracki/task/{id}/add/{modal_yn?}', [TaskController::class, 'addTask'])->name('tracki.task.add')->middleware('permission:task.create');
        Route::get('/tracki/task/{id}/edit', [TaskController::class, 'editTask'])->name('tracki.task.edit')->middleware('permission:task.edit');
        Route::get('/tracki/task/get/{id}', [TaskController::class, 'getTask'])->name('tracki.task.get');
        Route::get('/tracki/task/{id}/getprojectuser', [TaskController::class, 'getProjectUsers'])->name('tracki.project.get.prjoectuser');
        Route::post('createtask', [TaskController::class, 'createTask'])->name('tracki.event.task.create');
        Route::post('/tracki/task/update', [TaskController::class, 'updateTask'])->name('tracki.task.update');


        Route::get('/tracki/task/notes/{id}', [TaskController::class, 'getTaskNotesView'])->name('tracki.task.notes');
        Route::get('/tracki/task/subtask/{id}', [TaskController::class, 'getTaskSubView'])->name('tracki.task.subtask');
        Route::get('/tracki/task/files/{id}', [TaskController::class, 'getTaskFilesView'])->name('tracki.task.files');


        // Route::post('updatetask', [TaskController::class, 'updateTask'])->name('tracki.task.update');
        Route::get('tracki/task/{id}/delete', [TaskController::class, 'deleteTask'])->name('tracki.task.delete');
        Route::get('tracki/task/{id}/list', [TaskController::class, 'taskDetails'])->name('tracki.task.list');
        Route::get('tracki/task/mv/edit/{id}', [TaskController::class, 'getTaskView'])->name('tracki.task.mv.edit');
        Route::post('tracki/task/store', [TaskController::class, 'taskStore'])->name('tracki.task.store');
        Route::get('tracki/task/overview/{id}', [TaskController::class, 'taskOverview'])->name('tracki.task.overview');
        Route::get('tracki/task/file/{id}/get', [TaskController::class, 'getTaskFiles'])->name('tracki.task.file.get');
        Route::get('tracki/task/note/{id}/get', [TaskController::class, 'getTaskNotes'])->name('tracki.task.note.get');
        Route::get('tracki/task/progress/{id}/edit', [TaskController::class, 'editTaskProgress'])->name('tracki.task.progress.edit');
        Route::post('updatetaskprogress', [TaskController::class, 'updateTaskProgress'])->name('tracki.task.progress.update');
        Route::get('tracki/task/status/{id}/edit', [TaskController::class, 'editTaskStatus'])->name('tracki.task.status.edit');
        Route::post('tracki/task/status/update', [TaskController::class, 'updateTaskStatus'])->name('tracki.task.status.update');
        Route::get('tracki/task/lt', [TaskController::class, 'ltTaskDetails'])->name('tracki.task.lt');
        Route::get('tracki/task/manage', [TaskController::class, 'index'])->name('tracki.task.manage');

        // Route::get('tracki/task/all', [TaskController::class, 'allTaskDetails'])->name('tracki.task.all');
        Route::get('tracki/task/empdtable/{id?}', [TaskController::class, 'allTaskDt'])->name('tracki.task.dtable');
        Route::get('tracki/task/est', [TaskController::class, 'endingSoonTaskDetails'])->name('tracki.task.est');
        Route::get('tracki/task/sst', [TaskController::class, 'startingSoonTaskDetails'])->name('tracki.task.sst');


        Route::get('/taskdetailpdf/{id}', [TaskController::class, 'taskDetailsPDF'])->name('tracki.task.pdf');
        // Route::get('/tracki/task/pdflist/', [EventController::class, 'taskOverviewSa'])->name('tracki.task.overview.sa');

        Route::get('/mds/task/pdflist', function () {
            return view('/mds/task/pdflist');
        })->name('mds.task.pdflist');


        // todo
        Route::get('tracki/todo/manage', [TodoController::class, 'index'])->name('tracki.todo.manage');
        Route::post('tracki/todo/store', [TodoController::class, 'store'])->name('tracki.todo.store');
        Route::get('/tracki/todo/{id}/delete', [TodoController::class, 'destroy'])->name('tracki.todo.delete');
        Route::put('tracki/todo/update_status', [TodoController::class, 'updateStatus'])->name('tracki.todo.update_status');


        //task file upload
        Route::post('tracki/task/file/store', [TaskController::class, 'taskFileStore'])->name('tracki.task.file.store');
        Route::delete('tracki/task/file/{id}/delete', [TaskController::class, 'taskFileDelete'])->name('tracki.task.file.delete');


        //add task note
        Route::post('tracki/task/note/store', [TaskController::class, 'taskNoteStore'])->name('tracki.task.note.store');
        Route::delete('tracki/task/note/{id}/delete', [TaskController::class, 'deleteTaskNote'])->name('tracki.task.note.delete');

        // Route::get('/tracki/event/{id}/edit', [EventController::class, 'editEvent'])->name('tracki.event.edit');

        //************************************ Subtask Methods *************************************************** */
        Route::post('tracki/task/subtask', [SubtaskController::class, 'store'])->name('tracki.task.subtask.store');
        Route::get('tracki/task/subtask/{id}/overview', [SubtaskController::class, 'overview'])->name('tracki.task.subtask.overview');
        Route::put('tracki/task/subtask/update_status', [SubtaskController::class, 'updateStatus'])->name('tracki.task.subtask.update_status');

        //************************************ Setup Methods *************************************************** */
        // Event Category
        Route::get('/tracki/setup/category-list', [SetupController::class, 'catEvent'])->name('tracki.setup.category');
        Route::post('updatecat', [SetupController::class, 'updateEventCategory'])->name('tracki.setup.category.update');
        Route::post('createcat', [SetupController::class, 'createEventCategory'])->name('tracki.setup.category.create');
        Route::get('/tracki/setup/category/{id}/edit', [SetupController::class, 'editCategory'])->name('tracki.setup.category.show.edit');
        Route::get('/tracki/setup/category/{id}/delete', [SetupController::class, 'deleteCategory'])->name('tracki.setup.category.delete');

        // Event Audience
        Route::get('/tracki/setup/audience-list', [SetupController::class, 'eventAudience'])->name('tracki.setup.audience');
        Route::post('updateaudience', [SetupController::class, 'updateAudience'])->name('tracki.setup.audience.update');
        Route::post('createaudience', [SetupController::class, 'createAudience'])->name('tracki.setup.audience.create');
        Route::get('/tracki/setup/audience/{id}/edit', [SetupController::class, 'editAudience'])->name('tracki.setup.audience.show.edit');
        Route::get('/tracki/setup/audience/{id}/delete', [SetupController::class, 'deleteAudience'])->name('tracki.setup.audience.delete');

        // Event Planner
        Route::get('/tracki/setup/planner-list', [SetupController::class, 'eventPlanner'])->name('tracki.setup.planner');
        Route::post('updateplanner', [SetupController::class, 'updatePlanner'])->name('tracki.setup.planner.update');
        Route::post('createplanner', [SetupController::class, 'createPlanner'])->name('tracki.setup.planner.create');
        Route::get('/tracki/setup/planner/{id}/edit', [SetupController::class, 'editPlanner'])->name('tracki.setup.planner.show.edit');
        Route::get('/tracki/setup/planner/{id}/delete', [SetupController::class, 'deletePlanner'])->name('tracki.setup.planner.delete');


        // Project Type
        Route::get('/tracki/setup/projecttype-list', [SetupController::class, 'projectType'])->name('tracki.setup.projecttype');
        Route::post('updateprojecttype', [SetupController::class, 'updateProjectType'])->name('tracki.setup.projecttype.update');
        Route::post('createprojecttype', [SetupController::class, 'createProjectType'])->name('tracki.setup.projecttype.create');
        Route::get('/tracki/setup/projecttype/{id}/edit', [SetupController::class, 'editProjectType'])->name('tracki.setup.projecttype.show.edit');
        Route::get('/tracki/setup/projecttype/{id}/delete', [SetupController::class, 'deleteProjectType'])->name('tracki.setup.projecttype.delete');

        // Event Status
        Route::get('/tracki/setup/eventstatus-list', [SetupController::class, 'eventStatus'])->name('tracki.setup.eventstatus');
        Route::post('updateeventstatus', [SetupController::class, 'updateEventStatus'])->name('tracki.setup.eventstatus.update');
        Route::post('createeventstatus', [SetupController::class, 'createEventStatus'])->name('tracki.setup.eventstatus.create');
        Route::get('/tracki/setup/eventstatus/{id}/edit', [SetupController::class, 'editEventStatus'])->name('tracki.setup.eventstatus.show.edit');
        Route::get('/tracki/setup/eventstatus/{id}/delete', [SetupController::class, 'deleteEventStatus'])->name('tracki.setup.eventstatus.delete');

        //Status
        Route::get('/tracki/setup/status/manage', [StatusController::class, 'index'])->name('tracki.setup.status.manage');
        Route::get('/tracki/setup/status/list', [StatusController::class, 'list'])->name('tracki.setup.status.list');
        Route::get('/tracki/setup/status/{id}/get', [StatusController::class, 'get'])->name('tracki.setup.status.get');
        Route::post('tracki/setup/status/update', [StatusController::class, 'update'])->name('tracki.setup.status.update');
        Route::delete('/tracki/setup/status/{id}/delete', [StatusController::class, 'delete'])->name('tracki.setup.status.delete');
        Route::post('/tracki/setup/status/store', [StatusController::class, 'store'])->name('tracki.setup.status.store');

        //Address Type
        Route::get('/tracki/setup/address_type', [AddressTypeController::class, 'index'])->name('tracki.setup.address_type');
        Route::get('/tracki/setup/address_type/list', [AddressTypeController::class, 'list'])->name('tracki.setup.address_type.list');
        Route::get('/tracki/setup/address_type/{id}/get', [AddressTypeController::class, 'get'])->name('tracki.setup.address_type.get');
        Route::post('tracki/setup/address_type/update', [AddressTypeController::class, 'update'])->name('tracki.setup.address_type.update');
        Route::delete('/tracki/setup/address_type/delete/{id}', [AddressTypeController::class, 'delete'])->name('tracki.setup.address_type.delete');
        Route::post('/tracki/setup/address_type/store', [AddressTypeController::class, 'store'])->name('tracki.setup.address_type.store');

        // Priority
        Route::get('/tracki/setup/priority/manage', [PriorityController::class, 'index'])->name('tracki.setup.priority.manage');
        Route::get('/tracki/setup/priority/list', [PriorityController::class, 'list'])->name('tracki.setup.priority.list');
        Route::get('/tracki/setup/priority/{id}/get', [PriorityController::class, 'get'])->name('tracki.setup.priority.get');
        Route::post('tracki/setup/priority/update', [PriorityController::class, 'update'])->name('tracki.setup.priority.update');
        Route::delete('/tracki/setup/priority/{id}/delete', [PriorityController::class, 'delete'])->name('tracki.setup.priority.delete');
        Route::post('/tracki/setup/priority/store', [PriorityController::class, 'store'])->name('tracki.setup.priority.store');

        // Tags
        Route::get('/tracki/setup/tags', [TagsController::class, 'index'])->name('tracki.setup.tags');
        Route::get('/tracki/setup/tags/list', [TagsController::class, 'list'])->name('tracki.setup.tags.list');
        Route::get('/tracki/setup/tags/{id}/get', [TagsController::class, 'get'])->name('tracki.setup.tags.get');
        Route::post('tracki/setup/tags/update', [TagsController::class, 'update'])->name('tracki.setup.tags.update');
        Route::delete('/tracki/setup/tags/{id}/delete', [TagsController::class, 'delete'])->name('tracki.setup.tags.delete');
        Route::post('/tracki/setup/tags/store', [TagsController::class, 'store'])->name('tracki.setup.tags.store');

        // Users
        Route::get('/tracki/users/{id}/details', [UserController::class, 'details'])->name('tracki.users.details');

        // Route::get('/tracki/users/create', [ClientController::class, 'create'])->name('tracki.users.create');
        // Route::post('/tracki/users/store', [UserController::class, 'store'])->name('tracki.users.store');
        // Route::post('/tracki/users/manage', [ClientController::class, 'index'])->name('tracki.users.manage');


        //clients
        Route::get('/tracki/clients/manage', [ClientController::class, 'index'])->name('tracki.client.manage');
        Route::get('/tracki/clients/create', [ClientController::class, 'create'])->name('tracki.client.create');
        Route::post('/tracki/clients/store', [ClientController::class, 'store'])->name('tracki.client.store');
        Route::get('tracki/clients/all', [ClientController::class, 'get'])->name('tracki.client.all');


        // Workspace
        Route::get('/tracki/setup/workspace', [WorkspaceController::class, 'index'])->name('tracki.setup.workspace');
        Route::get('/tracki/setup/workspace/list', [WorkspaceController::class, 'list'])->name('tracki.setup.workspace.list');
        Route::get('/tracki/setup/workspace/{id}/get', [WorkspaceController::class, 'get'])->name('tracki.setup.workspace.get');
        Route::post('tracki/setup/workspace/update', [WorkspaceController::class, 'update'])->name('tracki.setup.workspace.update');
        Route::get('/tracki/setup/workspace/{id}/delete', [WorkspaceController::class, 'delete'])->name('tracki.setup.workspace.delete');
        Route::post('/tracki/setup/workspace/store', [WorkspaceController::class, 'store'])->name('tracki.setup.workspace.store');
        Route::get('/tracki/setup/workspace/{id}/switch', [WorkspaceController::class, 'switch'])->name('tracki.setup.workspace.switch');

        // Functional Area
        // Route::get('/tracki/setup/fa-list', [SetupController::class, 'fa'])->name('tracki.setup.fa');
        // Route::post('updatefa', [SetupController::class, 'updateFA'])->name('tracki.setup.fa.update');
        // Route::post('createfa', [SetupController::class, 'createFA'])->name('tracki.setup.fa.create');
        // Route::get('/tracki/setup/fa/{id}/edit', [SetupController::class, 'editFA'])->name('tracki.setup.fa.show.edit');
        // Route::get('/tracki/setup/fa/{id}/delete', [SetupController::class, 'deleteFA'])->name('tracki.setup.fa.delete');
        // Route::get('/tracki/setup/fa-add', [SetupController::class, 'addFA'])->name('tracki.setup.fa.add');

        Route::get('/tracki/setup/usertype-list', [SetupController::class, 'UserType'])->name('tracki.setup.usertype');
        Route::post('updateusertype', [SetupController::class, 'updateUserType'])->name('tracki.setup.usertype.update');
        Route::post('createusertype', [SetupController::class, 'createUserType'])->name('tracki.setup.usertype.create');
        Route::get('/tracki/setup/usertype/{id}/edit', [SetupController::class, 'editUserType'])->name('tracki.setup.usertype.show.edit');
        Route::get('/tracki/setup/usertype/{id}/delete', [SetupController::class, 'deleteUserType'])->name('tracki.setup.usertype.delete');
        // Route::get('/tracki/setup/fa-add', [SetupController::class, 'addFA'])->name('tracki.setup.fa.add');


        // Operations Type
        Route::get('/tracki/setup/operation-list', [SetupController::class, 'operation'])->name('tracki.setup.operation');
        Route::post('updateoperation', [SetupController::class, 'updateOperation'])->name('tracki.setup.operation.update');
        Route::post('createoperation', [SetupController::class, 'createOperation'])->name('tracki.setup.operation.create');
        Route::get('/tracki/setup/operation/{id}/edit', [SetupController::class, 'editOperation'])->name('tracki.setup.operation.show.edit');
        Route::get('/tracki/setup/operation/{id}/delete', [SetupController::class, 'deleteOperation'])->name('tracki.setup.operation.delete');

        // Budget Names
        Route::get('/tracki/setup/budget-list', [SetupController::class, 'budget'])->name('tracki.setup.budget');
        Route::post('updatebudget', [SetupController::class, 'updateBudget'])->name('tracki.setup.budget.update');
        Route::post('createbudget', [SetupController::class, 'createBudget'])->name('tracki.setup.budget.create');
        Route::get('/tracki/setup/budget/{id}/edit', [SetupController::class, 'editBudget'])->name('tracki.setup.budget.show.edit');
        Route::get('/tracki/setup/budget/{id}/delete', [SetupController::class, 'deleteBudget'])->name('tracki.setup.budget.delete');

        // Segments Type
        Route::get('/tracki/setup/segment-list', [SetupController::class, 'segment'])->name('tracki.setup.segment');
        Route::post('updatesegment', [SetupController::class, 'updateSegment'])->name('tracki.setup.segment.update');
        Route::post('createsegment', [SetupController::class, 'createSegment'])->name('tracki.setup.segment.create');
        Route::get('/tracki/setup/segment/{id}/edit', [SetupController::class, 'editSegment'])->name('tracki.setup.segment.show.edit');
        Route::get('/tracki/setup/segment/{id}/delete', [SetupController::class, 'deleteSegment'])->name('tracki.setup.segment.delete');

        // Department
        Route::get('/tracki/setup/departments', [DepartmentController::class, 'index'])->name('tracki.setup.departments');
        Route::get('/tracki/setup/departments/list', [DepartmentController::class, 'list'])->name('tracki.setup.departments.list');
        Route::get('/tracki/setup/departments/{id}/get', [DepartmentController::class, 'get'])->name('tracki.setup.departments.get');
        Route::post('tracki/setup/departments/update', [DepartmentController::class, 'update'])->name('tracki.setup.departments.update');
        Route::delete('/tracki/setup/departments/{id}/delete', [DepartmentController::class, 'delete'])->name('tracki.setup.departments.delete');
        Route::post('/tracki/setup/departments/store', [DepartmentController::class, 'store'])->name('tracki.setup.departments.store');

        // Designation
        Route::get('/tracki/setup/designations', [DesignationController::class, 'index'])->name('tracki.setup.designations');
        Route::get('/tracki/setup/designations/list', [DesignationController::class, 'list'])->name('tracki.setup.designations.list');
        Route::get('/tracki/setup/designations/{id}/get', [DesignationController::class, 'get'])->name('tracki.setup.designations.get');
        Route::post('tracki/setup/designations/update', [DesignationController::class, 'update'])->name('tracki.setup.designations.update');
        Route::delete('/tracki/setup/designations/{id}/delete', [DesignationController::class, 'delete'])->name('tracki.setup.designations.delete');
        Route::post('/tracki/setup/designations/store', [DesignationController::class, 'store'])->name('tracki.setup.designations.store');


        // Location
        Route::get('/tracki/setup/locations', [LocationController::class, 'index'])->name('tracki.setup.locations');
        Route::get('/tracki/setup/locations/list', [LocationController::class, 'list'])->name('tracki.setup.locations.list');
        Route::get('/tracki/setup/locations/{id}/get', [LocationController::class, 'get'])->name('tracki.setup.locations.get');
        Route::post('tracki/setup/locations/update', [LocationController::class, 'update'])->name('tracki.setup.locations.update');
        Route::delete('/tracki/setup/locations/{id}/delete', [LocationController::class, 'delete'])->name('tracki.setup.locations.delete');
        Route::post('/tracki/setup/locations/store', [LocationController::class, 'store'])->name('tracki.setup.locations.store');

        // Functional Area
        Route::get('/mds/setting/funcareas', [FunctionalAreaController::class, 'index'])->name('mds.setting.funcareas');
        Route::get('/mds/setting/funcareas/list', [FunctionalAreaController::class, 'list'])->name('mds.setting.funcareas.list');
        Route::get('/mds/setting/funcareas/get/{id}', [FunctionalAreaController::class, 'get'])->name('mds.setting.funcareas.get');
        Route::post('mds/setting/funcareas/update', [FunctionalAreaController::class, 'update'])->name('mds.setting.funcareas.update');
        Route::delete('/mds/setting/funcareas/delete/{id}', [FunctionalAreaController::class, 'delete'])->name('mds.setting.funcareas.delete');
        Route::post('/mds/setting/funcareas/store', [FunctionalAreaController::class, 'store'])->name('mds.setting.funcareas.store');

        // Venue
        Route::get('/mds/setting/venue', [VenueController::class, 'index'])->name('mds.setting.venue');
        Route::get('/mds/setting/venue/list', [VenueController::class, 'list'])->name('mds.setting.venue.list');
        Route::get('/mds/setting/venue/get/{id}', [VenueController::class, 'get'])->name('mds.setting.venue.get');
        Route::post('mds/setting/venue/update', [VenueController::class, 'update'])->name('mds.setting.venue.update');
        Route::delete('/mds/setting/venue/delete/{id}', [VenueController::class, 'delete'])->name('mds.setting.venue.delete');
        Route::post('/mds/setting/venue/store', [VenueController::class, 'store'])->name('mds.setting.venue.store');

        // loading zone
        Route::get('/mds/setting/zone', [ZoneController::class, 'index'])->name('mds.setting.zone');
        Route::get('/mds/setting/zone/list', [ZoneController::class, 'list'])->name('mds.setting.zone.list');
        Route::get('/mds/setting/zone/get/{id}', [ZoneController::class, 'get'])->name('mds.setting.zone.get');
        Route::post('mds/setting/zone/update', [ZoneController::class, 'update'])->name('mds.setting.zone.update');
        Route::delete('/mds/setting/zone/delete/{id}', [ZoneController::class, 'delete'])->name('mds.setting.zone.delete');
        Route::post('/mds/setting/zone/store', [ZoneController::class, 'store'])->name('mds.setting.zone.store');

        // Vehicle Type
        Route::get('/mds/setting/vehicle_type', [VehicleTypeController::class, 'index'])->name('mds.setting.vehicle_type');
        Route::get('/mds/setting/vehicle_type/list', [VehicleTypeController::class, 'list'])->name('mds.setting.vehicle_type.list');
        Route::get('/mds/setting/vehicle_type/get/{id}', [VehicleTypeController::class, 'get'])->name('mds.setting.vehicle_type.get');
        Route::post('mds/setting/vehicle_type/update', [VehicleTypeController::class, 'update'])->name('mds.setting.vehicle_type.update');
        Route::delete('/mds/setting/vehicle_type/delete/{id}', [VehicleTypeController::class, 'delete'])->name('mds.setting.vehicle_type.delete');
        Route::post('/mds/setting/vehicle_type/store', [VehicleTypeController::class, 'store'])->name('mds.setting.vehicle_type.store');

        // Delivery Type
        Route::get('/mds/setting/delivery_type', [DeliveryTypeController::class, 'index'])->name('mds.setting.delivery_type');
        Route::get('/mds/setting/delivery_type/list', [DeliveryTypeController::class, 'list'])->name('mds.setting.delivery_type.list');
        Route::get('/mds/setting/delivery_type/get/{id}', [DeliveryTypeController::class, 'get'])->name('mds.setting.delivery_type.get');
        Route::post('mds/setting/delivery_type/update', [DeliveryTypeController::class, 'update'])->name('mds.setting.delivery_type.update');
        Route::delete('/mds/setting/delivery_type/delete/{id}', [DeliveryTypeController::class, 'delete'])->name('mds.setting.delivery_type.delete');
        Route::post('/mds/setting/delivery_type/store', [DeliveryTypeController::class, 'store'])->name('mds.setting.delivery_type.store');


        // Cargo Type
        Route::get('/mds/setting/cargo', [DeliveryCargoController::class, 'index'])->name('mds.setting.cargo');
        Route::get('/mds/setting/cargo/list', [DeliveryCargoController::class, 'list'])->name('mds.setting.cargo.list');
        Route::get('/mds/setting/cargo/get/{id}', [DeliveryCargoController::class, 'get'])->name('mds.setting.cargo.get');
        Route::post('mds/setting/cargo/update', [DeliveryCargoController::class, 'update'])->name('mds.setting.cargo.update');
        Route::delete('/mds/setting/cargo/delete/{id}', [DeliveryCargoController::class, 'delete'])->name('mds.setting.cargo.delete');
        Route::post('/mds/setting/cargo/store', [DeliveryCargoController::class, 'store'])->name('mds.setting.cargo.store');

        // schedules
        Route::get('/mds/setting/schedule', [ScheduleController::class, 'index'])->name('mds.setting.schedule');
        Route::get('/mds/setting/schedule/list', [ScheduleController::class, 'list'])->name('mds.setting.schedule.list');
        Route::get('/mds/setting/schedule/get/{id}', [ScheduleController::class, 'get'])->name('mds.setting.schedule.get');
        Route::post('mds/setting/schedule/update', [ScheduleController::class, 'update'])->name('mds.setting.schedule.update');
        Route::delete('/mds/setting/schedule/delete/{id}', [ScheduleController::class, 'delete'])->name('mds.setting.schedule.delete');
        Route::post('/mds/setting/schedule/store', [ScheduleController::class, 'store'])->name('mds.setting.schedule.store');

        // intervals
        Route::get('/mds/setting/interval', [IntervalController::class, 'index'])->name('mds.setting.interval');
        Route::get('/mds/setting/interval/list/{id?}', [IntervalController::class, 'list'])->name('mds.setting.interval.list');
        Route::get('/mds/setting/interval/manage/{id}', [IntervalController::class, 'manage'])->name('mds.setting.interval.manage');
        Route::get('/mds/setting/interval/get/{id}', [IntervalController::class, 'get'])->name('mds.setting.interval.get');
        Route::post('mds/setting/interval/update', [IntervalController::class, 'update'])->name('mds.setting.interval.update');
        Route::delete('/mds/setting/interval/delete/{id}', [IntervalController::class, 'delete'])->name('mds.setting.interval.delete');
        Route::post('/mds/setting/interval/store', [IntervalController::class, 'store'])->name('mds.setting.interval.store');

        // booking
        Route::get('/mds/booking', [BookingController::class, 'index'])->name('mds.booking');
        Route::get('/mds/booking/list', [BookingController::class, 'list'])->name('mds.booking.list');
        Route::get('/mds/booking/add', [BookingController::class, 'add'])->name('mds.booking.add');
        Route::get('/mds/booking/manage/{id}', [BookingController::class, 'manage'])->name('mds.booking.manage');
        Route::get('/mds/booking/get/{id}', [BookingController::class, 'get'])->name('mds.booking.get');
        Route::get('/mds/booking/get_times/{date}/{venue_id}', [BookingController::class, 'get_times'])->name('mds.booking.get_times');
        Route::post('mds/booking/update', [BookingController::class, 'update'])->name('mds.booking.update');
        Route::delete('/mds/booking/delete/{id}', [BookingController::class, 'delete'])->name('mds.booking.delete');
        Route::post('/mds/booking/store', [BookingController::class, 'store'])->name('mds.booking.store')->middleware('prevent-back-history');
        Route::get('/mds/booking/mv/detail/{id}', [BookingController::class, 'detail'])->name('tracki.task.mv.detail');


        Route::get('/mds/booking/confirmation', function () {
            return view('/mds/booking/confirmation');
        })->name('mds.booking.confirmation');

        Route::get('/mds/booking/pass/pdf/{id}', [BookingController::class, 'passPdf'])->name('mds.booking.pass.pdf');

        //Booking note
        Route::get('/mds/booking/mv/notes/{id}', [BookingController::class, 'getNotesView'])->name('mds.booking.mv.notes');
        Route::post('mds/booking/note/store', [BookingController::class, 'noteStore'])->name('mds.booking.note.store');
        Route::delete('mds/booking/note/delete/{id}', [BookingController::class, 'deleteNote'])->name('mds.booking.note.delete');

        //Booking file upload
        Route::post('mds/booking/file/store', [BookingController::class, 'fileStore'])->name('mds.booking.file.store');
        Route::delete('mds/booking/file/{id}/delete', [BookingController::class, 'fileDelete'])->name('mds.booking.file.delete');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // yajra datatabels
        Route::get('/mds/booking/test', [BookingController::class, 'test'])->name('mds.booking.test');

        // Drivers
        Route::get('/mds/setting/driver', [DeliveryDriverController::class, 'index'])->name('mds.setting.driver');
        Route::get('/mds/setting/driver/list', [DeliveryDriverController::class, 'list'])->name('mds.setting.driver.list');
        Route::get('/mds/setting/driver/get/{id}', [DeliveryDriverController::class, 'get'])->name('mds.setting.driver.get');
        Route::post('mds/setting/driver/update', [DeliveryDriverController::class, 'update'])->name('mds.setting.driver.update');
        Route::delete('/mds/setting/driver/delete/{id}',  [DeliveryDriverController::class, 'delete'])->name('mds.setting.driver.delete');
        Route::post('/mds/setting/driver/store', [DeliveryDriverController::class, 'store'])->name('mds.setting.driver.store');
        Route::post('mds/driver/status/update', [DeliveryDriverController::class, 'updateStatus'])->name('mds.driver.status.update');
        Route::get('mds/driver/status/edit/{id}', [DeliveryDriverController::class, 'editStatus'])->name('mds.driver.status.edit');

        // vehicles
        Route::get('/mds/setting/vehicle', [DeliveryVehicleController::class, 'index'])->name('mds.setting.vehicle');
        Route::get('/mds/setting/vehicle/list', [DeliveryVehicleController::class, 'list'])->name('mds.setting.vehicle.list');
        Route::get('/mds/setting/vehicle/get/{id}', [DeliveryVehicleController::class, 'get'])->name('mds.setting.vehicle.get');
        Route::post('mds/setting/vehicle/update', [DeliveryVehicleController::class, 'update'])->name('mds.setting.vehicle.update');
        Route::delete('/mds/setting/vehicle/delete/{id}', [DeliveryVehicleController::class, 'delete'])->name('mds.setting.vehicle.delete');
        Route::post('/mds/setting/vehicle/store', [DeliveryVehicleController::class, 'store'])->name('mds.setting.vehicle.store');
        Route::post('mds/vehicle/status/update', [DeliveryVehicleController::class, 'updateStatus'])->name('mds.vehicle.status.update');
        Route::get('mds/vehicle/status/edit/{id}', [DeliveryVehicleController::class, 'editStatus'])->name('mds.vehicle.status.edit');

        //Driver Status
        Route::get('/mds/setup/drvstatus/manage', [DriverStatusController::class, 'index'])->name('mds.setup.drvstatus.manage');
        Route::get('/mds/setup/drvstatus/list', [DriverStatusController::class, 'list'])->name('mds.setup.drvstatus.list');
        Route::get('/mds/setup/drvstatus/{id}/get', [DriverStatusController::class, 'get'])->name('mds.setup.drvstatus.get');
        Route::post('mds/setup/drvstatus/update', [DriverStatusController::class, 'update'])->name('mds.setup.drvstatus.update');
        Route::delete('/mds/setup/drvstatus/{id}/delete', [DriverStatusController::class, 'delete'])->name('mds.setup.drvstatus.delete');
        Route::post('/mds/setup/drvstatus/store', [DriverStatusController::class, 'store'])->name('mds.setup.drvstatus.store');

        //Booking Status
        Route::get('/mds/setting/status/booking', [BookingStatusController::class, 'index'])->name('mds.setting.status.booking');
        Route::get('/mds/setting/status/booking/list', [BookingStatusController::class, 'list'])->name('mds.setting.status.booking.list');
        Route::get('/mds/setting/status/booking/get/{id}', [BookingStatusController::class, 'get'])->name('mds.setting.status.booking.get');
        Route::post('mds/setting/status/booking/update', [BookingStatusController::class, 'update'])->name('mds.setting.status.booking.update');
        Route::delete('/mds/setting/status/booking/delete/{id}', [BookingStatusController::class, 'delete'])->name('mds.setting.status.booking.delete');
        Route::post('/mds/setting/status/booking/store', [BookingStatusController::class, 'store'])->name('mds.setting.status.booking.store');

        //Status
        Route::get('/mds/setup/status/manage', [StatusController::class, 'index'])->name('mds.setup.status.manage');
        Route::get('/mds/setup/status/list', [StatusController::class, 'list'])->name('mds.setup.status.list');
        Route::get('/mds/setup/status/{id}/get', [StatusController::class, 'get'])->name('mds.setup.status.get');
        Route::post('mds/setup/status/update', [StatusController::class, 'update'])->name('mds.setup.status.update');
        Route::delete('/mds/setup/status/{id}/delete', [StatusController::class, 'delete'])->name('mds.setup.status.delete');
        Route::post('/mds/setup/status/store', [StatusController::class, 'store'])->name('mds.setup.status.store');

        // Fund Category
        Route::get('/tracki/setup/fundcategory-list', [SetupController::class, 'fundCategory'])->name('tracki.setup.fundcategory');
        Route::post('updateFundCategory', [SetupController::class, 'updateFundCategory'])->name('tracki.setup.fundcategory.update');
        Route::post('createFundCategory', [SetupController::class, 'createFundCategory'])->name('tracki.setup.fundcategory.create');
        Route::get('/tracki/setup/fundcategory/{id}/edit', [SetupController::class, 'editFundCategory'])->name('tracki.setup.fundcategory.show.edit');
        Route::get('/tracki/setup/fundcategory/{id}/delete', [SetupController::class, 'deleteFundCategory'])->name('tracki.setup.fundcategory.delete');

        // Person
        Route::get('/tracki/setup/person-list', [SetupController::class, 'person'])->name('tracki.setup.person');
        Route::post('updateperson', [SetupController::class, 'updatePerson'])->name('tracki.setup.person.update');
        Route::post('createperson', [SetupController::class, 'createPerson'])->name('tracki.setup.person.create');
        Route::get('/tracki/setup/person/{id}/edit', [SetupController::class, 'editPerson'])->name('tracki.setup.person.show.edit');
        Route::get('/tracki/setup/person/{id}/delete', [SetupController::class, 'deletePerson'])->name('tracki.setup.person.delete');

        // color
        Route::get('/tracki/setup/color-list', [SetupController::class, 'color'])->name('tracki.setup.color');
        Route::post('updatecolor', [SetupController::class, 'updateColor'])->name('tracki.setup.color.update');
        Route::post('createcolor', [SetupController::class, 'createColor'])->name('tracki.setup.color.create');
        Route::get('/tracki/setup/color/{id}/edit', [SetupController::class, 'editColor'])->name('tracki.setup.color.show.edit');
        Route::get('/tracki/setup/color/{id}/delete', [SetupController::class, 'deleteColor'])->name('tracki.setup.color.delete');

        // attendance
        Route::get('/tracki/attendance/list', [AttendanceController::class, 'attendance'])->name('tracki.attendance.list')->middleware('permission:attendance.show');
        // Route::get('/tracki/attendance/listinf', [AttendanceController::class, 'attendanceInf'])->name('tracki.attendance.listinf');
        // Route::get('/tracki/attendance/listvip', [AttendanceController::class, 'attendanceVIP'])->name('tracki.attendance.listvip');
        // Route::get('/tracki/attendance/listvic', [AttendanceController::class, 'attendanceVIC'])->name('tracki.attendance.listvic');
        Route::post('updateattendance', [AttendanceController::class, 'updateAttendance'])->name('tracki.attendance.list.update')->middleware('permission:attendance.edit');
        Route::post('createattendance', [AttendanceController::class, 'createAttendance'])->name('tracki.attendance.list.create')->middleware('permission:attendance.create');
        Route::get('/tracki/attendance/list/{id}/edit', [AttendanceController::class, 'editAttendance'])->name('tracki.attendance.list.edit')->middleware('permission:attendance.edit');
        Route::get('/tracki/attendance/list/{id}/delete', [AttendanceController::class, 'deleteAttendance'])->name('tracki.attendance.list.delete')->middleware('permission:attendance.delete');

        Route::get('/tracki/attendance/import', [AttendanceController::class, 'ImportAttendance'])->name('tracki.attendance.import')->middleware('permission:attendance.import');
        Route::post('importattendancenow', [AttendanceController::class, 'ImportNowAttendance'])->name('tracki.attendance.import.now')->middleware('permission:attendance.import');

        // attendance assgignment
        Route::get('/tracki/attendance/assignment', [AttendanceController::class, 'attendanceAssignment'])->name('tracki.attendance.assignment')->middleware('permission:project.attendance.assign');
        Route::get('/tracki/attendance/{id}/eventassignment', [AttendanceController::class, 'eventAttendanceAssignment'])->name('tracki.event.attendance.assignment')->middleware('permission:project.attendance.assign');
        Route::post('attendanceassignment', [AttendanceController::class, 'assignAttendanceEvents'])->name('tracki.attendance.assignevents')->middleware('permission:project.attendance.assign');
        Route::get('/tracki/attendance/assignment/{id}/delete', [AttendanceController::class, 'deleteEventAssignment'])->name('tracki.attendance.assignment.delete')->middleware('permission:project.attendance.delete');

        // scanning
        Route::get('/tracki/attendance/scanme', function () {
            return view('/tracki/attendance/scanme');
        })->name('tracki.attendance.scanme');

        // scanning
        Route::get('/tracki/attendance/checkin', function () {
            return view('/tracki/attendance/checkin');
        })->name('tracki.attendance.checkin');

        Route::post('showattendanceresults', [AttendanceController::class, 'markAttendance'])->name('tracki.attendance.mark');
        Route::post('/tracki/attendance/info', [AttendanceController::class, 'attendanceInfo'])->name('tracki.attendance.info');


        // Charts
        Route::get('/charts/piechart', [ChartsController::class, 'pieChart'])->name('charts.pie');
        Route::get('/charts/piechart2', [ChartsController::class, 'pieChart'])->name('charts.pie2');
        Route::get('/charts/charts', [ChartsController::class, 'eventDash'])->name('charts.dashboard');
    });

    require __DIR__ . '/auth.php';

    // Admin Group Middleware
    // Route::middleware(['auth', 'role:admin', 'prevent-back-history'])->group(function () {
    //     Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    //     Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    //     Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    //     Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    // });  // End groupd admin middleware

    // Route::middleware(['auth', 'role:agent'])->group(function () {
    //     Route::get('/agent/dashboard', [AgentController::class, 'agentDashboard'])->name('agent.dashboard');
    // });  // End groupd agent middleware

    Route::middleware(['prevent-back-history'])->group(function () {

        Route::get('/tracki/auth/login', [AdminController::class, 'login'])->name('tracki.auth.login')->middleware('prevent-back-history');

        Route::get('/tracki/auth/forgot', [AdminController::class, 'forgotPassword'])->name('tracki.auth.forgot');
        Route::post('forget-password', [AdminController::class, 'submitForgetPasswordForm'])->name('forgot.password.post');
        Route::get('tracki/auth/reset/{token}', [AdminController::class, 'showResetPasswordForm'])->name('reset.password.get');
        Route::post('reset-password', [AdminController::class, 'submitResetPasswordForm'])->name('reset.password.post');


        Route::get('/send-mail', [SendMailController::class, 'index']);
        Route::get('/send-mail2', [SendMailController::class, 'sendTaskAssignmentEmail']);

        Route::get('/send', [SendMailController::class, 'sendTaskAssignmentNotifcation']);
        Route::get('/whatsapp', [CommunicationChannels::class, 'sendWhatsapp'])->name('whatsapp.send');
    });

    // Route::get('/run-migration', function () {
    //     Artisan::call('optimize:clear');

    //     Artisan::call('migrate:refresh --seed');
    //     return "Migration executed successfully";
    // });

    // Route::get('echarts', [EchartController::class,'echart']);


    // Route::get("/charts/piechart", "Controller@Piechart");

});

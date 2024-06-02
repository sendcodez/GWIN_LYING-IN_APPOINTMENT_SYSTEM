<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DocModuleController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\MyRecordsController;
use App\Http\Controllers\AcitivityLogController;
use App\Models\User;
use App\Models\Patient;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

*/
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', function () {
    return view('auth.login');
});



Route::get('login', [IndexController::class, 'login'])->name('login');

//AUTH
Route::post('/password/hash', 'PasswordController@hash')->name('password.hash');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'check.status'])
    ->name('admin.dashboard');



Route::middleware('auth')->group(function () {

    //USER ROUTE
  Route::get('/get-patient-details/{id}', [RecordController::class, 'getPatientDetails']);
    
  Route::get('/get-user-details/{id}', function($id) {
    $user = User::find($id);
    if ($user) {
        return response()->json([
            'firstname' => $user->firstname,
            'middlename' => $user->middlename,
            'lastname' => $user->lastname
        ]);
    } else {
        return response()->json([
            'error' => 'User not found'
        ], 404);
    }
});



    
    //HOME ROUTE
    Route::get('admin/home', [HomeController::class, 'index'])->name('admin.home');

    //CALENDAR ROUTE

    Route::get('/calendar', [CalendarController::class, 'showCalendar'])->name('admin.calendar');
    Route::post('/walkin-appointments/store', [CalendarController::class, 'store'])->name('calendar.store');


    //PATIENT ROUTE

    Route::get('admin/profiling/add_patient', [PatientController::class, 'create'])->name('patient.add');
    Route::get('admin/profiling/manage_patient', [PatientController::class, 'index'])->name('patient.index');
  
    Route::get('/admin/profiling/{userId}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('admin/profiling/edit_patient/{userId}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::post('admin/profiling/add_patient', [PatientController::class, 'store'])->name('patient.store');
    Route::put('/admin/profiling/edit_patient/{userId}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('admin/profiling/manage_patient/{patient}', [PatientController::class, 'destroy'])->name('patient.destroy');
    Route::get('patients/export', [PatientController::class, 'export'])->name('patients.export');



    //DOCTORS ROUTE
    Route::get('admin/create_doctor', [DoctorController::class, 'create'])->name('doctor.create');
    Route::get('admin/show_doctor{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::post('admin/create_doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::put('admin/create_doctor{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::patch('/update-doctor-status/{id}', [DoctorController::class, 'updateStatus'])->name('update-doctor-status');


    //APPOINTMENT/PATIENTS ROUTE
    Route::get('/show-appointments',  [AppointmentController::class, 'showCalendar'])->name('appointment.index');
    Route::get('/doctors/{serviceId}', [DoctorController::class, 'getDoctorsByService']);
    Route::get('/doctor-availability/{doctorId}', [DoctorController::class, 'getDoctorAvailability']);
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::put('/appointments/{id}/cancel',[DashboardController::class, 'cancel'])->name('appointments.cancel');
    Route::put('/appointments/{id}/approve',[DashboardController::class, 'approve'])->name('appointments.approve');
    Route::put('/appointments/{id}/complete',[DashboardController::class, 'complete'])->name('appointments.complete');
    Route::put('/appointments/{id}/disapprove',[DashboardController::class, 'disapprove'])->name('appointments.disapprove');
    Route::get('/appointments',  [AppointmentController::class, 'showAppointments'])->name('appointments.show');
    Route::get('/getAllAppointments', [AppointmentController::class, 'getAll']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::get('/pending-appointments',  [AppointmentController::class, 'pendingApp'])->name('appointments.pending');
    Route::get('/approved-appointments',  [AppointmentController::class, 'approvedApp'])->name('appointments.approved');
    Route::get('/completed-appointments',  [AppointmentController::class, 'completedApp'])->name('appointments.completed');
    Route::get('/cancelled-appointments',  [AppointmentController::class, 'cancelledApp'])->name('appointments.cancelled');
    Route::get('/disapproved-appointments',  [AppointmentController::class, 'disapprovedApp'])->name('appointments.disapproved');


    //WEBSITE ROUTE
    Route::get('admin/website', [WebsiteController::class, 'index'])->name('website.index');
    Route::post('admin/website/update', [WebsiteController::class, 'update'])->name('website.update');
  

    //DOCTORS MODULE ROUTE
    Route::get('/doctor/patient-list', [DocModuleController::class, 'index'])->name('mypatients.index');
    Route::get('/doctor/mypatient={userId}', [DocModuleController::class, 'show'])->name('mypatient.show');
    Route::post('/doctor/add-medication', [DocModuleController::class, 'store'])->name('medication.store');


    
    //SERVICES ROUTE
    Route::get('admin/services', [ServicesController::class, 'index'])->name('service.index');
    Route::post('admin/create_services', [ServicesController::class, 'store'])->name('service.store');
    Route::patch('/update-service-status/{id}', [ServicesController::class, 'updateStatus'])->name('update-service-status');
    Route::delete('/service/{id}', [ServicesController::class, 'destroy'])->name('service.destroy');


    //ACTIVITY LOG ROUTE
    Route::get('admin/activity', [AcitivityLogController::class, 'index'])->name('activity.show');


    //RECORDS ROUTE
    Route::get('admin/records', [RecordController::class, 'index'])->name('record.index');
    Route::post('/admin/add-records', [RecordController::class, 'storeRecords'])->name('record.store');
    Route::post('/admin/add-laboratories', [RecordController::class, 'storeLaboratory'])->name('laboratory.store');
    Route::post('/admin/add-ultrasounds', [RecordController::class, 'storeUltrasound'])->name('ultrasound.store');
    Route::post('/admin/add-delivery', [RecordController::class, 'storeDelivery'])->name('delivery.store');
    Route::post('/admin/add-newborn', [RecordController::class, 'storeNewborn'])->name('newborn.store');
    Route::post('/admin/add-postpartum', [RecordController::class, 'storePostpartum'])->name('postpartum.store');
    Route::post('/admin/add-labor', [RecordController::class, 'storeLabor'])->name('labor.store');
    Route::get('/patient/{id}', [RecordController::class, 'getPatientDetails']);

    //MYRECORDS ROUTE
    Route::get('/MyRecords', [MyRecordsController::class, 'index'])->name('myrecord.index');


    //USERS ROUTE
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
    Route::post('/create_user', [UserController::class, 'store'])->name('user.store');
    Route::patch('/update-user-status/{id}', [UserController::class, 'updateStatus'])->name('update-user-status');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/create-patient', [UserController::class, 'createpatientaccount'])->name('create-patient-account');


    //REPORTS ROUTE 
    Route::get('admin/reports', [ReportController::class, 'index'])->name('report.index');
    Route::post('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

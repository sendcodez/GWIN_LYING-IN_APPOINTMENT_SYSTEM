<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServicesController;
use App\Models\User;


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
    Route::get('admin/calendar', [CalendarController::class, 'index'])->name('calendar.index');



    //PATIENT ROUTE

    Route::get('admin/profiling/add_patient', [PatientController::class, 'create'])->name('patient.add');
    Route::get('admin/profiling/manage_patient', [PatientController::class, 'index'])->name('patient.index');
  
    Route::get('/admin/profiling/{userId}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('admin/profiling/edit_patient/{userId}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::post('admin/profiling/add_patient', [PatientController::class, 'store'])->name('patient.store');
    Route::put('/admin/profiling/edit_patient/{userId}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('admin/profiling/manage_patient/{patient}', [PatientController::class, 'destroy'])->name('patient.destroy');



    //DOCTORS ROUTE
    Route::get('admin/create_doctor', [DoctorController::class, 'create'])->name('doctor.create');
    Route::get('admin/show_doctor{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::post('admin/create_doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::put('admin/create_doctor{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::patch('/update-doctor-status/{id}', [DoctorController::class, 'updateStatus'])->name('update-doctor-status');


    
    //WEBSITE ROUTE
    Route::get('admin/website', [WebsiteController::class, 'index'])->name('website.index');
    Route::post('admin/website/update', [WebsiteController::class, 'update'])->name('website.update');
    

    //SERVICES ROUTE
    Route::get('admin/create_services', [ServicesController::class, 'index'])->name('service.index');
    Route::post('admin/create_services', [ServicesController::class, 'store'])->name('service.store');
    Route::patch('/update-service-status/{id}', [ServicesController::class, 'updateStatus'])->name('update-service-status');

    //USERS ROUTE
    Route::get('admin/create_user', [UserController::class, 'create'])->name('user.create');
    Route::post('admin/create_user', [UserController::class, 'store'])->name('user.store');
    Route::patch('/update-user-status/{id}', [UserController::class, 'updateStatus'])->name('update-user-status');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

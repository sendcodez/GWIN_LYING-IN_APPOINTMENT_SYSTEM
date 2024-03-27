<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

*/
Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('index', [IndexController::class, 'index'])->name('index');
Route::get('login', [IndexController::class, 'login'])->name('login');

//AUTH
Route::post('/password/hash', 'PasswordController@hash')->name('password.hash');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'check.status'])
    ->name('admin.dashboard');



Route::middleware('auth')->group(function () {

    //HOME ROUTE
    Route::get('admin/home', [HomeController::class, 'index'])->name('admin.home');

    //CALENDAR ROUTE
    Route::get('admin/calendar', [CalendarController::class, 'index'])->name('calendar.index');



    //PATIENT ROUTE
   
    Route::get('admin/profiling/manage_patient', [PatientController::class, 'index'])->name('patient.index');
    Route::get('admin/profiling/add_patient', [PatientController::class, 'create'])->name('patient.add');
    Route::post('admin/profiling/add_patient', [PatientController::class, 'store'])->name('patient.store');


    //DOCTORS ROUTE
    Route::get('admin/create_doctor', [DoctorController::class, 'index'])->name('doctor.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

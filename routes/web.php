<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\PatientInfo;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ImageUpload;
// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\LensController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin2Controller;
use App\Http\Controllers\CombinationController;
use App\Http\Controllers\VitalsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecieptController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\CheckAllowedIpRange;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\TwilioSmsController;
use App\Http\Controllers\PatientInfoController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\NewValidationController;
use App\Http\Controllers\WebrtcStreamingController;
use App\Http\Controllers\InvoicegenerationController;
use App\Http\Controllers\LensImportController;
use App\Http\Controllers\NewDoctorVerificationController;
use App\Http\Controllers\OpticianController;
use App\Http\Controllers\PatientCardController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeleMedController;
use App\Http\Controllers\GlobalSearchController;

Route::get('/Bookings', [NewValidationController::class, 'booking'])->name('NewBooking');

// After login everyone lands on the home screen for their role.
Route::get('/dashboard', function (Request $request) {
    return redirect()->route($request->user()->homeRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

// Neutral welcome page. The original clinic's marketing pages (landingpage, landing-page2) are kept but not routed.
Route::get('/', function () {
    return view('welcome-neutral');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/createpatient', [PagesController::class, 'index'])->name('pages.register');
    Route::post('/createpatient/store', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/createpatients/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::put('/createpatients/{record}/edit', [PagesController::class, 'update'])->name('pages.update');
    Route::get('/createpatient/status', function(){ return view('pages.status'); })->name('pages.status');
    // Deleting a patient is permanent, so only admins can do it.
    Route::delete('/createpatients/{record}/delete',[PagesController::class, 'destroy'])->middleware('admin')->name('pages.delete');

   
    Route::get('/doctors/index', [DoctorsController::class, 'testShow'])->name('doctors.index');

    Route::get('doctors/vitals', [DoctorsController::class, 'vitals'])->name('doctors.vitals');
    Route::post('/doctors/vitals/post', [DoctorsController::class, 'vitalSave'])->name('vitals.post');
    Route::get('doctors/treatment', [TreatmentController::class, 'index'])->name('doctors.treatment');
    Route::get('doctors/inventory', [InventoryController::class, 'index'])->name('doctors.inventory');
    Route::post('doctors/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/doctors/invoice', [InvoiceController::class, 'index'])->name('doctors.invoice');
    Route::get('/doctors/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');
    Route::get('/doctors/inventory/find', [InventoryController::class, 'find'])->name('inventory.find');
    Route::get('/doctors/reciept', [RecieptController::class,'index'])->name('doctors.reciept');


    Route::get('/invoice/find', [InvoiceController::class, 'find'])->name('invoice.find');
    Route::get('/invoice/search', [InvoiceController::class, 'search'])->name('invoice.search');
    Route::post('/doctors/treatment/store', [TreatmentController::class, 'store'])->name('treatment.store');
    Route::post('/doctors/vitals/store', [VitalsController::class, 'store'])->name('vitals.store');
    Route::get('/doctors/vitals/{vital}/edit', [VitalsController::class, 'edit'])->name('vitals.edit');
    Route::put('/doctors/vitals/{vital}', [VitalsController::class, 'update'])->name('vitals.update');
    Route::get('/doctors/vitals/{vital}/prescription', [VitalsController::class, 'prescription'])->name('vitals.prescription');
    Route::get('/search/treatment', [VitalsController:: class, 'show'])->name('search.treatment'); //Previous Optician Default Page
    Route::get('/search/treatment/get', [VitalsController::class, 'search'])->name('search.get');
    Route::get('/search/vitals', [VitalsController::class, 'display'])->name('search.vitals');
    Route::get('/search/vitals/get', [VitalsController::class, 'vitals'])->name('vitals.get');




    Route::get('/search/treatment', [VitalsController:: class, 'show'])->name('search.treatment');
    //admin
    // Route::get('/admin2', [AdminController::class, 'indexTwo'])->name('admin.admin2');

    Route::get('/records', [RecordsController::class, 'index'])->name('public.records');
    Route::get('/records/search', [RecordsController::class, 'search'])->name('records.search');

    // Universal search (top bar): patients by name, ID or phone, and screens by name.
    Route::get('/search', GlobalSearchController::class)->middleware('throttle:120,1')->name('search.global');

    //invoice
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoice', [InvoicegenerationController::class, 'index'])->name('invoice.show');
    Route::get('/invoice/generate', [InvoiceController::class, 'show'])->name('generate.show');
    Route::post('/doctors/invoice/save', [InvoiceController::class, 'save'])->name('invoice.save');


    // Case Files
    Route::get('/patients/image-upload', [ImageUpload::class, 'index'])->name('image.upload');
    Route::post('images/upload', [ImageUpload::class, 'store'])->name('images.store');

    //SMS
    Route::get('/smspage/{sms}', [SmsController::class, 'pass'])->name('sms.page');
    Route::get('/sms', [SmsController::class, 'index'])->name('doctor.sms');


    //Full Calender
    Route::get('full-calender', [FullCalenderController::class, 'index'])->name('calender');
    Route::post('full-calender/action', [FullCalenderController::class, 'action']);


    Route::get('/patients/image-upload', [ImageUpload::class, 'index'])->name('image.upload');
    Route::post('images/upload', [ImageUpload::class, 'store'])->name('images.store');


    Route::get('images', [ImageUpload::class, 'display'])->name('images.index');

    Route::get('images/search', [ImageUpload::class, 'search'])->name('images.search');
    Route::post('images/search', [ImageUpload::class, 'searchResult'])->name('images.search.result');

    //Messaging 
    Route::get('/send-sms/{sms}', [SendSMSController::class, 'loadPage'])->name('newSMS');
    Route::get('/send-sms', [SendSMSController:: class, 'sendSMS'])->name('sendSMS');
    Route::get('/sms-api', [SmsController::class, 'NaijaSMS'])->name('NaijaSMS');


    // Admin routes
    Route::get('/admin2', [AdminController::class, 'indexTwo'])->name('admin.admin2');
    Route::get('/admin/drug', [AdminController::class, 'drugsIndexTwo'])->name('admin2.drugs');
    Route::get('/admin/drug/list', [AdminController::class, 'drugList'])->name('admin2.druglist');
    Route::get('/admin/inventory/store', [AdminController::class, 'inventoryIndex'])->name('admin2.inventory');
    Route::get('/admin/frame', [AdminController::class, 'frameIndexTwo'])->name('admin2.frame');
    Route::get('/admin/framelist', [AdminController::class, 'framelist'])->name('admin2.framelist');
    Route::get('/admin2/lens', [AdminController::class, 'lensIndexTwo'])->name('admin2.lens');
    Route::get('/admin/lenslist', [AdminController::class, 'lenslist'])->name('admin2.lenslist');

    // Admin 1 routes
    Route::get('/admin1/index', [Admin2Controller::class, 'index'])->name('admin1.index');
    Route::post('admin1/password', [Admin2Controller::class, 'password'])->name('admin1.password');
    Route::post('admin1/check', [Admin2Controller::class, 'check'])->name('admin1.check');

    //Admin Dashboard
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
         //Admin Demographics
        Route::get('/admin/demographics', [AdminController::class, 'demographics'])->name('admin.demographics');
        //Admin Staff
        Route::get('/admin/staff', [AdminController::class, 'staff'])->name('admin.staff');
        Route::post('/admin/staff', [AdminController::class, 'storeStaff'])->name('admin.staff.store');
        //Inventory Analytics
        Route::get('/inventory/analytics', [AdminController::class, 'inventoryAnalytics'])->name('admin.inventory.analytics');
        Route::get('/inventoryTwo/analytics', [AdminController::class, 'inventoryTwoAnalytics'])->name('admin.inventoryTwo.analytics');
        //Invoice Analytics
        Route::get('/invoice/analytics', [AdminController::class, 'invoiceAnalytics'])->name('admin.invoice.analytics');
    });

    //Inventory API
    Route::get('/items', [CombinationController::class, 'getAllItems']);

     //Drug Routes
    Route::get('/doctors/drug', [DrugController::class, 'index'])->name('doctors.drugs');
    Route::post('/doctors/drug/store', [DrugController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/drug/list', [DrugController::class, 'list'])->name('doctors.list');
    Route::get('/doctors/{drugs}/edit', [DrugController::class, 'edit'])->name('drugs.edit');
    Route::put('/doctors/{drugs}/update', [DrugController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{drugs}/destroy', [DrugController::class, 'destroy'])->name('doctors.delete');
    Route::delete('/drugs/{drugs}/delete', [DrugController::class, 'destroy'])->name('drugs.delete');

    //Frames
    Route::get('/frames', [FrameController::class, 'index'])->name('frame');
    Route::post('/frame/store', [FrameController::class, 'store'])->name('frame.store');
    Route::get('/frame/list', [FrameController::class, 'list'])->name('frame.list');
    Route::get('/frames/{frames}/edit', [FrameController::class, 'edit'])->name('frame.edit');
    Route::put('/frames/{frames}/update', [FrameController::class, 'update'])->name('frame.update');
    Route::delete('/frames/{frames}/delete', [FrameController::class, 'delete'])->name('frame.delete');


    //Lens
    Route::get('/lens', [LensController::class, 'index'])->name('lens');
    Route::post('/lens/store', [LensController::class, 'store'])->name('lens.store');
    Route::get('/lens/list', [LensController::class, 'list'])->name('lens.list');
    Route::get('/lens/{len}/edit', [LensController::class, 'edit'])->name('lens.edit');
    Route::put('/lens/{lens}/update', [LensController::class, 'update'])->name('lens.update');
    Route::delete('/lens/{len}/delete', [LensController::class, 'delete'])->name('lens.delete');

    //status
    Route::get('/doctors/signup/status', function () { return view('doctors.status'); })->name('doctors.status');

     //Update Patient Info
    Route::put('/users/{id}', [PatientInfoController::class, 'update'])->name('users.update'); //Hold
    Route::get('/doctors/{drugs}/edit', [DrugController::class, 'updated'])->name('drugs.edit'); //Hold


    //Image Uplaod
    Route::get('/patients/image-upload', [ImageUpload::class, 'index'])->name('image.upload');
    Route::post('images/upload', [ImageUpload::class, 'store'])->name('images.store');
    Route::get('images', [ImageUpload::class, 'display'])->name('images.index');
    Route::get('images/search', [ImageUpload::class, 'search'])->name('images.search');
    Route::post('images/search', [ImageUpload::class, 'searchResult'])->name('images.search.result');
    Route::get('/import/users',  [ExcelController::class, 'index'])->name('excel.index');
   
    Route::get('/invoices-api', [InvoiceController::class, 'getAllInvoices']);

    //Optician Routes
    Route::get(	'/opticians/index', [OpticianController::class, 'index'])->name('optician.index'); //Protect this route with a middleware later
    Route::get('/optician/records', [OpticianController::class, 'records'])->name('optician.records');
    Route::post('/optician/store', [OpticianController::class, 'store'])->name('optician.store');
    Route::get('/optician/list', [OpticianController::class, 'list'])->name('optician.list');
    Route::get('/optician/find', [OpticianController::class, 'find'])->name('optician.find');
    Route::get('/optician/search', [OpticianController::class, 'search'])->name('optician.search'); //search


    //Services
    Route::get('/services', [ServicesController::class,'index'])->name('services.index');
    Route::post('/services/store', [ServicesController::class,'store'])->name('services.store');
    Route::get('/services/list', [ServicesController::class,'list'])->name('services.list');
    Route::put('/services/{drugs}/update', [ServicesController::class, 'update'])->name('services.update');
    Route::delete('/doctors/{drugs}/destroy', [ServicesController::class, 'destroy'])->name('services.delete');


    //Telemedicine Route

    Route::get('/telemed', [TeleMedController::class,'index'])->name('telemed.index');
    Route::get('/telemed/list', [TeleMedController::class,'list'])->name('telemed.list');
    Route::get('/telemed/chat', [TeleMedController::class, 'chat'])->name('telemed.chat');
    Route::get('telemed/join-room', [WebrtcStreamingController::class, 'join'])->name('telemed.join');
    Route::get('/telemed-test', [TeleMedController::class, 'test'])->name('telemed.test');//Test  Route


    //patient card
    Route::get('/patient-cards/{id}', [PatientCardController::class,'show'])->name('patient.show');
    Route::get('/patient-cards/{id}/edit', [PatientCardController::class,'edit'])->name('patient.edit');
    Route::put('/patient-cards/{id}', [PatientCardController::class,'update'])->name('patient.update');
    Route::put('/patient-cards/{id}/summary', [PatientCardController::class,'updateSummary'])->name('patient.summary.update');
    Route::get('/patient/pid/{pid}', [PatientCardController::class,'redirectByPid'])->name('patient.bypid')->where('pid', '.*');
    Route::post('/patients/{id}/check-in', [PatientCardController::class,'checkIn'])->name('patient.checkin');

    // Case-file images are served only to signed-in staff, never straight from the public folder.
    Route::get('/images/{image}/file', [ImageUpload::class, 'file'])->name('images.file');

    // Inventory ledger
    Route::get('/inventory/store', [InventoryController::class, 'list'])->name('inventory.list');
    Route::delete('/inventory/{item}/delete', [InventoryController::class, 'delete'])->name('inventory.delete');

    // Video/WebRTC
    Route::get('/client', function () { return view('video.index'); })->name('video');
    Route::get('/client/confo/{room}/{type}/{ref}',  [\App\Http\Controllers\EnxRtc\RoomController::class, 'confo']);

    // Testing/Admin Entry
    Route::get('/admin-entry', function (){ return view('doctors.testing');})->name('testing');

    // Payment
    Route::get('payment-index', [PaymentController::class, 'index'])->name('payment');

    // Bulk imports and test tools: admins only.
    Route::middleware('admin')->group(function () {
        Route::get('/lensesImport', [LensImportController::class, 'index'])->name('lenses.import.index');
        Route::post('/lenses/import', [LensImportController::class, 'import'])->name('lenses.import');

        Route::post('/import-users', function (Request $request) {
            $request->validate(['file' => 'required|file|mimes:xlsx,xls,csv']);
            Excel::import(new UsersImport, $request->file('file'));
            return 'Users Imported Successfully';
        })->name('excel.import');

        // SMS (Twilio)
        Route::get('/sendsms', [TwilioSmsController::class, 'test'])->name('sms');

        // New Validation/Signup
        Route::get('/signup', [NewValidationController::class, 'signup'])->name('NewSignUp');
        Route::get('/doctors/signup/imp', [NewDoctorVerificationController::class, 'index'])->name('doctorSignIn');
    });
}); //Closing Block

// Public appointment booking from the website. Throttled so the form can't be flooded.
Route::get('/booking', [MessagingController::class, 'index'])->name('booking');
Route::post('/booking/status', [MessagingController::class, 'store'])->middleware('throttle:10,1')->name('booking.store');

// Landing Page
Route::redirect('/landing-page', '/');


   

require __DIR__.'/auth.php';

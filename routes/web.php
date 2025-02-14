<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\notification\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TimingsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PaymentModuleController;
use App\Http\Controllers\DistributedStockController;
use App\Http\Controllers\FeeManagementController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StateCityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Panel\Settings\RoleController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Panel\Settings\PermissionController;
use App\Http\Controllers\EnquiryController;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::name("admin.")->prefix("admin")->group(function ($router) {

Route::get('/', [AuthController::class, 'index']);
Route::get('/erp', [AuthController::class, 'index'])->name('erp');
Route::post('/auth-login', [AuthController::class, 'auth_login'])->name('auth.login.post');

Route::get('reset', [ForgotPasswordController::class, 'directReset'])->name('password.direct-reset');
// Route to handle password reset submission
Route::post('password/update', [ForgotPasswordController::class, 'update'])->name('password.update');




Route::group(['middleware' => 'AuthLogin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('panel.dashboard');
    Route::get('/signout', [AuthController::class, 'logout'])->name('sign.out');
    Route::post('/update-location', [AuthController::class, 'update_location'])->name('update.user.location');

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'index'])->name('user.list');
        Route::get('add', [UserController::class, 'add'])->name('user.add');
        Route::post('add', [UserController::class, 'insert'])->name('user.insert');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('post/edit/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });


    Route::group(['prefix' => 'settings'], function () {

        //Super Admin Guest Controller
        Route::controller(PermissionController::class)->group(function () {
            Route::get('permission-group', 'index')->name('settings.permission.group');
            Route::get('permission', 'permission')->name('settings.permission');
            Route::post('group-insert', 'insert')->name('group.insert');
            Route::post('permission-insert', 'permissionInsert')->name('permission.insert');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('role', 'index')->name('settings.role.list');
            Route::get('role/add', 'add')->name('panel.add');
            Route::post('role/add', 'insert')->name('panel.insert');
            Route::get('role/edit/{id}', 'edit')->name('panel.edit');
            Route::post('role/post/edit/{id}', 'update')->name('panel.update');
            Route::get('role/delete/{id}', 'delete')->name('panel.delete');
        });
        Route::controller(LocationController::class)->group(function () {
            Route::get('location-list', 'location_list')->name('location.list');
            Route::post('add-location', 'add_location')->name('location.add');
            Route::get('edit-location/{id}', 'edit_location')->name('location.edit');
            Route::post('update-location', 'update_location')->name('location.update');
            Route::post('delete-location', 'destroy_location')->name('location.destroy');
        });


        Route::controller(EnquiryController::class)->group(function () {
            Route::get('enquiry-list', 'enquiry_list')->name('enquiry.list');
            Route::get('enquiry', 'enquiry_form')->name('enquiry.Form');
            Route::post('add-enquiry', 'add_enquiry')->name('enquiry.add');
            Route::get('edit-enquiry/{enquiry_Id}', 'edit_enquiry')->name('enquiry.edit');
            Route::post('update-enquiry', 'update_enquiry')->name('enquiry.update');
            Route::post('delete-enquiry', 'destroy_enquiry')->name('enquiry.destroy');
            Route::get('view-status/{id}', 'view_status')->name('enquiry.status');
            Route::post('enquiry/update-status', 'updateStatus')->name('enquiry.updateStatuss');
            Route::put('/enquiry/{id}/move-location', 'moveLocation')->name('enquiry.moveLocation');
        });

        // category-list
        Route::controller(CategoryController::class)->group(function () {
            Route::get('category-list', 'category_list')->name('category.list');
            Route::post('add-category', 'add_category')->name('category.add');
            Route::get('edit-category/{id}', 'edit_category')->name('category.edit');
            Route::post('update-category', 'update_category')->name('category.update');
            Route::post('delete-category', 'destroy_category')->name('category.destroy');
        });

        // Payment module-list
        Route::controller(PaymentModuleController::class)->group(function () {
            Route::get('payment-module', 'payment_module')->name('paymentmodule.list');
            Route::post('add-paymentmodule', 'add_paymentmodule')->name('paymentmodule.add');
            Route::get('edit-paymentmodule/{id}', 'edit_paymentmodule')->name('paymentmodule.edit');
            Route::post('update-paymentmodule', 'update_paymentmodule')->name('paymentmodule.update');
            Route::post('delete-paymentmodule', 'destroy_paymentmodule')->name('paymentmodule.destroy');
        });

        // Package
        Route::controller(PackageController::class)->group(function () {
            Route::get('package-list', 'package_list')->name('package.list');
            Route::post('add-package', 'add_package')->name('package.add');
            Route::get('edit-package/{id}', 'edit_package')->name('package.edit');
            Route::post('update-package', 'update_package')->name('package.update');
            Route::post('delete-package', 'destroy_package')->name('package.destroy');
        });

        // Add training-program
        Route::controller(TrainingProgramController::class)->group(function () {
            Route::get('training-program-list', 'training_list')->name('training.list');
            Route::post('add-training-program', 'add_TrainingProgram')->name('training.add');
            Route::get('edit-training-program/{id}', 'edit_TrainingProgram')->name('training.edit');
            Route::post('update-training-program', 'update_training_programs')->name('training.update');
            Route::post('delete-training-program', 'destroy_training_programs')->name('training.destroy');
        });

        // Add Session
        Route::controller(SessionController::class)->group(function () {
            Route::get('session-list', 'session_list')->name('session.list');
            Route::post('add-session', 'add_session')->name('session.add');
            Route::get('edit-session/{id}', 'edit_session')->name('session.edit');
            Route::post('update-session', 'update_session')->name('session.update');
            Route::post('delete-session', 'destroy_session')->name('session.destroy');
        });
        // Add timings
        Route::controller(TimingsController::class)->group(function () {
            Route::get('timings-list', 'timings_list')->name('timings.list');
            Route::post('add-timings', 'add_timings')->name('timings.add');
            Route::get('edit-timings/{id}', 'edit_timings')->name('timings.edit');
            Route::post('update-timings', 'update_timings')->name('timings.update');
            Route::post('delete-timings', 'destroy_timings')->name('timings.destroy');
        });
        // room-list
        Route::controller(RoomController::class)->group(function () {
            Route::get('room-list', 'room_list')->name('room.list');
            Route::post('add-room', 'add_room')->name('room.add');
            Route::get('edit-room/{id}', 'edit_room')->name('room.edit');
            Route::post('update-room', 'update_room')->name('room.update');
            Route::post('delete-room', 'destroy_room')->name('room.destroy');
        });

        // meal-list
        Route::controller(MealController::class)->group(function () {
            Route::get('meal-list', 'meal_list')->name('meal.list');
            Route::post('add-meal', 'add_meal')->name('meal.add');
            Route::get('edit-meal/{id}', 'edit_meal')->name('meal.edit');
            Route::post('update-meal', 'update_meal')->name('meal.update');
            Route::post('delete-meal', 'destroy_meal')->name('meal.destroy');
        });
        // leadsource
        Route::controller(LeadSourceController::class)->group(function () {
            Route::get('leadsource-list',  'leadsource_list')->name('leadsource.list');
            Route::post('add-leadsource',  'add_leadsource')->name('leadsource.add');
            Route::get('edit-leadsource/{id}',  'edit_leadsource')->name('leadsource.edit');
            Route::post('update-leadsource',  'update_leadsource')->name('leadsource.update');
            Route::post('delete-leadsource',  'destroy_leadsource')->name('leadsource.destroy');
        });

        // unit-list
        Route::controller(UnitController::class)->group(function () {
            Route::get('unit-list',  'unit_list')->name('unit.list');
            Route::post('add-unit',  'add_unit')->name('unit.add');
            Route::get('edit-unit/{id}',  'edit_unit')->name('unit.edit');
            Route::post('update-unit',  'update_unit')->name('unit.update');
            Route::post('delete-unit',  'destroy_unit')->name('unit.destroy');
        });

        // product-list
        Route::controller(ProductController::class)->group(function () {
            Route::get('product-list', 'product_list')->name('product.list');
            Route::post('add-product', 'add_product')->name('product.add');
            Route::get('edit-product/{id}', 'edit_product')->name('product.edit');
            Route::post('update-product', 'update_product')->name('product.update');
            Route::post('delete-product', 'destroy_product')->name('product.destroy');
        });

        // stock-list
        Route::controller(StockController::class)->group(function () {
            Route::get('stock-list',  'stock_list')->name('stock.list');
            Route::post('add-stock',  'add_stock')->name('stock.add');
            Route::get('edit-stock/{id}',  'edit_stock')->name('stock.edit');
            Route::post('update-stock',  'update_stock')->name('stock.update');
            Route::post('delete-stock',  'destroy_stock')->name('stock.destroy');
            Route::post('/get-products',  'get_products')->name('stock.get.product');
            Route::get('/get-products-by-category',  'getProductsByCategory')->name('stock.category');
        });

        //distributed stock-list
        Route::controller(DistributedStockController::class)->group(function () {
            Route::get('distributed-stock', 'distributed_list')->name('distributed.list');
            Route::post('add-distributed', 'add_distributed')->name('distributed.add');
            Route::get('edit-distributed/{id}', 'edit_distributed')->name('distributed.edit');
            Route::post('update-distributed', 'update_distributed')->name('distributed.update');
            Route::post('delete-distributed', 'destroy_distributed')->name('distributed.destroy');
        });



        // registration-list registration 
        Route::controller(RegistrationController::class)->group(function () {
            Route::get('registration-list', 'registration_list')->name('registration.list');
            Route::get('registration/{enquiryId?}', 'registration_form')->name('registration.form');
            Route::post('add-registration', 'add_registration')->name('registration.add');
            Route::get('registration-details/{id}', 'registration_details')->name('registration.details');
            Route::get('edit-registration/{registration_no}', 'edit_registration')->name('registration.edit');
            Route::post('update-registration', 'update_registration')->name('registration.update');
            Route::post('delete-registration', 'destroy_registration')->name('registration.destroy');
            Route::post('registration/update-status', 'registrationupdateStatus')->name('registration.updateStatus');
            // lead to register
            Route::get('/register/{enquiry}', 'prefill')->name('registration.prefill');
            Route::get('edit-userpackage/{registration_no}', 'edit_userpackage')->name('registration.editpackage');
            Route::post('updatependingPayment', 'updatePayment')->name('registration.updatePayment');
            Route::post('updateuserpackage', 'updateuser_package')->name('registration.updateuserpackage');
            // update status
            Route::post('updateuserstatus',  'updateuser_status')->name('registration.updateuserstatus');
        });


        Route::controller(StateCityController::class)->group(function () {
            Route::post('get-city', 'getCities')->name('get.city');
        });

        Route::controller(NotificationController::class)->group(function () {
            Route::get('notifications', 'notifications_list')->name('notifications.list');
            Route::get('markasred/{id}', 'markasrednotification')->name('notifications.markasread');
            Route::post('/mark-notification-read', 'markNotificationRead');
        });


        Route::controller(ReportController::class)->group(function () {
            Route::get('fee-report', 'fee_report')->name('report.feecollection');
        });
    });
});

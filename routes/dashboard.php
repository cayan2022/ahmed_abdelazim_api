<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    RolesController,
    CategoryController,
    ServiceController,
    OfferController,
    DoctorController,
    SourceController,
    BranchController,
    StatusController,
    SubStatusController,
    SettingController,
    TestimonialController,
    AboutController,
    ProfileController
};

Route::as('dashboard.')
    ->middleware('auth:sanctum')
    ->prefix('dashboard')
    ->group(function () {

        //profile

        Route::get('profile', [ProfileController::class, 'show'])->name('api.profile.show');
        Route::post('profile', [ProfileController::class, 'update'])->name('api.profile.update');
        Route::post('logout', [ProfileController::class, 'logout'])->name('logout');

        //Roles & Permissions Crud
        Route::as('roles.')
            ->prefix('roles')->group(function () {
            Route::get('get-roles', [RolesController::class, 'getRoles']);
            Route::get('get-permissions', [RolesController::class, 'getPermissions']);
            Route::get('get-role-permissions', [RolesController::class, 'getRolePermissions']);
            Route::post('add-permission', [RolesController::class, 'addPermission']);
            Route::post('add-role', [RolesController::class, 'addRole'])->name('role');
            Route::post('assignRoleToUser', [RolesController::class, 'assignRoleToUser']);
        });
        //pages
        Route::as('pages.')
        ->prefix('pages')->group(function () {
            Route::apiResources([
                'categories' => CategoryController::class,
                'services' => ServiceController::class,
                'offers' => OfferController::class,
                'doctors' => DoctorController::class,
                'sources' => SourceController::class,
                'branches' => BranchController::class,
                'statuses' => StatusController::class,
                'substatuses' => SubStatusController::class,
                'settings' => SettingController::class,
                'testimonials' => TestimonialController::class,
                'abouts' => AboutController::class
            ]);
        });
    });

<?php

   use App\Http\Controllers\AuthController;
   use App\Http\Controllers\CrudController;
   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Route;


   Route::post('/register', [AuthController::class, 'register']);
   Route::post('/login', [AuthController::class, 'login']);
   Route::get('/users', [CrudController::class, 'getAllUsers'])->name('users.show');
   Route::get('/users/{userId}', [CrudController::class, 'getUserById'])->name('users.showById');
   Route::delete('/users/{userId}', [CrudController::class, 'deleteUserById'])->name('users.deleteById');
   Route::put('/users/{userId}', [CrudController::class, 'updateUserById'])->name('users.updateById');

   Route::middleware('auth:api')->group(function () {
       Route::get('/user', function (Request $request) {
           return $request->user();
       });
   });
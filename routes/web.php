<?php

use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::resource('visits',VisitController::class);

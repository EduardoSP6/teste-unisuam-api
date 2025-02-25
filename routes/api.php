<?php

use App\Http\Controllers\GithubUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('github-users')
    ->group(function () {
       Route::get('/{username}', [GithubUserController::class, 'show'])
           ->name('githubUsers.show');
    });

<?php

use App\Http\Controllers\GithubFollowingUserController;
use App\Http\Controllers\GithubUserController;
use Illuminate\Support\Facades\Route;

Route::get('status', function () {
    return [
        'DATE' => date("y-m-d H:i:s"),
        'APP_NAME' => config('app.name'),
        'APP_ENV' => config('app.env'),
        'APP_URL' => config('app.url'),
    ];
});

Route::prefix('github-users')
    ->group(function () {
        Route::get('/{username}', [GithubUserController::class, 'show'])
            ->name('githubUsers.show');

        Route::get('/{username}/followings', [GithubFollowingUserController::class, 'index'])
            ->name('githubFollowingUsers.index');
    });


<?php
Route::get('/', function () {
    return redirect('users');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('users', 'UserController');
Route::get('/2fa','TwoFactorAuthController@show2faForm')->name('show2FaForm');
    Route::post('/generate2faSecret','TwoFactorAuthController@generate2faSecret')->name('generate2faSecret');
    Route::post('/2fa','TwoFactorAuthController@enable2fa')->name('enable2fa');
    Route::post('/disable2fa','TwoFactorAuthController@disable2fa')->name('disable2fa');
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify');

    // All routes for 2 factor authentication backups.
    Route::post('/generate2FaBackupCodes', 'TwoFactorAuthController@generate2FaBackupCodes')->name('generate2FaBackups');
    Route::post('/download2FaBackupCodes', 'TwoFactorAuthController@download2FaBackupCodes')->name('download2FaBackupCodes');

    // Routes for export & download users.
    Route::get('/export/users', 'ExportUserController@exportUsers')->name('usersExport');
    Route::get('/download/users', 'ExportUserController@showUsersDownload')->name('showUsersDownload');
    Route::get('/download/users-file', 'ExportUserController@downloadUsers')->name('usersDownload');

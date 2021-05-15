<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('sources')->name('sources/')->group(static function() {
            Route::get('/',                                             'SourcesController@index')->name('index');
            Route::get('/create',                                       'SourcesController@create')->name('create');
            Route::post('/',                                            'SourcesController@store')->name('store');
            Route::get('/{source}/edit',                                'SourcesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SourcesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{source}',                                    'SourcesController@update')->name('update');
            Route::delete('/{source}',                                  'SourcesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('players')->name('players/')->group(static function() {
            Route::get('/',                                             'PlayersController@index')->name('index');
            Route::get('/create',                                       'PlayersController@create')->name('create');
            Route::post('/',                                            'PlayersController@store')->name('store');
            Route::get('/{player}/edit',                                'PlayersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PlayersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{player}',                                    'PlayersController@update')->name('update');
            Route::delete('/{player}',                                  'PlayersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('positions')->name('positions/')->group(static function() {
            Route::get('/',                                             'PositionsController@index')->name('index');
            Route::get('/create',                                       'PositionsController@create')->name('create');
            Route::post('/',                                            'PositionsController@store')->name('store');
            Route::get('/{position}/edit',                              'PositionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PositionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{position}',                                  'PositionsController@update')->name('update');
            Route::delete('/{position}',                                'PositionsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('classifications')->name('classifications/')->group(static function() {
            Route::get('/',                                             'ClassificationsController@index')->name('index');
            Route::get('/create',                                       'ClassificationsController@create')->name('create');
            Route::post('/',                                            'ClassificationsController@store')->name('store');
            Route::get('/{classification}/edit',                        'ClassificationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ClassificationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{classification}',                            'ClassificationsController@update')->name('update');
            Route::delete('/{classification}',                          'ClassificationsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('ranking-instances')->name('ranking-instances/')->group(static function() {
            Route::get('/',                                             'RankingInstancesController@index')->name('index');
            Route::get('/create',                                       'RankingInstancesController@create')->name('create');
            Route::post('/',                                            'RankingInstancesController@store')->name('store');
            Route::get('/{rankingInstance}/edit',                       'RankingInstancesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RankingInstancesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{rankingInstance}',                           'RankingInstancesController@update')->name('update');
            Route::delete('/{rankingInstance}',                         'RankingInstancesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('hand-types')->name('hand-types/')->group(static function() {
            Route::get('/',                                             'HandTypesController@index')->name('index');
            Route::get('/create',                                       'HandTypesController@create')->name('create');
            Route::post('/',                                            'HandTypesController@store')->name('store');
            Route::get('/{handType}/edit',                              'HandTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HandTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{handType}',                                  'HandTypesController@update')->name('update');
            Route::delete('/{handType}',                                'HandTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('seasonal-players')->name('seasonal-players/')->group(static function() {
            Route::get('/',                                             'SeasonalPlayerController@index')->name('index');
            Route::get('/create',                                       'SeasonalPlayerController@create')->name('create');
            Route::post('/',                                            'SeasonalPlayerController@store')->name('store');
            Route::get('/{seasonalPlayer}/edit',                        'SeasonalPlayerController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SeasonalPlayerController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{seasonalPlayer}',                            'SeasonalPlayerController@update')->name('update');
            Route::delete('/{seasonalPlayer}',                          'SeasonalPlayerController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('rankings')->name('rankings/')->group(static function() {
            Route::get('/',                                             'RankingsController@index')->name('index');
            Route::get('/create',                                       'RankingsController@create')->name('create');
            Route::post('/',                                            'RankingsController@store')->name('store');
            Route::get('/{ranking}/edit',                               'RankingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RankingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{ranking}',                                   'RankingsController@update')->name('update');
            Route::delete('/{ranking}',                                 'RankingsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('seasonal-player-positions')->name('seasonal-player-positions/')->group(static function() {
            Route::get('/',                                             'SeasonalPlayerPositionsController@index')->name('index');
            Route::get('/create',                                       'SeasonalPlayerPositionsController@create')->name('create');
            Route::post('/',                                            'SeasonalPlayerPositionsController@store')->name('store');
            Route::get('/{seasonalPlayerPosition}/edit',                'SeasonalPlayerPositionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SeasonalPlayerPositionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{seasonalPlayerPosition}',                    'SeasonalPlayerPositionsController@update')->name('update');
            Route::delete('/{seasonalPlayerPosition}',                  'SeasonalPlayerPositionsController@destroy')->name('destroy');
        });
    });
});
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/redirect', function (Request $request) {
//    $request->session()->put('state', $state = Str::random(40));
//
//    $query = http_build_query([
//        'client_id' => '3',
//        'redirect_uri' => 'http://first-api.test/callback',
//        'response_type' => 'code',
//        'scope' => '',
//        'state' => $state,
//    ]);
//
//    return redirect('http://central-api.test/oauth/authorize?'.$query);
//});
//
//
//Route::get('/callback', function (Request $request) {
//    $state = $request->session()->pull('state');
//
//    throw_unless(
//        strlen($state) > 0 && $state === $request->state,
//        InvalidArgumentException::class
//    );
//
//    $response = Http::asForm()->post('http://central-api.test/oauth/token', [
//        'grant_type' => 'authorization_code',
//        'client_id' => '3',
//        'client_secret' => 'iDx5QParhowNmdM16KEXTcOfCv2RgvPe66MKjFtb',
//        'redirect_uri' => 'http://first-api.test/callback',
//        'code' => $request->code,
//    ]);
//
//    return $response->json();
//});

Route::get('oauth/redirect', [AuthenticatedSessionController::class, 'redirectToProvider']);
Route::get('oauth/callback', [AuthenticatedSessionController::class, 'handleProviderCallback']);


require __DIR__.'/auth.php';

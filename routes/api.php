 <?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\MusicaController;
use App\Http\Controllers\AlbumController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/playlists', [PlaylistController::class, 'index']);
Route::get('/musicas', [MusicaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('albums', AlbumController::class)->except(['index']);
    Route::post('/playlists', [PlaylistController::class, 'store']);
    Route::put('/playlists/{id}', [PlaylistController::class, 'update']);
    Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy']);
});

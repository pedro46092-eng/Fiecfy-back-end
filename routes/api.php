 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MusicaController;
use App\Http\Controllers\PlaylistController;

// ==========================================
// ROTAS PÚBLICAS (Abertas)
// ==========================================

// Autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Leitura do catálogo (Artistas, Álbuns e Músicas)
Route::get('/artistas', [ArtistaController::class, 'index']);
Route::get('/artistas/{id}', [ArtistaController::class, 'show']);

Route::get('/albuns', [AlbumController::class, 'index']);
Route::get('/albuns/{id}', [AlbumController::class, 'show']);

Route::get('/musicas', [MusicaController::class, 'index']);
Route::get('/musicas/{id}', [MusicaController::class, 'show']);

// ==========================================
// ROTAS PROTEGIDAS (Exigem Token Bearer)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    // Sessão do usuário
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD de Artistas (Escrita)
    Route::post('/artistas', [ArtistaController::class, 'store']);
    Route::put('/artistas/{id}', [ArtistaController::class, 'update']);
    Route::delete('/artistas/{id}', [ArtistaController::class, 'destroy']);

    // CRUD de Álbuns (Escrita)
    Route::post('/albuns', [AlbumController::class, 'store']);
    Route::put('/albuns/{id}', [AlbumController::class, 'update']);
    Route::delete('/albuns/{id}', [AlbumController::class, 'destroy']);

    // CRUD de Músicas (Escrita + Restauração Soft Delete)
    Route::post('/musicas', [MusicaController::class, 'store']);
    Route::put('/musicas/{id}', [MusicaController::class, 'update']);
    Route::delete('/musicas/{id}', [MusicaController::class, 'destroy']);
    Route::patch('/musicas/{id}/restaurar', [MusicaController::class, 'restore']);

    // CRUD Completo de Playlists (GET, POST, PUT/PATCH, DELETE)
    Route::apiResource('playlists', PlaylistController::class);
    Route::patch('/playlists/{id}/restaurar', [PlaylistController::class, 'restore']);

    // Relacionamento N:M (Adicionar e remover músicas da playlist)
    Route::post('/playlists/{id}/musicas', [PlaylistController::class, 'addSong']);
    Route::delete('/playlists/{id}/musicas/{songId}', [PlaylistController::class, 'removeSong']);
});
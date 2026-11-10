<?php

use Illuminate\Support\Facades\Route;
 

 
 use App\Http\Controllers\MusicaController; // Importação do MusicaController

// EXERCÍCIO 06: Rota para a listagem de músicas
Route::get('/musicas', [MusicaController::class, 'index']);
use App\Http\Controllers\AlbumController; // Importação do AlbumController

// EXERCÍCIO 03: Rota para listagem dos álbuns
Route::get('/albuns', [AlbumController::class, 'index']);

// EXERCÍCIO 05: Rota dinâmica para exibir um álbum por ID
Route::get('/albuns/{id}', [AlbumController::class, 'show']);
// Criando a CLASSE
class FaixaMusical 
{   
    public string $titulo; 
    public string $artista;
    public string $estilo;

    public function __construct(string $tituloDesejado, string $artistaDesejado, string $estiloDesejado = 'Não informado') {
        $this->titulo = $tituloDesejado;
        $this->artista = $artistaDesejado;
        $this->estilo = $estiloDesejado;
    }

    public function getDetalhes(): string {
        return $this->titulo . " - " . $this->artista;
    } 
}

// Criando a classe Artista
class Artista 
{
    public string $nome;
    public string $estilo;
    public int $ouvintesMensais;

    public function __construct(string $nome, string $estilo, int $ouvintesMensais = 0) {
        $this->nome = $nome;
        $this->estilo = $estilo;
        $this->ouvintesMensais = $ouvintesMensais;
    }

    public function isFamoso(): bool {
        return $this->ouvintesMensais > 1000000;
    }
}

// Rotas dos Desafios
Route::get('/', function () { return view('welcome'); });

Route::get('/ex1', function () { return "Desafio 01: Classe Artista criada com sucesso!"; });

Route::get('/ex2', function () {
    $artista = new Artista('Gusttavo Lima', 'Sertanejo');
    return "Artista Autorizado:" . $artista->nome;
});

Route::get('/ex3', function () { return response()->json(new Artista('Gusttavo Lima', 'Sertanejo')); });

Route::get('/ex4', function () {
    $a1 = new Artista('Gusttavo Lima', 'Sertanejo', 45000000);
    $a2 = new Artista('Banda Local GL', 'GL', 50000);
    return response()->json([
        'artista_1' => ['nome' => $a1->nome, 'famoso' => $a1->isFamoso()],
        'artista_2' => ['nome' => $a2->nome, 'famoso' => $a2->isFamoso()]
    ]);
});
 
Route::get('/ex5', function () {
    return response()->json([
        ['nome' => ' Funk Hits', 'criador' => 'Spotify', 'Peita do Coringão' => [' MC HARIEL', 'MEMPHIS DEPAY']],
        ['nome' => ' Gusttavo Lima', 'criador' => ' GUSTTAVO LIMA', 'Quando a chuva passar...' => ['']]
    ]);
});

Route::get('/ex6', function () {
    $processarOuvintes = function (int $ouvintes) { return "Total de ouvintes formatado: " . $ouvintes; };
    return $processarOuvintes(67);
});

Route::get('/teste', function () {
    $processarOuvintes = function (int $ouvintes) { return "Total de ouvintes formatado: " . $ouvintes ; };
    return $processarOuvintes(67);
});

Route::get('/minha-musica', function () { return (new FaixaMusical('Bohemian Rhapsody', 'Gusttavo Lima'))->getDetalhes(); });

Route::get('/artista', function () { return response()->json(new Artista('Gusttavo Lima', 'Sertanejo')); });
<x-mail::message>
# Olá, {{ $user->name }}! 🎵

Sua conta no **FiecFy** foi criada com sucesso! Agora você já pode explorar artistas, álbuns, ouvir músicas e montar suas próprias playlists.

<x-mail::button :url="config('app.url')">
Acessar Plataforma
</x-mail::button>

Bom som,<br>
Equipe {{ config('app.name') }}
</x-mail::message>


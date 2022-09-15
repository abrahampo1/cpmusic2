<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/header.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <title>IES Francisco Asorey</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <nav>
        <img src="img/logoasorey16.png" alt="">
        <div class="reproductor">
            <div class="flex">
                <p id="track_title"></p>
                <p id="track_artist"></p>
            </div>
            <div class="controls">
                <span id="track_volume" class="material-symbols-outlined">
                    volume_up
                </span>
                <input type="range" style="min-width: 100px" name="" min="0" max="100" id="volume_control">

                <span class="material-symbols-outlined">
                    skip_previous
                </span>
                <span id="play_arrow" class="material-symbols-outlined">
                    play_arrow
                </span>
                <span id="next_song" class="material-symbols-outlined">
                    skip_next
                </span>
            </div>
        </div>
    </nav>
    <div class="sidebar">
        <a href="/musica" class="app">Musica</a>
        <a href="/playlists" class="app">Playlists</a>
        <a href="/avisos" class="app">Avisos</a>
        <a href="/ajustespantalla" class="app">Pantalla</a>
    </div>
</body>

</html>

<script src="js/functions.js"></script>
<script src="js/youtube.js"></script>
<script src="js/reproductor.js"></script>

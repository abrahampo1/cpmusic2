<div class="app-holder">

    <button class="btn" onclick="write_modal('Nombre de la playlist').then(r=>crear_playlist(r))">Crear Playlist</button>
    <hr>
    <div class="cards" id="pl">
        <a class="playlist" href="playlist?p=1">
            <div class="playlist-icon"></div>
            <div class="playlist-title">AutoPlaylist</div>
        </a>
    </div>


</div>


<script>
    function load_playlists() {
        let list = variable('playlists', '[]')
        $('#pl').html('')
        let i = 1
        list.forEach((value, key) => {
            let rand_image = ''
            if (value['songs'].length > 0) {
                rand_image = value['songs'][Math.floor(Math.random() * value['songs'].length)]['image'];

            }
            $('#pl').append(`
            
            <a class="playlist" href="playlist?p=${key}">
            <div class="playlist-icon" style="background-image: url('${rand_image}')"></div>
            <div class="playlist-title">${value.name}</div>
        </a>
            
            `)
            i++;
        })

    }
    load_playlists()



    ipcRenderer.on('app', (s, data) => {
        setTimeout(() => {
            load_playlists()
        }, 100);
    })

    let play = true

    function toggle_video(btn) {
        if (play) {
            play = false;
            video('pause')
            btn.innerText = 'Reproducir'

        } else {
            btn.innerText = 'Pausar'
            play = true;
            video('play')
        }
    }
</script>
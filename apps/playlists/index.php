<div class="app-holder">
    <h1>Auto-Playlist</h1>
    <button class="btn" onclick="mostrar('videos')">Mostrar Videoclip</button>
    <br>
    <br>
    <div class="w100">
        <input type="text" onchange="search()" placeholder="Buscar..." id="url">

    </div>
    <div id="search_results">

    </div>
    <h1>Cola de canciones</h1>
    <div class="queue" id="playlist">

    </div>
</div>


<script>
    function search() {
        let url = document.getElementById('url').value;
        let load = notif('Buscando...');
        yt.search(url).then(r => {
            $(load).fadeOut();
            console.log(r);
            $('#search_results').html('')
            r.forEach(video => {
                $('#search_results').append(`
            
            <div class="queuevideo click" onclick="add_playlist('auto','${video.url}', '${video.title}')">
                <div class="w100" >${video.title}</div>
            </div>
            
            `)
            });
        })
    }

    function add_playlist(list, url, title) {
        $('#search_results').html('')

        let playlist = variable('playlists', '{}')
        if (
            playlist[list]
        ) {
            playlist[list]['songs'].push({
                url: url,
                title: title
            })
        } else {
            playlist[list] = {
                name: list,
                songs: []
            }
            playlist[list]['songs'].push({
                url: url,
                title: title
            })

        }
        localStorage.setItem('playlists', JSON.stringify(playlist))
        load_playlist('auto')
    }

    function send_video(url) {
        $('#search_results').html('')
        let load = notif('cargando...');
        obtener_url_video(url).then(r => {
            load.innerText = 'OK';
            setTimeout(() => {
                $(load).fadeOut();
            }, 1000);
            ipcRenderer.send('pantalla', {
                type: 'video',
                url: r
            })
        })
    }

    function load_playlist(name) {
        let list = variable('playlists', '{}')
        $('#playlist').html('')
        let i = 1

        if (!list[name]) {
            return;
        }

        if (!list[name]['songs']) {
            return;
        }
        list[name]['songs'].forEach(value => {
            $('#playlist').append(`
            
            <div class="queuevideo">
                <div class="w10">${i}</div>
                <div class="w70">${value.title}</div>
                <div class="w20"><button class="btn" onclick="delete_playlist_song('${name}',${i-1})">Eliminar</button></div>
            </div>
            
            `)
            i++;
        })

    }
    load_playlist('auto')



    ipcRenderer.on('app', (s, data) => {
        setTimeout(() => {
            load_playlist('auto')
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

    function delete_playlist_song(list, id) {
        let play = variable('playlists', '{}')

        play[list]['songs'].splice(id, 1)
        localStorage.setItem('playlists', JSON.stringify(play))
        load_playlist('auto')
    }
</script>
<div class="app-holder">
    <input type="text" id="playlist-name" class="h1" onchange="change_playlist('name', this.value)">
    <br>
    <button class="btn" id="play_btn">Reproducir</button>
    <button class="btn" id="random_play_btn">Reproducir Random</button>
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
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const playlist_id = urlParams.get('p')
    const current_playlist = variable('playlists')[playlist_id];

    $('#playlist-name').val(current_playlist.name)

    $('#play_btn').on('click', () => {
        play_playlist(playlist_id)
    })
    $('#random_play_btn').on('click', () => {
        play_playlist(playlist_id, true)
    })


    function change_playlist(col, value) {
        let p = variable('playlists');
        p[playlist_id][col] = value
        localStorage.setItem('playlists', JSON.stringify(p))
    }

    function search() {
        let url = document.getElementById('url').value;
        let load = notif(`<span class="material-symbols-outlined">
satellite_alt
</span>`);
        yt.search(url).then(r => {
            $(load).fadeOut();
            console.log(r);
            $('#search_results').html('')
            r.forEach(video => {
                console.log(video)
                video.title = video.title.replace(/[']/gi, '')
                $('#search_results').append(`
            
            <div class="queuevideo click" onclick="add_playlist('${video.url}', '${video.title}', '${video.snippet.thumbnails.default.url}')">
                <div class="w100" >${video.title}</div>
            </div>
            
            `)
            });
        })
    }

    function add_playlist(url, title, image) {
        $('#search_results').html('')

        let playlist = variable('playlists', '[]')
        if (
            playlist[playlist_id]
        ) {
            playlist[playlist_id]['songs'].push({
                url: url,
                title: title,
                image: image
            })
        } else {
            playlist[playlist_id] = {
                name: list,
                songs: []
            }
            playlist[playlist_id]['songs'].push({
                url: url,
                title: title
            })

        }
        localStorage.setItem('playlists', JSON.stringify(playlist))
        load_playlist()
    }



    function load_playlist() {
        let list = variable('playlists', '[]')
        $('#playlist').html('')
        let i = 1

        if (!list[playlist_id]) {
            return;
        }

        if (!list[playlist_id]['songs']) {
            return;
        }
        list[playlist_id]['songs'].forEach(value => {
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
    load_playlist()



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

    function delete_playlist_song(id) {
        let play = variable('playlists', '[]')

        play[playlist_id]['songs'].splice(id, 1)
        localStorage.setItem('playlists', JSON.stringify(play))
        load_playlist()
    }
</script>
<div class="app-holder">
    <button class="btn" onclick="mostrar('videos')">Mostrar Videoclip</button>
    <br>
    <br>
    <div class="w100">
        <input type="text" onchange="search()" placeholder="Buscar..." id="url">

    </div>
    <div id="search_results">

    </div>
    <h1>Cola de canciones</h1>
    <div class="queue" id="queue">

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
            
            <div class="queuevideo click" onclick="add_queue('${video.url}')">
                <div class="w100" >${video.title}</div>
            </div>
            
            `)
        });
    })
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

function load_queue() {
    let queue = localStorage.getItem('queue')
    if (!queue) {
        localStorage.setItem('queue', '[]')
        queue = [];
    } else {
        queue = JSON.parse(queue)
    }
    $('#queue').html('')
    let i = 1
    queue.forEach(video => {
        $('#queue').append(`
            
            <div class="queuevideo">
                <div class="w10">${i}</div>
                <div class="w70">${video.raw.title}</div>
                <div class="w20"><button class="btn" onclick="delete_queue(${i-1})">Eliminar</button></div>
            </div>
            
            `)
        i++;
    });

}
load_queue()



ipcRenderer.on('app', (s, data) => {
    setTimeout(() => {
        load_queue()
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

function delete_queue(id) {
    let queue = localStorage.getItem('queue')
    if (!queue) {
        localStorage.setItem('queue', '[]')
        queue = [];
    } else {
        queue = JSON.parse(queue)
    }
    queue.splice(id, 1)
    localStorage.setItem('queue', JSON.stringify(queue))
    load_queue()
}


function add_queue(url) {
    $('#search_results').html('')
    let load = notif('cargando...');
    obtener_url_video(url).then(r => {
        load.innerText = 'OK';
        setTimeout(() => {
            $(load).fadeOut();
        }, 1000);
        let queue = localStorage.getItem('queue')
        if (!queue) {
            localStorage.setItem('queue', '[]')
            queue = [];
        } else {
            queue = JSON.parse(queue)
        }

        queue.push(r)

        localStorage.setItem('queue', JSON.stringify(queue))

        load_queue()
        if (!variable('now')) {
            ipcRenderer.send('pantalla', {
                type: 'load_video'
            })
        }

    })
}
</script>
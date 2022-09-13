<div class="app-holder">
    <button class="btn" onclick="mostrar('videos')">Mostrar Videoclip</button>
    <br>
    <br>
    <div class="w100">
        <input type="text" placeholder="Pega el URL de YouTube" id="url">
        <div class="center">
            <button onclick="add_queue()">Añadir A La Cola</button>
        </div>
    </div>
    <h1>Reproduciendo Ahora</h1>
    <div class="queue" id="nowvideo">

    </div>
    <h1>Cola de canciones</h1>
    <div class="queue" id="queue">

    </div>
</div>


<script>
    function send_video() {
        let url = document.getElementById('url').value;
        let load = notif('cargando...');
        obtener_url_video(url).then(r => {
            load.innerText = 'OK';
            setTimeout(() => {
                load.remove()
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
        let now = localStorage.getItem('now')
        if (now == undefined) {
            localStorage.setItem('now', '{}')
            now = {};
        } else {
            now = JSON.parse(now)
        }
        $('#nowvideo').html('')

        $('#nowvideo').append(`
            
            <div class="queuevideo">
                <div class="w80">${now.raw.title}</div>
                <div class="w20"><button class="btn" onclick="toggle_video(this)">Pausar</button></div>
            </div>
            
            `)
    }
    load_queue()

    function video(accion) {
        ipcRenderer.send('pantalla', {
            type: 'control',
            action: accion
        })
    }

    ipcRenderer.on('app', (s, data) => {
        load_queue()
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

    function add_queue() {
        let url = document.getElementById('url').value;
        let load = notif('cargando...');
        obtener_url_video(url).then(r => {
            load.innerText = 'OK';
            setTimeout(() => {
                load.remove()
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

        })
    }
</script>
<div class="full">
    <div class="full center pant" id="avisos">
        <div id="avisos_data" style="width: 100%;">
            <div class="aviso">
                <div class="data">
                    <div class="w10">
                        <div class="icon ">
                            <div class="icon-data red">
                                !
                            </div>
                        </div>
                    </div>
                    <div class="w90">
                        <h1>Titulo de aviso</h1>
                        <h3>Subtitlo</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="video-info">
            <span class="material-symbols-outlined">
                music_note
            </span>
            <h3 class="video-title"></h3>
        </div>
    </div>
    <div class="full center pant" style="display: none;" id="videos">
        <video id="video" src=""></video>
        <div class="video-info">
            <h1 class="video-title"></h1>
            <h2 class="video-artist"></h2>
        </div>
    </div>
    <img src="img/logoasorey16.png" alt="" class="mosquito">
    <div class="hora">
        16:00
    </div>
</div>



<script>
let current_status
ipcRenderer.on('pantalla', (sender, data) => {
    set(data)
})

function cargar_avisos() {
    if (avisos = variable('avisos')) {
        let i = 0;
        $('#avisos_data').html('')
        avisos.forEach(aviso => {

            $('#avisos_data').append(`
            
            <div class="aviso">
            <div class="data">
                <div class="w10">
                    <div class="icon ">
                        <div class="icon-data">
                            <span class="material-symbols-outlined">
                            ${aviso.icono}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="w90">
                    <h1>${aviso.titulo}</h1>
                    <h3>${aviso.subtitulo}</h3>
                </div>
            </div>
        </div>

            
            `)
            i++;
        });

    } else {
        localStorage.setItem('avisos', '[]');
    }
}
cargar_avisos()
function load_video() {
    let queue = localStorage.getItem('queue')
    if (queue == undefined || queue == null) {
        localStorage.setItem('queue', '[]')
        queue = [];
    } else {
        queue = JSON.parse(queue)
    }
    let now = localStorage.getItem('now')
    if (!now) {
        localStorage.setItem('now', '{}')
        now = '{}'
    }

    if (now == '{}') {
        if (queue[0]) {
            now = queue[0];
            localStorage.setItem('now', JSON.stringify(now))
            queue.splice(0, 1)
            localStorage.setItem('queue', JSON.stringify(queue))
        } else {
            now = {}
        }
    } else {
        now = JSON.parse(now)

    }
    console.log(queue)
    console.log(now)
    if (now['url']) {
        set({
            type: 'video',
            url: now
        })
        ipcRenderer.send('app', {
            type: 'load_queue',
        })
        ipcRenderer.send('app', {
            type: 'status',
            data: current_status,
            playing: $('#video').get(0).paused,
            muted: $('#video').prop('muted')
        })
    } else {
        $('#video').attr('src', '')
        ipcRenderer.send('app', {
            type: 'clearstatus'
        })
        $('.video-title').html('No hay música en el hilo')
        $('.video-artist').html('')
        set({type: 'pantalla', pantalla: 'avisos'})
    }
}




load_video()
document.getElementById('video').onended = () => {
    localStorage.setItem('now', '{}')
    load_video()
}
$('#video').prop('volume', 0.5)

function set(data) {
    console.log(data)
    switch (data['type']) {
        case 'cargar_avisos':
            cargar_avisos()
            break;
        case 'load_video':
            load_video()
            break;
        case 'pantalla':
            $('.pant').fadeOut();
            $('#' + data['pantalla']).fadeIn();
            break;
        case 'control':
            switch (data['action']) {
                case 'next':
                    let cola = variable('queue');
                    if (cola.length <= 0) {
                        return false;
                    }
                    localStorage.setItem('now', '{}')
                    load_video();
                    break;
                case 'mute':
                    $('#video').prop('muted', data['value'])
                    break;
                case 'volume':
                    $('#video').prop('volume', data['value'] / 100)
                    break;
                case 'pause':
                    document.getElementById('video').pause()
                    break;
                case 'play':
                    document.getElementById('video').play()
                    break;
                default:
                    break;
            }
            break;
        case 'video':
            current_status = data;
            $('.video-title').text(data['url']['raw']['title'])
            $('.video-artist').text(data['url']['raw']['uploader'])
            document.getElementById('video').src = data['url']['url']
            document.getElementById('video').play()

            if (data['ts']) {
                document.getElementById('video').currentTime = data['ts']
            }
            break;
        case 'getstatus':
            if (current_status) {
                current_status['ts'] = document.getElementById('video').currentTime

            }


            ipcRenderer.send('app', {
                type: 'status',
                data: current_status,
                playing: $('#video').get(0).paused,
                muted: $('#video').prop('muted')
            })

            if (variable('now') == {}) {
                ipcRenderer.send('app', {
                    type: 'clearstatus'
                })
            }
            default:
                break;

    }

}

setInterval(() => {
    let currenttime = new Date()
    $('.hora').html(currenttime.getHours() + ':' + ('0' + currenttime.getMinutes()).substr(-
        2))
}, 100);

const server = false


</script>
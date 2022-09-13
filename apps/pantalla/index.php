<div class="full">
    <div class="full center pant" id="avisos">
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

    function load_video() {
        let queue = localStorage.getItem('queue')
        if (!queue) {
            localStorage.setItem('queue', '[]')
            queue = [];
        } else {
            queue = JSON.parse(queue)
        }
        let now = localStorage.getItem('now')
        if (!now || now == '{}') {
            localStorage.setItem('now', '{}')
            if (queue[0]) {
                now = queue[0];
            } else {
                now = {}
            }
        } else {
            now = JSON.parse(now)
        }
        if (now['url']) {
            set({
                type: 'video',
                url: now
            })
            localStorage.setItem('now', JSON.stringify(now))
            queue.splice(0, 1)
            localStorage.setItem('queue', JSON.stringify(queue))
        }
    }


    load_video()
    document.getElementById('video').onended = ()=>{
        localStorage.setItem('now', '{}')
        load_video()
    }

    function set(data) {
        switch (data['type']) {
            case 'pantalla':
                $('.pant').fadeOut();
                $('#' + data['pantalla']).fadeIn();
                break;
            case 'control':
                switch (data['action']) {
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
            case 'getcurrent':
                if (current_status) {
                    current_status['ts'] = document.getElementById('video').currentTime

                }
                ipcRenderer.send('app', {
                    type: 'current_status',
                    data: current_status
                })
            default:
                break;

        }

    }

    setInterval(() => {
        let currenttime = new Date()
        $('.hora').html(('0' + currenttime.getHours()).substr(-2) + ':' + ('0' + currenttime.getMinutes()).substr(-2))
    }, 100);
</script>
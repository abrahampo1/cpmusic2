<div class="full">
    pantalla
    <div class="full center">
        <video id="video" src=""></video>
        <div class="video-info">
            <h1 id="video-title"></h1>
            <h2 id="video-artist"></h2>
        </div>
    </div>
    <img src="img/logoasorey16.png" alt="" class="mosquito">
</div>



<script>
    let current_status
    ipcRenderer.on('pantalla', (sender, data) => {
        set(data)
    })


    function set(data) {
        switch (data['type']) {
            case 'video':
                current_status = data;
                document.getElementById('video-title').innerHTML = data['url']['raw']['title']
                document.getElementById('video-artist').innerHTML = data['url']['raw']['uploader']
                document.getElementById('video').src = data['url']['url']
                document.getElementById('video').play()

                if(data['ts']){
                    document.getElementById('video').currentTime = data['ts']
                }
                break;
            case 'getcurrent':
                current_status['ts'] = document.getElementById('video').currentTime
                ipcRenderer.send('app', {
                    type: 'current_status',
                    data: current_status
                })
            default:
                break;

        }

    }
</script>
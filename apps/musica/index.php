<div class="app-holder">
    <div class="w100">
        <input type="text" placeholder="Pega el URL de YouTube" id="url">
        <div class="center">
            <button onclick="send_video()">Añadir A La Cola</button>
        </div>
    </div>
    <h1>Cola de canciones</h1>
</div>


<script>
    function send_video(){
        let url = document.getElementById('url').value;
        let load = notif('cargando...');
        obtener_url_video(url).then(r=>{
            load.innerText = 'OK';
            setTimeout(() => {
                load.remove()
            }, 1000);
            ipcRenderer.send('pantalla', {type: 'video', url: r})
        })
    }
</script>
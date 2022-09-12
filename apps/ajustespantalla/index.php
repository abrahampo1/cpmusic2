<div class="app-holder">
    <h1>Pantalla</h1>
    <div style="width: 100%; height: auto; position: relative">
    <div id="current" style="transform: scale(0.5) translate(-50%, -50%); position:absolute;top: 0px;left: 10px; height: 560px; width: 1080px" >
    </div>
        
    </div>
</div>


<script>
    let iframe = document.getElementById('current')
    console.log('enviando peticion')
    ipcRenderer.on('app', (r, data)=>{
        console.log('peticion recibida', data)
        $('#current').load('/pantalla', '', ()=>{
            switch (data['type']) {
            case 'current_status':
                set(data['data'])
                $('#video').prop('volume', 0)
                break;
        
            default:
                break;
        }
        })
        
    })
    ipcRenderer.send('pantalla', {type: 'getcurrent'})

    

</script>
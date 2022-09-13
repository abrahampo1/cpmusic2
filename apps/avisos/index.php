<div class="app-holder">
    <div class="w100 form">
        <div class="flex">
            <select name="" id="aviso_icono" style="width: 100px;">
                <option value="info">❔</option>
                <option value="calendar_month">📆</option>
                <option value="star">⭐</option>
            </select>
            <input type="text" id="aviso_titulo" placeholder="Titulo Aviso">
            <input type="text" id="aviso_subtitulo" placeholder="Subtitulo Aviso">
        </div>
        <button onclick="crear_aviso()">Crear Aviso</button>
    </div>
    <h1 style="text-align: center;">Avisos Actuales</h1>
    <div class="w100" id="avisos_actuales"></div>
</div>


<script>
function cargar_avisos() {
    if (avisos = variable('avisos')) {
        let i = 0;
        ipcRenderer.send('pantalla', {
            type: 'cargar_avisos'
        })
        $('#avisos_actuales').html('')

        avisos.forEach(aviso => {

            $('#avisos_actuales').append(`
            
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
                <div class="w80">
                    <h1>${aviso.titulo}</h1>
                    <h3>${aviso.subtitulo}</h3>
                </div>
                <div class="w10"><button class="btn" onclick="eliminar_aviso(${i})">Eliminar Aviso</button></div>
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

function crear_aviso() {
    let avisos = variable('avisos');
    avisos.push({
        titulo: $('#aviso_titulo').val(),
        subtitulo: $('#aviso_subtitulo').val(),
        icono: $('#aviso_icono').val()
    })
    localStorage.setItem('avisos', JSON.stringify(avisos));
    cargar_avisos()
    mostrar('avisos')
}

function eliminar_aviso(id) {
    let avisos = variable('avisos');
    avisos.splice(id, 1);
    localStorage.setItem('avisos', JSON.stringify(avisos));
    cargar_avisos()
}
</script>
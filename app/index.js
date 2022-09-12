const {app, BrowserWindow, ipcMain} = require('electron');


let MainWindow
let Reproductor

function createWindow(){
    MainWindow = new BrowserWindow({
        width: 800,
        height: 600,
        webPreferences:{
            nodeIntegration: true,
            contextIsolation: false
        }
    })
    MainWindow.loadURL('http://192.168.5.30')
    Reproductor = new BrowserWindow({
        width: 1920,
        height: 1080,
        title: 'PANTALLA',
        webPreferences:{
            nodeIntegration: true,
            contextIsolation: false
        }
    })
    Reproductor.loadURL('http://192.168.5.30/pantalla')
}



app.whenReady().then(()=>{
    createWindow()
})

ipcMain.on('pantalla', (sender, data)=>{
    Reproductor.webContents.send('pantalla', data)
})

ipcMain.on('app', (sender, data)=>{
    MainWindow.webContents.send('app', data)
})
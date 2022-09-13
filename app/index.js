const {app, BrowserWindow, ipcMain} = require('electron');

const url = 'http://musica.localhost'

let MainWindow
let Reproductor

function createWindow(){
    Reproductor = new BrowserWindow({
        width: 1920,
        height: 1080,
        title: 'PANTALLA',
        autoHideMenuBar: true,
        webPreferences:{
            nodeIntegration: true,
            contextIsolation: false
        }
    })
    Reproductor.loadURL(url+ '/pantalla')
    MainWindow = new BrowserWindow({
        width: 800,
        height: 600,
        autoHideMenuBar: true,
        webPreferences:{
            nodeIntegration: true,
            contextIsolation: false
        }
    })
    MainWindow.loadURL(url)
    
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
const { app, BrowserWindow, ipcMain } = require("electron");
require("dotenv").config();

// const url = 'https://music.ro-am.eu'
const url = "http://musica.localhost";

let MainWindow;
let Reproductor;

function createWindow() {
  Reproductor = new BrowserWindow({
    width: 1920,
    height: 1080,
    title: "PANTALLA",
    autoHideMenuBar: true,
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false,
    },
  });
  Reproductor.loadURL(url + "/pantalla");
  MainWindow = new BrowserWindow({
    width: 800,
    height: 600,
    autoHideMenuBar: true,
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false,
    },
  });
  MainWindow.loadURL(url);
}

app.whenReady().then(() => {
  createWindow();
});

ipcMain.on("pantalla", (sender, data) => {
  Reproductor.webContents.send("pantalla", data);
});

ipcMain.on("app", (sender, data) => {
  MainWindow.webContents.send("app", data);
});

const { REST, Routes, Client, GatewayIntentBits } = require("discord.js");
const {
  joinVoiceChannel,
  createAudioResource,
  createAudioPlayer,
  StreamType,
} = require("@discordjs/voice");
const ytdl = require("ytdl-core");

const client = new Client({
  intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildVoiceStates],
});

const commands = [
  {
    name: "queue",
    description: "cancion a la cola!",
    options: [
      {
        name: "url",
        description: "Enlace de YT de un video a reproducir",
        type: 3,
        required: true,
      },
    ],
  },
  {
    name: "join",
    description: "escucha la musica de las pantallas en tu llamada",
    options: [
      {
        name: "canal",
        description: "Establece el canal para oir la musica",
        type: 7,
        required: true,
      },
    ],
  },
];

const rest = new REST({ version: "10" }).setToken(process.env.DISCORD_SECRET);

(async () => {
  try {
    console.log("Started refreshing application (/) commands.");

    await rest.put(Routes.applicationCommands(process.env.DISCORD_CLIENT_ID), {
      body: commands,
    });

    console.log("Successfully reloaded application (/) commands.");
  } catch (error) {
    console.error(error);
  }
})();

client.on("ready", () => {
  console.log(`Logged in as ${client.user.tag}!`);
  client.user.setPresence({
    activities: [{ name: `Chilling en el SPA`, type: 0 }],
    status: "Pinchando temardos 👍",
  });
});
var connection;

client.on("interactionCreate", async (interaction) => {
  if (!interaction.isChatInputCommand()) return;
  if (interaction.commandName === "queue") {
    Reproductor.webContents.send(
      "add_queue",
      interaction.options.getString("url")
    );
    await interaction.reply(
      "Se ha añadido a la cola. " + interaction.options.getString("url")
    );
  }
  //
  //   ESTA PARTE NO COMPILA EN ELECTRON BUILDER :(
  //
  //   if (interaction.commandName === "join") {
  //     let channel = interaction.options.getChannel("canal");
  //     connection = joinVoiceChannel({
  //       channelId: channel.id,
  //       guildId: channel.guild.id,
  //       adapterCreator: channel.guild.voiceAdapterCreator,
  //     });
  //     await interaction.reply("Me uní. 👍");
  //     setTimeout(() => {
  //       Reproductor.webContents.send(
  //         "discord_joined",
  //         interaction.options.getString("url")
  //       );
  //     }, 1000);
  //   }
});

client.login(process.env.DISCORD_SECRET);
const player = createAudioPlayer();

//
//  ESTA PARTE NO COMPILA EN ELECTRON BUILDER :(
//
// ipcMain.on("discord_url", async (sender, data) => {
//   console.log(data);
//   var stream = ytdl(data, {
//    filter: "audioonly",
//    highWaterMark: 1 << 25,
//   });
//   const resource = createAudioResource(stream, { inputType: StreamType.Arbitrary });

//   if (connection) {
//     connection.subscribe(player);
//     player.play(resource);
//     console.log("BOT PLAYING");
//   }
// });

ipcMain.on("discord_pause", async (sender, data) => {
  player.pause();
  console.log("Player Paused");
});

ipcMain.on("discord_resume", async (sender, data) => {
  player.unpause();
  console.log("Player Resumed");
});

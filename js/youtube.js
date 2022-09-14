const { resolve } = require("path");
const { create: createYoutubeDl } = require("youtube-dl-exec");
const appRootDir = require("app-root-dir").get();
let fullurl =
  appRootDir +
  "/../app.asar.unpacked/node_modules/youtube-dl-exec/bin/youtube-dl.exe";
const youtubedl = createYoutubeDl(fullurl);

const { ipcRenderer } = require("electron");

window.$ = window.jQuery = require("jquery");

function obtener_url_video(url) {
  return new Promise((resolve, reject) => {
    youtubedl(url, {
      dumpSingleJson: true,
      noCheckCertificates: true,
      noWarnings: true,
      preferFreeFormats: true,
      format: "best",
      addHeader: ["referer:youtube.com", "user-agent:googlebot"],
    }).then((output) =>
      resolve({ url: output["requested_downloads"][0]["url"], raw: output })
    );
  });
}

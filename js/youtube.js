const { resolve } = require("path");
const youtubedl = require("youtube-dl-exec");
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

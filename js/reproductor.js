ipcRenderer.on("app", (s, data) => {
  console.log(data);
  if (data.type == "status") {
    $("#track_title").text(data.data.url.raw.title);
    $("#track_artist").text(data.data.url.raw.uploader);
    if (!data.playing) {
      $("#play_arrow").html("pause");
    } else {
      $("#play_arrow").html("play_arrow");
    }
    if (!data.muted) {
      $("#track_volume").html("volume_up");
    } else {
      $("#track_volume").html("volume_off");
    }
  }
  if (data.type == "clearstatus") {
    $("#track_title").text("");
    $("#track_artist").text("Hecho por @Abrahampo1");
  }
});

ipcRenderer.send("pantalla", {
  type: "getstatus",
});

function video(accion, value = "") {
  ipcRenderer.send("pantalla", {
    type: "control",
    action: accion,
    value: value,
  });
}

$("#play_arrow").on("click", () => {
  if ($("#play_arrow").html() == "pause") {
    $("#play_arrow").html("play_arrow");
    video("pause");
    ipcRenderer.send("discord_pause", true);
  } else {
    $("#play_arrow").html("pause");
    video("play");
    ipcRenderer.send("discord_resume", true);
  }
});

$("#track_volume").on("click", () => {
  if ($("#track_volume").html() == "volume_up") {
    $("#track_volume").html("volume_off");
    video("mute", true);
  } else {
    $("#track_volume").html("volume_up");
    video("mute", false);
  }
});

$("#volume_control").on("input", () => {
  video("volume", $("#volume_control").val());
});

$("#next_song").on("click", () => {
  video("next");
});

function add_queue(url) {
  $("#search_results").html("");
  let load = notif(`
  <span class="material-symbols-outlined">
satellite_alt
</span>
  `);
  obtener_url_video(url).then((r) => {
    load.innerHTML = `
    <span class="material-symbols-outlined">
check_circle
</span>
    `;
    setTimeout(() => {
      $(load).fadeOut();
    }, 1000);
    let queue = localStorage.getItem("queue");
    if (!queue) {
      localStorage.setItem("queue", "[]");
      queue = [];
    } else {
      queue = JSON.parse(queue);
    }

    queue.push(r);

    localStorage.setItem("queue", JSON.stringify(queue));

    load_queue();
    if (!variable("now")) {
      ipcRenderer.send("pantalla", {
        type: "load_video",
      });
    }
  });
}

function play_playlist(id, random = false) {
  ipcRenderer.send("pantalla", {
    type: "play_playlist",
    playlist: id,
    random: random,
  });
}

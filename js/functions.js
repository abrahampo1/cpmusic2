function notif(text) {
  let div = document.createElement("div");
  div.classList.add("center-modal");
  div.style.display = "none";
  div.innerText = text;

  document.body.appendChild(div);
  $(div).fadeIn();
  return div;
}

function mostrar(pantalla) {
  ipcRenderer.send("pantalla", {
    type: "pantalla",
    pantalla: pantalla,
  });
}

function variable(variable) {
  let va = localStorage.getItem(variable);
  if (va && va != "{}") {
    return JSON.parse(va);
  } else {
    return false;
  }
}

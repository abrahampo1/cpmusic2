function notif(text) {
  let div = document.createElement("div");
  div.classList.add("center-modal");
  div.style.display = "none";
  div.innerHTML = text;

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

function variable(variable, def) {
  let va = localStorage.getItem(variable);
  if (va && va != "{}") {
    return JSON.parse(va);
  } else {
    if (def) {
      localStorage.setItem(variable, def);
      return JSON.parse(def);
    } else {
      return false;
    }
  }
}


function write_modal(title){
  let modal = document.createElement('div');
  modal.classList.add('modal');
  let modal_content = document.createElement('div');
  modal_content.classList.add('content');
  modal.appendChild(modal_content);
  let title = document.createElement('h2');
  title.innerHTML = title;
  modal_content.appendChild(title);
  let input = document.createElement('input');
  input.classList.add('modalinput')
  document.body.appendChild(modal);
}
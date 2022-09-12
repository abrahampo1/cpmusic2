function notif(text){
    let div = document.createElement('div')
    div.classList.add('center-modal')
    div.innerText = text

    document.body.appendChild(div)
    return div;
}

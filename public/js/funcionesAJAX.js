var input = document.getElementById('buscador');
input.addEventListener('keyup', realizarPeticion);

function realizarPeticion() {
    if(input.value!=''){
        var ruta = Routing.generate('busqueda', true);
        var xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', gestionarRespuesta);
        xhr.open('POST',ruta);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('datos=', input.value);
    }
}

function gestionarRespuesta(event) {
    if(event.target.readyState == 4 && event.target.status == 200){
        var respuestaJ = event.target.responseText;
        var respuesta = JSON.parse(respuestaJ);

        console.log(respuesta);
    }
}
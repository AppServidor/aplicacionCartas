
// Buscador Usuarios (Backend)
$("#buscador").keyup(function (){
    var ruta = Routing.generate('busqueda');
    var value =$(this).val();

    if (value.length >=1){
        $.ajax({
       type:'POST',
       url: ruta,
       data: {
        value: value
    },
       async: true,
       datatype:"json",
       success: function (data){
     
        console.log(data);
       }})}});
        /*
        $(".muestraDatos").html(' ')
      $("#hide").children().hide();
          for(i = 0; i < data['user'].length; i++) {  
           
            fecha = data['user'][i]['Fecha']['date'];
            formato=   formatear(fecha);
            id=data['user'][i]['Id']
            $(".muestraDatos").append('<tr><td>'+id+'</td><td>'+data['user'][i]['Nombre']+'</td><td>'+data['user'][i]['Apellido']+'</td><td>'+formato+'</td><td>'+data['user'][i]['Telefono']+'</td><td>'+data['user'][i]['Foto']+'</td><td> <a href="/user/'+id+'">Mostrar</a></td><td> <a href="/user/'+id+'/edit">Editar</a></td></tr>')
     
        }
       }
  })
    } if (value.length<1){
        $("#hide").children().show();
        $(".muestraDatos").children().hide();
        

    }
});
*/
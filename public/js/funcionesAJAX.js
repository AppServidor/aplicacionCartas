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
     
        $(".muestraDatos").html(' ')
      $("#hide").children().hide();
          for(i = 0; i < data['cartas'].length; i++) {  
           
            id=data['cartas'][i]['id']
            $(".muestraDatos").append('<tr><td>'+id+'</td><td>'+data['cartas'][i]['nombre']+'</td><td>'+data['cartas'][i]['ataque']+'</td><td>'+data['cartas'][i]['defensa']+'</td><td>'+data['cartas'][i]['descripcion']+'</td><td>'+data['cartas'][i]['foto']+'</td><td> <a href="/cartas/'+id+'">Mostrar</a></td><td> <a href="/cartas/'+id+'/edit">Editar</a></td></tr>')
     
        }
       }
  })
    } if (value.length<1){
        $("#hide").children().show();
        $(".muestraDatos").children().hide();
        
    }
});



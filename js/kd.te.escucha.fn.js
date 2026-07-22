
$(document).ready(function(){
    
    
  cargarAreas();

function cargarAreas(){

    $.ajax({
        url: 'https://kluane.itdospuntocero.net/KDE/DATABASE/cargar_areas.php',
        type: 'POST',
        success: function(response){
        
            $('#content_Areas').empty();

          var json = JSON.parse(response);
          console.log(response);
          if(!json.err){

            var contador=1;


                        
                        $.each(json, function(i,item){

                              

                                    if(i!="err"){
                                     
                                      
                                      
                                    

                                      areas =`
                                        
                                              <div class="col-lg-3 col-sm-2  ">
                                        
                                                          <div class="form-check">
                                                              <input id="areas" class="form-check-input" type="radio" name="exampleRadios"  value="`+item.PK_area+`">
                                                              <label class="form-check-label" for="">
                                                              `+item.area_a+`
                                                              </label>
                                                          </div>
        
                                               </div>                                     
                                        `;


                                        $('#content_Areas').append(areas);
                                        



                                    }else{

                                        codigo =` `;
                                        
                                    }
                        
                    
                    
                    
                        })

               

          }else{

                    Swal.fire({
                        icon: 'info',
                        title: json.mensaje,
                        text:  'Sistema en fase de pruebas'
                        ,footer: '<a href>Ver manual</a>'

                        })

          }
        }
        
        });




}


$("#check1").change(function() {
  if (this.checked) {

    $('#section_personal').empty();  


    codigo =`

    <label  class="text-center col-12 p-4 bg-info mb-2 rounded text-dark"><h3> <strong> <i class="fas fa-info-circle"></i> Si desea ocultar su identidad, no es obligatorio diligenciar esta opcion</strong> </h3></label>

              
                            <div class="row">
                            


                            <div class="  col-lg-6 col-sm-12   mt-2 mb-2  border p-3">
                          
                        
                            <div class="row">
                               
                                 <div class="col-lg-2 col-sm-2">
                                    <label for="" class="text-bold"><h4>Nombres:</h4></label>
                                 </div>
                                 <div class="inp col-lg-10 col-sm-10">
                                    <input type="text" placeholder="Nombres y apellidos" id="nom" class=" text-lg form-control p-3 border-0 border-3 border-bottom border-info">
                                 </div>
                               
                            </div>
                          
                          
                           </div>

                             
                           <div class="col-lg-6 col-sm-12   mt-2 mb-2  border p-3">
                          
                        
                           <div class="row">
                              
                                <div class="col-lg-2 col-sm-2">
                                   <label for="" class="text-bold"><h4>Cargo:</h4></label>
                                </div>
                                <div class="col-lg-10 col-sm-10">
                                <input type="text" placeholder="Cargo" id="cargo" class=" text-lg form-control p-3 border-0 border-3 border-bottom border-info">
                                </div>
                              
                           </div>
                         
                         
                       </div>
                       <div class="col-lg-6 col-sm-12   mt-2 mb-2  border p-3">
                          
                        
                       <div class="row">
                          
                            <div class="col-lg-2 col-sm-2">
                               <label for="" class="text-bold"><h4>Area:</h4></label>
                            </div>
                            <div class="col-lg-10 col-sm-10">
                            <input type="text" placeholder="Area" id="area" class=" text-lg form-control p-3 border-0 border-3 border-bottom border-info">
                            </div>
                          
                       </div>
                     
                     
                   </div>

                   <div class="col-lg-6 col-sm-12   mt-2 mb-2  border p-3">
                          
                        
                          <div class="row">
                             
                               <div class="col-lg-2 col-sm-2">
                                  <label for="" class="text-bold"><h4>Teléfono:</h4></label>
                               </div>
                               <div class="col-lg-10 col-sm-10">
                               <input type="number" placeholder="Teléfono" id="telf" class=" text-lg form-control p-3 border-0 border-3 border-bottom border-info">
                               </div>
                             
                          </div>
                        
                        
                      </div>
                    
                    
                  </div>



             `;

             $('#section_personal').append(codigo); 

    
            }else{
    
    
    
    
             

    
            

    
    
          }
  
  
  });

  
$("#check2").change(function() {

  $('#check1').empty(); 


  if (this.checked) {

    $('#section_personal').empty();  


    codigo =`


              
    <label  class="text-center col-12 p-4 bg-warning mb-2 rounded text-dark"><h3> <strong> <i class="fas fa-info-circle"></i> La queja o sugerencia será anínima</strong> </h3></label>




             `;

             $('#section_personal').append(codigo); 

    
            }else{
    
    
    
    
             
             
    
            

    
    
          }
  
  
  });


 


function limp(){


  document.getElementById("sugerencia").value = "";
  document.getElementById("queja").value = "";
  
  elm=document.getElementsByName("exampleRadios");
      for (e=0; e<elm.length; e++)
      {
      elm[e].checked=false;
      }
  

 elm1=document.getElementsByName("flexRadioDefault1");
      for (e=0; e<elm1.length; e++)
      {
        elm1[e].checked=false;
      }

      $('#section_personal').empty();  




}




$('#btn_send_qj').click(function(){

  selec = $('input:radio[name=exampleRadios]:checked').val();
  const fecha = new Date();
  let dia = fecha.getDate();
  let mes = fecha.getMonth() + 1;
  let an = fecha.getFullYear();
  hoy = (an+"-"+mes+"-"+dia);
  
 opcion = $('input:radio[name=flexRadioDefault1]:checked').val();
  console.log(opcion);



///validacion de datos 
   ag=$('#agencias').val();
   qj = $('#queja').val();
   sg =$('#sugerencia').val();
   ///datos anonimos

 

if( document.querySelector('input[name="flexRadioDefault1"]:checked') && opcion == 1 ){

   nom= $('#nom').val();
   cargo= $('#cargo').val();
   area= $('#area').val();
   tel= $('#telf').val();
   ///fomulario con datos

if(nom.length !==0 ){
    
    
   if(cargo.length !==0 ){ 
       
        if(area.length !==0 ){ 
    
    
         if(tel.length !==0 ){ 

   if(sg.length  !== 0 && qj.length  !==0  ){

    if(document.querySelector('input[name="exampleRadios"]:checked')) {

             if(ag.length !== 0){
                    
            
                    
                        $.ajax({
                            url: 'https://kluane.itdospuntocero.net/KDE/DATABASE/insertQJ.php',
                            type: 'POST',
                            data:{nom, cargo, qj, selec, area, tel, sg, ag, hoy},
                            success: function(response){
                            console.log(response);
                            var json = JSON.parse(response);
                        
                            
                            if(!json.err){
                                Swal.fire(
                                'Exito!',
                                json.mensaje,
                                'success')
  
                                limp();



                                          $.ajax({
                                            url: 'https://kluane.itdospuntocero.net/KDE/mail/mail.php',
                                            type: 'POST',
                                            data:{nom, qj, sg, ag},
                                            success: function(response){
                                            console.log(response);
                                            var json = JSON.parse(response);
                                        
                                            
                                            if(!json.err){
                                              
                                                
                                              console.log(response);
                                          


                                            }else{
                                                Swal.fire({
                                                icon: 'error',
                                                title: json.mensaje,
                                                text:  'buenas'
                                                // ,footer: '<a href>Como solucionarlo?</a>'
                                                })
                                                
                                                 console.log(json.debug);
                                            }
                                            }
                                        })
       










                                
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: json.mensaje,
                                text:  'Error'
                                // ,footer: '<a href>Como solucionarlo?</a>'
                                })
                                
                            }
                            }
                        })

                 

              }else{

                   
                        Swal.fire({
                            icon: 'error',
                            title: 'Debes seleccionar, una Agencia.',
                            text:  'Es importante selecionar una agencia, para tratarlo internamente'
                            // ,footer: '<a href>Como solucionarlo?</a>'
                            })



              }



        }else{
          
            Swal.fire({
                icon: 'error',
                title: 'Debes seleccionar, un Area.',
                text:  'Esto es importante para poder tratarlo internamente.'
                // ,footer: '<a href>Como solucionarlo?</a>'
                })

        }

  }else{

    Swal.fire({
        icon: 'error',
        title: 'Es necesario registrar algo.',
        text:  'Toda queja va acompaÃ±ada de una sugerencia'
        // ,footer: '<a href>Como solucionarlo?</a>'
        })
  }


    }else{
        
        
          Swal.fire({
            icon: 'error',
            title: 'Es necesario registrar algo.',
            text:  'Debes ingresar tu Telefono'
            // ,footer: '<a href>Como solucionarlo?</a>'
            })
        
    }

        }else{
        
        
          Swal.fire({
            icon: 'error',
            title: 'Es necesario registrar algo.',
            text:  'Debes ingresar tu Area'
            // ,footer: '<a href>Como solucionarlo?</a>'
            })
        
    }

    }else{
        
        
          Swal.fire({
            icon: 'error',
            title: 'Es necesario registrar algo.',
            text:  'Debes ingresar tu Cargo'
            // ,footer: '<a href>Como solucionarlo?</a>'
            })
        
    }

}else{
    
    
      Swal.fire({
        icon: 'error',
        title: 'Es necesario registrar algo.',
        text:  'Debes ingresar tus Nombres'
        // ,footer: '<a href>Como solucionarlo?</a>'
        })
    
}




}else if(document.querySelector('input[name="flexRadioDefault1"]:checked') && opcion == 2){

///formulario sin datos
nom= "ANONIMO";
cargo= "ANONIMO";
area= "ANONIMO";
tel= "0000000000";
///fomulario con datos


if(sg.length  !== 0 && qj.length  !==0 ){

  if(document.querySelector('input[name="exampleRadios"]:checked')) {

           if(ag.length !== 0){
             
                  
                      $.ajax({
                          url: 'https://kluane.itdospuntocero.net/KDE/DATABASE/insertQJ.php',
                          type: 'POST',
                          data:{nom, cargo, qj, selec, area, tel, sg, ag, hoy},
                          success: function(response){
                          console.log(response);
                          var json = JSON.parse(response);
                      
                          
                          if(!json.err){
                             
                                

                                Swal.fire({
                                  icon: 'success',
                                  title: json.mensaje,
                                  text:  'Gracias por escribirnos. Intentaremos responderte lo antes posible.'
                                  // ,footer: '<a href>Como solucionarlo?</a>'
                                  })
                                   
                                  limp();

                    
                                        
                                            $.ajax({
                                              url: 'https://kluane.itdospuntocero.net/KDE/mail/mail.php',
                                              type: 'POST',
                                              data:{nom, qj, sg, ag},
                                              success: function(response){
                                              console.log(response);
                                              var json = JSON.parse(response);
                                          
                                              
                                              if(!json.err){
                                                
                                                  
                                            console.log(response);



                                              }else{
                                                  Swal.fire({
                                                  icon: 'error',
                                                  title: json.mensaje,
                                                  text:  'â€œGracias por escribirnos. Intentaremos responderte lo antes posibleâ€.'
                                                  // ,footer: '<a href>Como solucionarlo?</a>'
                                                  })
                                                  
                                              }
                                              }
                                          })
                   

                          }else{
                              Swal.fire({
                              icon: 'error',
                              title: json.mensaje,
                              text:  'Error'
                              // ,footer: '<a href>Como solucionarlo?</a>'
                              })
                              
                          }
                          }
                      })

               

            }else{

                 
                      Swal.fire({
                          icon: 'error',
                          title: 'Debes seleccionar, una Agencia.',
                          text:  'Es importante selecionar una agencia, para tratarlo internamente'
                          // ,footer: '<a href>Como solucionarlo?</a>'
                          })



            }



      }else{
        
          Swal.fire({
              icon: 'error',
              title: 'Debes seleccionar, un Area.',
              text:  'Esto es importante para poder tratarlo internamente.'
              // ,footer: '<a href>Como solucionarlo?</a>'
              })

      }

}else{

  Swal.fire({
      icon: 'error',
      title: 'Es necesario registrar algo.',
      text:  'Toda queja va acompaÃ±ada de una sugerencia'
      // ,footer: '<a href>Como solucionarlo?</a>'
      })
}







}else{

  Swal.fire({
    icon: 'error',
    title: 'Â¿DESEAS INCLUIR TUS DATOS?',
    text:  'Debes seleccionar por lo menos una opciÃ³n.'
    // ,footer: '<a href>Como solucionarlo?</a>'
    })



}












   });
  






//validaciones
 

//cargar 
///cargar agenciaas
cargarAgencias();
function cargarAgencias(){
    $.ajax({
      url: 'https://kluane.itdospuntocero.net/KDE/DATABASE/cargar_agencias.php',
      type: 'POST',
      success: function(response){
        var json = JSON.parse(response);
        if(!json.err){
         $('#agencias').append('<option value="">Seleccione una Agencia</option> ');
          $.each(json, function(i,item){
            if(i!="err"){
            var codigo = '<option value="'+item.PK_ag+'">'+item.agencia_ag+' </option> ';
            $('#agencias').append(codigo);
            }
          })
        }
      }
    })
  }
  




 
 $('#btn_A').click(function(){

   
   modalDatos();
  $('#form').modal('show');


 });

 

 $('#agencias').change(function(){
  agencia=$('#agencias').val();
    console.log(agencia);


    $.ajax({
      url: 'https://kluane.itdospuntocero.net/KDE/DATABASE/cargar_email.php',
      type: 'POST',
      data:{agencia},
      success: function(response){
        console.log(response);
        $('#email').empty();

        var json = JSON.parse(response);
        if(!json.err){

        


          $.each(json, function(i,item){
            if(i!="err"){
           
              em = item.email_usuario;

             
          
          
          
            
          
          
          }
          })



        }
      }
    })


 });



 $('#btn_redirec_home').click(function(){

   

  window.location.href = '../web/rutas.php?ruta=home';

});


});

<style>

    

 .buzon{

    background:linear-gradient(120deg,#0077ff,#00b0ff);
    border: none;
  
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    transition: 0.3s;
    cursor: pointer;
    color: white;

}
.buzon:hover {
     transform: translateY(-5px);
     background: linear-gradient(145deg, #053f97, #011532);
     color: #f1f3f6;
}

.card-pro:hover {
    transform: translateY(-5px);
}

</style>

<!-- CONTENIDO -->
<div class="container main-content">

<div class="hero">
<h2>Bienvenido, <?php echo $USUARIO; ?> 👋</h2>
<p><?php echo $Mail; ?></p>
</div>

<div class="row g-4" id="">

              

             <div class="col-md-3" id="user_vacaciones">
                        <div class="card-clbr card-blue"><h6>  Vacaciones</h6><h3 id="vac_clbr_sec"><i class=" text-success   bi bi-calendar2-week"></i> </h3></div>
                </div>

                  <div class="col-md-3" id="user_capacitacion">
                        <div class="card-clbr card-blue"><h6>Capacitaciones</h6><h3 id="vac_clbr_sec"><i class="bi bi-book-half"></i> </h3></div>
                </div>

                
                 <div class="col-md-3" id="roles_service_clbr">
               
                   <div class="card-clbr card-blue"><h6 >Mis Roles de Pago</h6><h3 id="roles_p"><i class="bi bi-card-text"></i> </h3></div>
                </div>



                  
             

                 <div class="col-md-3" id="user_reglamento">
                        <div class="card-clbr card-blue"><h6>Reglamento Interno</h6><h3 id="vac_clbr_sec"><i class="bi bi-book-half"></i> </h3></div>
                </div>
                
                   <div class="col-md-3" id="user_denuncia">
                        <div class="card-clbr card-blue"><h6>Canales de Denuncia</h6><h3 id="vac_clbr_sec"><i class="bi bi-info-circle-fill"></i> </h3></div>
                </div>



              <div class="col-md-3" id="user_kd_escucha">

                  <div class="buzon "><h6>Buzon de Sugerencias </h6><h3 id="vac_clbr_sec"><i class="bi bi-chat-heart-fill"></i> KD Te escucha </h3></div>

                   
                </div>

                

                

            
               

           
</div>


        


    <!-- Cards de colaboradores -->


        <div class="container mt-4" id="contenedor">
            
          <div class="row" id="response_result">
      
          </div>
  
        </div>




</div>




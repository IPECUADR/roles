
<style>
.evaluar:hover {
     transform: translateY(-5px);
     background: linear-gradient(145deg, #053f97, #011532);
     color: #f1f3f6;
}
.evaluar{
    background: linear-gradient(120deg, #198754, #20c997);
    border: none;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    transition: 0.3s;
    cursor: pointer;
    color: white;
}

.politicas{

   background: linear-gradient(120deg, #0056A4, #1A1A1A);
    border: none;
  
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    transition: 0.3s;
    cursor: pointer;
    color: white;

}
.politicas:hover {
     transform: translateY(-5px);
     background: linear-gradient(145deg, #111111, #011a33);
     color: #f1f3f6;
}


</style>
<!-- CONTENIDO -->
<div class="container main-content">

<div class="hero">
<h2>Bienvenido, <?php echo $USUARIO; ?> 👋</h2>
<p>Panel de gestión corporativa</p>
</div>

<div class="row g-4">

        <div class="col-md-3" id="users_activos">
        <div class="card-pro card-blue"><h6 >Usuarios</h6><h3 id="count_personas">120</h3></div>
        </div>

            <div class="col-md-3" id="roles_report">
            <div class="card-pro card-green"><h6>Roles Cargados </h6><h3 id="count_roles">80</h3></div>
            </div>

            <div class="col-md-3" id="user_aceptacion">
            <div class="card-pro card-dark"><h6>Aceptados</h6><h3 id="count_aceptaciones">60</h3></div>
            </div>

        <div class="col-md-3" id = "cg_masiva">
            <div class="card-pro card-dark"><h6>Subir Roles  </h6><h3><i class="bi bi-cloud-upload-fill"></i></h3></div>
         </div>

         <div class="col-md-3" id = "btn_subir_vc">
            <div class="card-pro card-dark"><h6>Subir Vacaciones  </h6><h3><i class="bi bi-cloud-upload-fill"></i></h3></div>
        </div>


        <div class="col-md-3" id = "btn_postulaciones">
            <div class="card-pro card-blue"><h6> Postulaciones  </h6><h3><i class="bi bi-journal-check"></i></h3></div>
        </div>

        <div class="col-md-3" id = "btn_ejcucion">
            <div class="card-pro card-blue"><h6> Valoración Ejecución  </h6><h3><i class="bi bi-journal-check"></i></h3></div>
        </div>

           <div class="col-md-3" id="user_politicas">
                  <div class="politicas "><h6> KLUANE DRILLING   </h6><h3 id="vac_clbr_sec"><i class="bi bi-shield-check"></i> Politicas </h3></div>
                </div>

        
        <div class="col-md-3" id = "btn_cargar_usuarios">
            <div class="card-pro card-blue"><h6> Ingresar Usuarios  </h6><h3><i class="bi bi-person-fill-up"></i></h3></div>
        </div>


             <div class="col-md-3" id="evaluar_kde">


                   
                </div>

           
    
     <div class="col-md-3" id="user_vacaciones">
                        <div class="card-clbr card-blue"><h6>  Vacaciones</h6><h3 id="vac_clbr_sec"><i class=" text-success   bi bi-calendar2-week"></i> </h3></div>
                </div>
    
    </div>


        


    <!-- Cards de colaboradores -->


        <div class="container mt-4" id="contenedor">
            
          <div class="row" id="response_result">
      
          </div>
  
        </div>




</div>




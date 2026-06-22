<!-- FOOTER -->
<footer class="mt-4">
    <div class="container">
        <div class="row"></div>
        <hr class="bg-light">
        <div class="text-center small">
            &copy; 2026 Kluane. Todos los derechos reservados.
        </div>
    </div>
</footer>


<!-- Modal -->
<div class="modal fade" id="modal_service"
     data-bs-backdrop="static"
     data-bs-keyboard="false"
     tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header  bg-success">
        <h5 class="modal-title" id="titulo_modal">
          Términos y condiciones
        </h5>
      </div>

      <div class="modal-body text-dark bg-ligth" id="contenido_modal">
        Aquí van los términos o el texto que deben aceptar.
      </div>

      <div class="modal-footer" id="acciones_modal" >
        <!-- SOLO ACEPTAR -->
        <button type="button" class="btn btn-primary" id="btnAceptar">
          Aceptar
        </button>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <?php
        // Imprime JS dinámico si existe
        if (!empty($js)) {
            
        echo $js;


        }
        ?>

    <script src="../js/sys.gh.js"></script>
   
</body>
</html>
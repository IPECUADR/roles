$(document).ready(function () {

    //---------------------------------------
    // Abrir formulario
    //---------------------------------------

    $(".abrirFormulario").click(function () {

        let titulo = $(this).data("titulo");
        let url = $(this).data("url");

        // Cambiar título
        $("#tituloFormulario").html(titulo);

        // Cambiar iframe
        $("#frmDenuncia").attr("src", url);

        // Ocultar Hero
        $("#heroDenuncia").addClass("ocultar");

        // Ocultar información
        $(".info-box").addClass("ocultar");

        // Cambiar modo
        $(".landing-denuncias").addClass("modoFormulario");

        // Tarjeta activa
        $(".tipo-card").removeClass("activa");

        $(this)
            .closest(".tipo-card")
            .addClass("activa");

        // Mostrar visor

        $("#visorFormulario").show();

        setTimeout(function () {

            $("#visorFormulario").addClass("activo");

            $('html, body').animate({

                scrollTop: $("#visorFormulario").offset().top - 20

            }, 500);

        }, 200);

    });

    //---------------------------------------
    // Cambiar formulario
    //---------------------------------------

    $(".tipo-card").click(function () {

        if (!$(".landing-denuncias").hasClass("modoFormulario"))
            return;

        let boton = $(this).find(".abrirFormulario");

        let titulo = boton.data("titulo");

        let url = boton.data("url");

        $(".tipo-card").removeClass("activa");

        $(this).addClass("activa");

        $("#tituloFormulario").fadeOut(150, function () {

            $(this).html(titulo).fadeIn(150);

        });

        $("#frmDenuncia").fadeOut(150, function () {

            $("#frmDenuncia")
                .attr("src", url)
                .fadeIn(150);

        });

    });

    //---------------------------------------
    // Cerrar formulario
    //---------------------------------------

    $("#cerrarFormulario").click(function () {

        $("#visorFormulario").removeClass("activo");

        setTimeout(function () {

            $("#visorFormulario").hide();

            $("#frmDenuncia").attr("src", "");

        }, 300);

        $("#heroDenuncia").removeClass("ocultar");

        $(".info-box").removeClass("ocultar");

        $(".landing-denuncias").removeClass("modoFormulario");

        $(".tipo-card").removeClass("activa");

        $("html, body").animate({

            scrollTop: $(".landing-denuncias").offset().top

        }, 500);

    });

});
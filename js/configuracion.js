// Actualizar contraseña
$('#btn_up_pass').click(function () {

    pass_actual    = $('#pass_actual').val().trim();
    pass_nueva     = $('#pass_nueva').val().trim();
    pass_confirmar = $('#pass_confirmar').val().trim();

    if (!pass_actual || !pass_nueva || !pass_confirmar) {
        mensaje('info', 'Complete todos los campos');
        return;
    }

    if (pass_nueva !== pass_confirmar) {
        mensaje('error', 'La nueva contraseña y la confirmación no coinciden');
        return;
    }

    up_clave(pass_actual, pass_nueva, pass_confirmar);
});

// Enviar actualización de contraseña
function up_clave(pass_actual, pass_nueva, pass_confirmar) {

    $.post(
        '../db/up_clave.php',
        {
            pass_actual,
            pass_nueva,
            pass_confirmar
        },
        function (r) {

            console.log(r);

            if (!r.err) {
                mensaje(r.icon, r.msg);

                $('#pass_actual').val('');
                $('#pass_nueva').val('');
                $('#pass_confirmar').val('');
            } else {
                mensaje(r.icon, r.msg);
            }

        },
        'json'
    ).fail(() => {
        mensaje('error', 'Error de servidor');
    });

}

// Mensajes
function mensaje(icon, msg) {

    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    }).fire({
        icon: icon,
        title: msg
    });

}

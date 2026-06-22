$(document).ready(function () {
    cargar_perfil();
});

// Cargar información del usuario autenticado
function cargar_perfil() {

    $.post('../db/b_perfil.php', function (r) {

        console.log(r);

        if (!r.err) {

            $('#nom_p').val(r.data.nom_p);
            $('#ap_p').val(r.data.ap_p);
            $('#ci_p').val(r.data.ci_p);
            $('#dir_p').val(r.data.dir_p);
            $('#email').val(r.data.email);
            $('#telf_p').val(r.data.telf_p);
            $('#user_p').val(r.data.user_p);
            $('#cargo_cg').val(r.data.cargo_cg);
            $('#proyecto').val(r.data.proyecto);
            $('#t_user').val(r.data.t_user);

        } else {
            mensaje(r.icon, r.msg);
        }

    }, 'json').fail(() => {
        mensaje('error', 'Error de servidor');
    });

}

// Actualizar información del perfil
$('#btn_up_perfil').click(function () {

    nom_p  = $('#nom_p').val().trim();
    ap_p   = $('#ap_p').val().trim();
    dir_p  = $('#dir_p').val().trim();
    email  = $('#email').val().trim();
    telf_p = $('#telf_p').val().trim();

    if (!nom_p || !ap_p || !dir_p || !email || !telf_p) {
        mensaje('info', 'Complete todos los campos editables');
        return;
    }

    if (!validateEmail(email)) {
        mensaje('error', 'Ingrese un correo válido');
        return;
    }

    up_perfil(nom_p, ap_p, dir_p, email, telf_p);
});

// Enviar actualización del perfil
function up_perfil(nom_p, ap_p, dir_p, email, telf_p) {

    $.post(
        '../db/up_perfil.php',
        {
            nom_p,
            ap_p,
            dir_p,
            email,
            telf_p
        },
        function (r) {

            console.log(r);

            if (!r.err) {
                mensaje(r.icon, r.msg);
                cargar_perfil();
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

// Validación de correo
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
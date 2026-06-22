$('#whatsapp-btn').on('click', function () {

    var rawNumber = '+593 98 941 4620';
    var phoneNumber = rawNumber.replace(/\D/g, ''); // elimina todo excepto números

    var message = 'Hola, me gustaría obtener más información sobre un colaborador.';
    var url = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(message);

    window.open(url, '_blank');
});
``
window.addEventListener('showNotification', function(event){
    var data = event.detail[0];
    var type = data.type;
    var message = data.message;
    showNotification(type, message);
});

function showNotification(type, message) {
    Lobibox.notify(type, {
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        icon: 'bx bx-check-circle',
        msg: message,
        sound: false,
        delay: 2000,
    });
}
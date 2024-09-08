// notificationScripts.js

function showNotification() {
    var notification = document.getElementById('notification');
    notification.style.display = 'block';
    setTimeout(function() {
        notification.style.display = 'none';
    }, 5000);
}

function showNotificationEmailExists() {
    var notificationExists = document.getElementById('notificationEmailExists');
    notificationExists.style.display = 'block';
    setTimeout(function() {
        notificationExists.style.display = 'none';
    }, 5000);
}

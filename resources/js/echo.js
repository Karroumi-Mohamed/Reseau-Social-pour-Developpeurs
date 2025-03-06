import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const userId = document.querySelector('meta[name="user-id"]').content;
window.Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        console.log(notification);

        if (typeof fetchNotifications === 'function') {
            alert('Post liked');
            fetchNotifications();
        }
        alert('Post liked');
    });

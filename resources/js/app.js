import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import Swal from 'sweetalert2';
document.getElementById('show-alert').addEventListener('click', () => {
    Swal.fire({
        title: 'Hello, Laravel 10!',
        text: 'Sweetalert2 is now integrated into your Laravel 10 Vite project!',
        icon: 'success',
    });
});
import './bootstrap';
import intersect from '@alpinejs/intersect';
import Alpine from 'alpinejs';

window.addEventListener('alpine:init', () => {
    Alpine.plugin(intersect);
})

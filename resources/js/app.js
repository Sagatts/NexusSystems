import './bootstrap';

import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';

import './validarRut';
import './validarCorreo';

window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();

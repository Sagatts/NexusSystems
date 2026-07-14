import './bootstrap';

import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';

import './validarRut';
import './validarCorreo';
import './password-strength';
import './dashboard-charts';
import './product-form';
import './reportes-datatable';
import './toggle-password';
import './pedidos';
import './usuarios-datatable';
import './sidebar';
import './perfil-form';
import './productos-datatable';
import './update-password-form';
import './disable-html-validation';
import './validarcierresesion';

window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();
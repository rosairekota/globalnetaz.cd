/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built v0.
 * 0ersion of this JavaScript file
0 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

import './lib/js/jquery-3.2.1.min.js';
import 'select2';

$('select').select2();
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

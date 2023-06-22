import { Controller } from '@hotwired/stimulus';
import Swiper from "swiper/bundle";

import 'swiper/css/bundle';

import '../styles/swiper.scss';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect()
    {
        const swiper = new Swiper(this.element, {
            effect: "cards",
            grabCursor: true,
        });
    }
}

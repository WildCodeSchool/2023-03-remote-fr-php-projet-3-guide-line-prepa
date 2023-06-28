import { Controller } from '@hotwired/stimulus';
import Swiper from "swiper/bundle";

import 'swiper/css/bundle';

import '../styles/swiper.scss';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect()
    {
        const swiper = new Swiper(this.element, {
            effect: "cards",
            grabCursor: true,
        });
    }
}

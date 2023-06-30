import { Controller } from '@hotwired/stimulus';

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
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }

    play(event)
    {
        // [...document.querySelectorAll('.list-group-player')].map(el => el.classList.remove('active'));
        const component = document.getElementById('player').__component;
        component.action('playSound', { soundId: event.currentTarget.dataset.soundId });

        const lastSoundPlayerComponent = document.querySelector('.list-group-player.active');
        if (lastSoundPlayerComponent) {
            lastSoundPlayerComponent.__component.render();
        }

        const soundComponent = event.currentTarget.__component;
        if (soundComponent) {
            soundComponent.render();
        }
    }
}

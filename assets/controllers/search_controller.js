import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['searchInput', 'showButton']

    show(event)
    {
        this.searchInputTarget.classList.remove('d-none');
        this.searchInputTarget.querySelector('input').setAttribute('aria-hidden', 'false')
        this.searchInputTarget.querySelector('input').focus();
        this.showButtonTarget.classList.add('d-none');
        this.showButtonTarget.setAttribute('aria-hidden', 'true');
    }

    hide(event)
    {
        this.searchInputTarget.classList.add('d-none');
        this.searchInputTarget.querySelector('input').setAttribute('aria-hidden', 'true');
        this.showButtonTarget.classList.remove('d-none');
        this.showButtonTarget.setAttribute('aria-hidden', 'false');
    }

    keyDown(event)
    {
        if (event.key === 'Escape') {
            this.hide(event)
        }
    }
}

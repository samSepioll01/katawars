import './bootstrap';

// Crop Profile Images
import Cropper from 'cropperjs';

window.Cropper = Cropper;

// IodineJS Validator
import Iodine from '@caneara/iodine';

window.Iodine = Iodine;

// Light weight framework
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.$katawars = {
    AWS_APP_URL: 'https://s3.eu-south-2.amazonaws.com/katawars.es/app',
}

window.$katawars.S3 = {
    icons: {
        lightMode: $katawars.AWS_APP_URL + '/icons/brillo.png',
        darkMode: $katawars.AWS_APP_URL + '/icons/modo-nocturno.png',
        favoritesOn: $katawars.AWS_APP_URL + '/icons/favoritos1.png',
        favoritesOff: $katawars.AWS_APP_URL + '/icons/favoritos2.png',
        markerOn: $katawars.AWS_APP_URL + '/icons/marcador2.png',
        markerOff: $katawars.AWS_APP_URL + '/icons/marcador1.png',

    },
}

window.$modals = {
    show(name) {
        window.dispatchEvent(
            new CustomEvent('modal', {
                detail: name,
            })
        );
    },
}

window.$theme = {
    change(theme) {
        window.dispatchEvent(
            new CustomEvent('changetheme', {
                detail: theme,
            })
        );
    }
}

window.$aux = {
    createElement(elem = null, attributes = {}, textNode = '') {

        const TEXT_ELEMS = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'p', 'label',
                            'span', 'b', 'em', 'strong', 'i', 'u', 'a', 'button'];

        if (elem) {
            elem = document.createElement(elem);
        }

        if (Object.keys(attributes).length > 0) {
            for (let [key, value] of Object.entries(attributes)) {
                if (key == 'class' && Array.isArray(value)) {
                    value.forEach(clase => elem.classList.add(clase));
                } else {
                    elem.setAttribute(key, value);
                }
            }
        }

        if (textNode) {
            if (TEXT_ELEMS.includes(elem.localName)) {
                elem.textContent = textNode;
            }
        }
        return elem;
    },
}

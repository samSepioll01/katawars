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

import Sortable from 'sortablejs';

window.Sortable = Sortable;

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

window.$flash = {
    show(name, type, message) {
        window.dispatchEvent(
            new CustomEvent('flash', {
                detail: {
                    name: name,
                    type: type,
                    message: message,
                },
            })
        );
    },
    status: {
        success: 'bg-teal-600 border-teal-700 shadow-teal-400 text-white',
        error: 'bg-rose-600 border-rose-800 shadow-rose-400 text-white',
        warning: 'bg-yellow-500 border-yellow-700 text-orange-700',
    },
    removeStyles(target)
    {
        Object.values($flash.status)
            .forEach(styles => target.classList.remove(...styles.split(' ')));
    },
    addStyles(target, styles)
    {
        target.classList.add(...styles.split(' '));
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

window.$progressbar = {
    update(progress) {
        window.dispatchEvent(
            new CustomEvent('updateprogress', {
                detail: progress,
            })
        );
    }
}

window.$refresh = {
    follows (followers, following) {
        window.dispatchEvent(
            new CustomEvent('followsupdated', {
                detail: {
                    followers: followers,
                    following: following,
                },
            })
        );
    },

    following (followees) {
        window.dispatchEvent(
            new CustomEvent('followeesupdated', {
                detail: followees,
            })
        );
    },

    solutions() {
        window.dispatchEvent(
            new CustomEvent('refreshsolutions', {
                detail: true,
            })
        );
    },
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
    getUrlSlug(url = '')
    {
        let paths = url.split('/');
        return paths[paths.length - 1];
    }
}

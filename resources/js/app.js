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

window.$modals = {
    show(name) {
        window.dispatchEvent(
            new CustomEvent('modal', {
                detail: name,
            })
        );
    },
}

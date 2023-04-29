const imageInput = document.querySelector('.imageinput');
const image = document.getElementById('cropperimage');
let cropper, iodine;

        window.addEventListener('load', function() {
            iodine = new Iodine();
            iodine.rule('fileType', (type) => {
                return ['image/png', 'image/jpeg'].includes(type);
            });
            iodine.rule('fileMaxSize', (size) => {
                return parseInt(size) < 1000000;
            });
            iodine.setErrorMessages({
                fileType: `[FIELD] must be a valid image format (png, jpeg, jpg).`,
                fileMaxSize: `[FIELD] must be less than 1M.`,
            });
            iodine.setDefaultFieldName('File');


            cropper = new Cropper(
                image,
                {
                    aspectRatio: 1,
                    viewMode: 2,
                    preview: '.preview',
                }
            );
        });

        imageInput.addEventListener('change', (eChange) => {

            let errorFile = document.getElementById('error-file');
            let files = eChange.target.files;

            if (files && files.length > 0) {

                let file = files[0];

                 let validations = {
                     type: iodine.assert(file.type, ['fileType']),
                     size: iodine.assert(file.size, ['fileMaxSize']),
                 }


                 if (!validations.type.valid) {

                     errorFile.textContent = validations.type.error;
                     return false;
                 }

                 if (!validations.size.valid) {
                     errorFile.textContent = validations.size.error;
                     return false;
                 }

                 if (validations.type.valid && validations.size.valid) {

                    errorFile.textContent = '';

                    let reader = new FileReader();
                    reader.onload = (eReaderLoad) => {

                        image.src = reader.result;
                        window.$modals.show('cropper-modal');

                        window.dispatchEvent(
                            (new CustomEvent('loadimage', {detail: reader.result}))
                        );
                    };

                    reader.readAsDataURL(file);
                 }

            }
        });

        window.addEventListener('loadimage', function(eLoadImage) {
            cropper.replace(eLoadImage.detail);
            console.log(cropper.getCanvasData());
        });

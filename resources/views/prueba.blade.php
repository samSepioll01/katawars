<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .preview {
                overflow: hidden;
                width: 240px;
                height: 240px;
                margin: 10px;
                border-radius: 50%;
                border: 1px solid red;
            }

    </style>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- CDNs
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    --}}
</head>
<body>

    <main class="min-h-screen w-full flex flex-col items-center justify-start">

        <div class="p-16">

            <div class="flex flex-col justify-center items-center">
                <input type="file" name="image" class="image"/>
                <p id="error-file" class="text-red-600 text-sm"></p>
            </div>
        </div>


        <div class="flex flex-row justify-between items-center w-11/12 border border-blue-600">
            <div class="border border-blue-600 w-3/4">
                <img id="imagecropper" src="" alt="" class="hidden max-w-full w-full h-full" >
            </div>



            <div class="">
                <div class="preview"></div>
            </div>
        </div>
    </main>

    <script>

        const imageInput = document.querySelector('.image');
        const image = document.getElementById('imagecropper');
        let cropper, iodine;

        window.addEventListener('load', function() {
            Iodine = new Iodine();
            Iodine.rule('fileType', (type) => {
                return ['image/png', 'image/jpeg'].includes(type);
            });
            Iodine.rule('fileMaxSize', (size) => {
                return parseInt(size) < 1000000;
            });
            Iodine.setErrorMessages({
                fileType: `[FIELD] must be a valid image format (png, jpeg, jpg).`,
                fileMaxSize: `[FIELD] must be less than 1M.`,
            });
            Iodine.setDefaultFieldName('File');


            cropper = new Cropper(
                image,
                {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview',
                }
            );
        });

        imageInput.addEventListener('change', (eChange) => {

            let errorFile = document.getElementById('error-file');
            let files = eChange.target.files;

            if (files && files.length > 0) {

                let file = files[0];
                console.log(file);

                let validations = {
                    type: Iodine.assert(file.type, ['fileType']),
                    size: Iodine.assert(file.size, ['fileMaxSize']),
                }


                if (!validations.type.valid) {

                    errorFile.textContent = validations.type.error;
                    return false;
                }

                if (!validations.size.valid) {
                    errorFile.textContent = validations.size.error;
                    return false;
                }

                errorFile.textContent = '';

                let reader = new FileReader();
                reader.onload = (eReaderLoad) => {

                    if (image.classList.contains('hidden')) {
                        image.classList.remove('hidden');
                        image.classList.add('block');
                    }

                    image.src = reader.result;

                    window.dispatchEvent(
                        (new CustomEvent('loadimage', {detail: reader.result}))
                    );
                };

                reader.readAsDataURL(file);
            }
        });

        window.addEventListener('loadimage', function(eLoadImage) {
            cropper.replace(eLoadImage.detail);
        });

    </script>

</body>
</html>

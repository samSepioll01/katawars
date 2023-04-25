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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <main class="min-h-screen w-full flex flex-col items-center justify-start">

        <div class="p-16">

            <form method="post" class="flex justify-center items-center">
                <input type="file" name="image" class="image"/>
            </form>
        </div>


        <div class="flex flex-row justify-between items-center w-11/12 border border-blue-600">
            <div class="border border-blue-600 w-3/4">
                <img id="image" src="" alt="" class="hidden max-w-full w-full h-full" >
            </div>



            <div class="">
                <div class="preview"></div>
            </div>
        </div>
    </main>

    <script>

        const imageInput = document.querySelector('.image');
        const image = document.getElementById('image');
        const cropper = new Cropper(
            image,
            {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview',
            }
        );

        imageInput.addEventListener('change', (eChange) => {

            let files = eChange.target.files;
            let file, reader;

            if (files && files.length > 0) {

                file = files[0];
                reader = new FileReader();
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

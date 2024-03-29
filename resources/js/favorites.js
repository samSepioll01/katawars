
const list = document.getElementById('list');

if (list) {

    list.addEventListener('click', (eClick) => {

        if (['cross-savedkata', 'cross'].includes(eClick.target.classList[0])) {

            let getID = {
                'cross-savedkata': eClick.target.id,
                'cross': eClick.target.parentNode.id,
            }

            let favoriteID = getID[eClick.target.classList[0]];

            let favorite = [...list.querySelectorAll(".card-challenge")]
                    .filter(elem => elem.id === favoriteID)
                    .shift();

            favorite.style.transition = '.3s';
            favorite.style.overflow = 'hidden';
            favorite.style.opacity = '0%';
            favorite.style.padding = '0px';
            favorite.style.height = '0px';

            setTimeout(() => favorite.style.display = 'none', 300);

            if (favoriteID) {
                axios.delete('/favorites/' + favoriteID)
                .then(response => {

                    if (response.data.success) {
                        let favorite = [...list.querySelectorAll(".card-challenge")]
                            .filter(elem => elem.id === favoriteID)
                            .shift();

                        let timeout = setTimeout(elem => {
                            list.removeChild(favorite);
                        }, 700);

                        if (!response.data.totalfavorites) {
                            list.innerHTML = '<h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>';
                            clearTimeout(timeout);
                        }

                        window.dispatchEvent(
                            new CustomEvent('updatefavorites', {
                                detail: response.data.totalfavorites,
                            })
                        );
                    }
                })
                .catch(error => console.log(error));
            }
        }
    });
}

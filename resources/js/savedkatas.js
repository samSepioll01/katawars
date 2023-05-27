
   // Set sortable object with the list of saved katas.
   const list = document.getElementById('list');
   Sortable.create(
       list,
       {
           handle: '.handle',
           animation: 500,
           direction: 'vertical',
       }
   );

   // Async Infinite Scroll

   window.addEventListener('DOMContentLoaded', (eDCL) => {
    window.addEventListener('scroll', (eScroll) => {
        eScroll.stopImmediatePropagation();

        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {

            let url = window.location.href;
            let nextCursor = list.querySelector('#next-cursor').innerHTML || null;

            if (nextCursor) {
                axios({
                    method: 'get',
                    url: url + '?cursor=' + nextCursor,
                    responseType: 'json',
                    data: {
                        nextCursor: nextCursor,
                    }
                })
                .then(response => {
                    if (response.data.success) {
                        list.insertAdjacentHTML('beforeend', response.data.html);
                        list.querySelector('#next-cursor').innerHTML = response.data.nextCursor;
                    } else {
                       console.log(response.data.nextCursor); // PENDIENTE ELIMINAR
                    }
                })
                .catch(error => console.log(error));
            }
        }
    })
});


// Actualización Orden Manual (Sortable).

let target;

list.addEventListener('drag', (eDrag) => {
    target = eDrag.target.id;
});

list.addEventListener('drop', (eDrop) => {

    let modifiedOrder = [...list.querySelectorAll('.card-challenge')].map((elem) => elem.id);

    axios({
        method: 'patch',
        url: "/saved-katas/update",
        responseType: 'json',
        data: {
            modifiedOrder: modifiedOrder,
            target: target,
        }
    })
    .then(response => (response.data.success)
        ? console.log('Successful Update!')
        : null
    )
    .catch(error => console.log(error));
});


// Delete Saved Kata.

list.addEventListener('click', (eClick) => {

    let getID = {
        'cross-savedkata': eClick.target.id,
        'cross': eClick.target.parentNode.id,
    }

    let savedKataID = getID[eClick.target.classList[0]];

    let savedKata = [...list.querySelectorAll(".card-challenge")]
            .filter(elem => elem.id === savedKataID)
            .shift();

    savedKata.style.transition = '.3s';
    savedKata.style.overflow = 'hidden';
    savedKata.style.opacity = '0%';
    savedKata.style.padding = '0px';
    savedKata.style.height = '0px';

    setTimeout(() => savedKata.style.display = 'none', 300);

    if (savedKataID) {
        axios.delete('/saved-katas/' + savedKataID)
        .then(response => {

            if (response.data.success) {
                let savedKata = [...list.querySelectorAll(".card-challenge")]
                    .filter(elem => elem.id === savedKataID)
                    .shift();

                setTimeout(elem => {
                    list.removeChild(savedKata);
                }, 700);

                list.insertAdjacentHTML('beforeend', response.data.html);
                window.dispatchEvent(
                    new CustomEvent('updatesaved', {
                        detail: response.data.totalSavedKatas,
                    })
                );
            }
        })
        .catch(error => console.log(error));
    }
});

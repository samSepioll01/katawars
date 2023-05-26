
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

    let modifiedOrder = [...list.querySelectorAll('.elemento')].map((elem) => elem.id);

    axios({
        method: 'post',
        url: "/saved-katas/updated",
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

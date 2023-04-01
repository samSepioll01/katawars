function hubSidebar()
{
    return {
        DOMelems: {
            sidebarHub: document.querySelector('.hub'),
            responsiveHub: document.querySelector('[class="hub responsive"]'),
        },

        sidebarOpen: false,
        responsiveOpen: false,

        transformHub(DOMelem, elemOpen) {
            let topBar = DOMelem.children[0];
            let centerBar = DOMelem.children[1];
            let bottomBar = DOMelem.children[2];

            if (elemOpen) {
                centerBar.style.opacity = '0%';
                topBar.style.transform = 'translateY(6px)';
                bottomBar.style.transform = 'translateY(-6px)';
                setTimeout(() => topBar.style.transform += 'rotate(40deg)', 200);
                setTimeout(() => bottomBar.style.transform += 'rotate(-40deg)', 200);
            } else {
                topBar.style.transform = 'translateY(6px) rotate(0deg)';
                bottomBar.style.transform = 'translateY(-6px) rotate(0deg)';
                setTimeout(() => topBar.style.transform = '', 200);
                setTimeout(() => bottomBar.style.transform = '', 200);
                setTimeout(() => centerBar.style.opacity = '', 250);
            }
        },

        checkHub(eTarget = null, elemOpen = false)
        {
            if (eTarget.classList.contains('responsive')) {
                this.transformHub(this.DOMelems.responsiveHub, elemOpen);
            } else {
                this.transformHub(this.DOMelems.sidebarHub, elemOpen);
            }
        },
    }
}

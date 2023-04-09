/**
 * It setting the neccesary change for the differents themes
 * of the application interface layout.
 */

// SCRIPT VARIABLES

const elemHtml = document.querySelector('html');
const elemBody = document.querySelector('body');
const btnChangeMode = document.getElementById('btn-mode');
const modeIcon = document.getElementById('mode-icon');
const darkModeIconPath = `${window.location.origin}/storage/icons/modo-nocturno.png`;
const lightModeIconPath = `${window.location.origin}/storage/icons/brillo.png`;
const csrf_token = document.querySelector('meta[name="csrf-token"]').content;


// AUXILIAR FUNCTIONS

/**
 * Set the changes over both dark and light themes.
 * @param {String} theme Name of theme to set.
 */
function changeTheme(theme = 'dark')
{
    if (theme === 'dark') {
        modeIcon.src = lightModeIconPath;
        elemBody.classList.add('scrollbar-dark');
        elemBody.classList.remove('scrollbar-light');
    }

    if (theme === 'light') {
        modeIcon.src = darkModeIconPath;
        elemBody.classList.add('scrollbar-light');
        elemBody.classList.remove('scrollbar-dark');
    }

    elemHtml.classList.toggle('dark');
}

/**
 * Send preconfigured async request form Axios API to
 * save the changes of the theme.
 * @param {String} theme Name of theme to change.
 */
function sendAxiosChangeThemeRequest(theme)
{
    axios({
        method: 'post',
        url: `${window.location.origin}/save-theme`,
        responseType: 'json',
        data: {
            theme: theme,
        }
    })
    .then(response => {
        if (response.data.success) {
            localStorage.setItem('theme', response.data.theme);
        }
    })
    .catch(error => console.log(error));
}


// EVENTS HANDLERS

// In charge of controlling when the user makes
// the manual change between both dark or light mode.
btnChangeMode.addEventListener('click', eClick => {

    if (elemHtml.classList.contains('dark')) {
        changeTheme('light');
        sendAxiosChangeThemeRequest('light');

    } else {
        changeTheme('dark');
        sendAxiosChangeThemeRequest('dark');
    }
});

if (window.Laravel?.userId) {

    window.Echo.private(`theme.user.${window.Laravel.userId}`)
        .listen('ThemeModeUpdated', (eEcho) => {
            changeTheme(eEcho.theme);
        });
} else {
    window.Echo.channel(`theme.${csrf_token}`)
        .listen('ThemeModeUpdated', (eEcho) => {
            changeTheme(eEcho.theme);
        });
}

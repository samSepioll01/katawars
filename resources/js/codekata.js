
const checkBTN = document.getElementById('check');

document.addEventListener('DOMContentLoaded', eDCL => {

    // Ace Editor Config
    const editor = ace.edit("editor");
    editor.setTheme("ace/theme/solarized_light"); // Theme: monokai | solarized_light
    editor.session.setMode("ace/mode/php"); // Set language parser
    //editor.setKeyboardHandler("ace"); // Keybinding: Ace
    editor.setFontSize("16px");
    editor.setOption("wrap", "free"); // Soft Wrap: View
    editor.setOption("cursorStyle", "ace"); // Estilo de cursor: Ace
    editor.setOption("foldStyle", "markbegin");
    editor.setOption("tabSize", 4); // Tabs spaces
    editor.setOption("scrollPastEnd", false); // Overscroll
    editor.setBehavioursEnabled(true); // Habilitar comportamientos
    editor.setOption("wrapBehavioursEnabled", true); // Set wrapped content
    editor.setOption("enableAutoIndent", true); // Auto indentation
    editor.setOption("selectionStyle", "line"); // Select full line
    editor.setOption("highlightActiveLine", true); // Hightlight active line
    editor.setOption("showInvisibles", false); // Show tabs guide
    editor.setOption("displayIndentGuides", true); // Hightlight indent guides
    editor.setShowPrintMargin(true); // Show print margin
    editor.setOption("showGutter", true); // Show gutter (side panel)
    editor.setOption("showLineNumbers", true); // Show number lines
    editor.setOption("indentedSoftWrap", true); // Indent in soft wrap
    editor.setOption("highlightSelectedWord", true); // Hightlight selected word
    editor.setOption("useTextareaForIME", true); // Use textarea for IME
    editor.setOption("mergeUndoDeltas", "timed"); // Merge undo deltas

    window.Ace = editor; // Allow call the editor object from everywhere in the view.

    // Select editor theme depending of the select layout theme.
    if (document.documentElement.classList.contains('dark')) {
        ace.edit('editor').setTheme('ace/theme/monokai');
    } else {
        ace.edit('editor').setTheme('ace/theme/solarized_light');
    }

    // ShortHand for parser code with Cntrl + Spacebar.
    document.addEventListener("keydown", (eKeydown) => {
        if (eKeydown.ctrlKey && eKeydown.code === "Space") {
            checkBTN.disabled = true;
            checkBTN.classList.remove('active:translate-y-1');
            checkCode();
        }
    });

    // Get the code in code editor and send it to parse.
    checkBTN.addEventListener('click', eClick => {
        checkBTN.disabled = true;
        checkBTN.classList.remove('active:translate-y-1');
        checkCode();
    });


});

/**
 * Send request to check the code insert by the user and handle the responses.
 */
function checkCode()
{
    const errorPanel = document.getElementById('error-panel');
    let code = ace.edit('editor').getValue();

    axios({
        method: 'post',
        url: window.location.href + '/verify-kata',
        responseType: 'json',
        data: {
            slug: $aux.getUrlSlug(window.location.href),
            code: code,
        },
    })
    .then(response => {
        checkBTN.disabled = false;
        checkBTN.classList.add('active:translate-y-1');

        if (response.data.success) {
            $modals.show('passedkata-modal');
            errorPanel.innerHTML = response.data.message;
            document.getElementById('sidebar_progress-bar').style.width = response.data.progressbar;
        } else {
            $flash.show('verifycode', 'error', response.data.flash);
            errorPanel.innerHTML = response.data.message;
        }
    })
    .catch(errors => {
        $flash.show('verifycode', 'error', 'Opps! Some was wrong! Sorry, try later.');
        checkBTN.disabled = false;
        checkBTN.classList.add('active:translate-y-1');
    });
}

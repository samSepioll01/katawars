
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
            document.getElementById('check').click();
        }
    });

    // Get the code in code editor and send it to parse.
    document.getElementById('check')
        .addEventListener('click', eClick => {
            let code = ace.edit('editor').getValue();
            code = code.replaceAll('<?php', '');
            console.log(code.trim());
        });


});

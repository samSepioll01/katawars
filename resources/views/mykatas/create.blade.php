<x-app-layout>
    <x-layout.wrapper-secondary-panel x-data="{}" x-init="setTimeout(() => { $el.classList.add('opacity-100'); }, 100)" class="opacity-0 transition-all duration-200">

        <header class="text-4xl w-full flex justify-center py-5">
            {{ __('Create Challenge') }}
        </header>

        <div>

            <div class="w-full md:w-3/4 py-5">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" x-ref="title" type="text" name="title" class="mt-1 block w-full text-slate-700/70" value="{{ old('title') }}"/>
                <p id="error-title" x-ref="errortitle" class="text-sm text-red-600"></p>
            </div>

            <style>
                #container {
                    width: 1000px;
                    margin: 20px auto;
                }
                /* Cambiar el color de fondo de la interfaz */
                .ck {

                }

                /* Cambiar el color de las fuentes de la interfaz */
                .ck,
                .ck .ck-content,
                .ck .ck-heading,
                .ck .ck-placeholder {
                    color:rgba(36, 36, 36, 1);
                }
                .ck-editor__editable[role="textbox"] {
                    /* editing area */
                    min-height: 200px;
                }
                .ck-content .image {
                    /* block images */
                    max-width: 80%;
                    margin: 20px auto;
                }
            </style>

            <div class="w-full py-10">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <div class="w-full rounded-lg overflow-hidden border boder-slate-200 dark:border-slate-800/70 shadow-lg">
                    <textarea class="" name="description" id="description" x-ref="description" cols="30" rows="10">{{ old('description', '') }}</textarea>
                </div>
                <p id="error-description" x-ref="errordescription" class="text-sm text-red-600"></p>
            </div>

            <div class="w-full py-10">
                <x-jet-label for="examples" value="{{ __('Examples') }}" class="" />
                <div class="w-full rounded-lg overflow-hidden border boder-slate-200 dark:border-slate-800/70 shadow-lg">
                    <textarea class="" name="examples" id="examples" x-ref="examples" cols="30" rows="10">{{ session('examples') ? session('examples') : '' }}</textarea>
                </div>
                <p id="error-examples" x-ref="errorexamples" class="text-sm text-red-600"></p>
            </div>

            <div class="w-full py-10">
                <x-jet-label for="notes" value="{{ __('Notes') }}" />
                <div class="w-full rounded-lg overflow-hidden border boder-slate-200 dark:border-slate-800/70 shadow-lg">
                    <textarea class="" name="notes" id="notes" x-ref="notes" cols="30" rows="10">{{ old('notes', '') }}</textarea>
                </div>
                <p id="error-notes" x-ref="errornotes" class="text-sm text-red-600"></p>
            </div>

            <div class="w-full md:w-3/4 py-5">
                <x-jet-label for="signature" value="{{ __('Function Signature ( includes function open bracket and without close bracket )') }}" />
                <x-jet-input id="signature" x-ref="signature" type="text" name="signature" class="mt-1 block w-full text-slate-700/70" value="{{ old('signature', $functionSignature) }}"/>
                <p id="error-signature" x-ref="errorsignature" class="text-sm text-red-600"></p>
            </div>

            <div class="w-full md:w-3/4 py-5">
                <x-jet-label for="testclassname" value="{{ __('Test Class Name') }}" />
                <x-jet-input id="testclassname" x-ref="testclassname" type="text" name="testclassname" class="mt-1 block w-full text-slate-700/70" value="{{ old('testclassname', $testClassName) }}"/>
                <p id="error-testclassname" x-ref="errortestclassname" class="text-sm text-red-600"></p>
            </div>

            <div>
                <x-jet-label for="" value="{{ __('Test Code') }}" />
                <div class="min-h-[600px] col-span-12 lg:col-span-8 relative py-5">
                    <div
                        id="code-editor"
                        x-ref="codeeditor"
                        class="editorkata min-h-[500px]"
                        @changetheme.window="
                            if ($event.detail === 'light') {
                                ace.edit('code-editor').setTheme('ace/theme/solarized_light');
                            }

                            if ($event.detail === 'dark') {
                                ace.edit('code-editor').setTheme('ace/theme/monokai');
                            }
                        "
                    >{{ old('code', $testSkel) }}</div>
                </div>
                <p id="error-testcode" x-ref="errortestcode" class="text-sm text-red-600"></p>
                <textarea name="code" id="code" x-ref="code" cols="30" rows="10" class="hidden"></textarea>
            </div>



            <div>
                <x-jet-label for="" value="{{ __('Solution Code') }}" />
                <div class="min-h-[600px] col-span-12 lg:col-span-8 relative py-5">
                    <div
                        id="solution-editor"
                        x-ref="solutioneditor"
                        class="editorkata min-h-[500px]"
                        @changetheme.window="
                            if ($event.detail === 'light') {
                                ace.edit('solution-editor').setTheme('ace/theme/solarized_light');
                            }

                            if ($event.detail === 'dark') {
                                ace.edit('solution-editor').setTheme('ace/theme/monokai');
                            }
                        "
                    >{{ old('solution', $codeSolution) }}</div>
                </div>
                <p id="error-solution" x-ref="errorsolution" class="text-sm text-red-600"></p>
                <textarea name="solution" id="solution" x-ref="solution" cols="30" rows="10" class="hidden"></textarea>
            </div>

            <div class="flex flex-row justify-evenly">
                <section id="cont-categories">
                    <h3 class="text-slate-800/70 dark:text-slate-100">Categories</h3>
                    <div id="categories">
                        @foreach (\App\Models\Category::all() as $category)
                            <div class="cont-categories">
                                <input type="checkbox" class="checkbox" id="category_{{$category->id}}" name="category_ids[]" value="{{ $category->id }}">
                                <label class="" for="category_{{ $category->id }}">{{ ucwords($category->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </section>


                    <section id="mode-challenge">
                        <h3 class="text-slate-800/70 dark:text-slate-100">Modes</h3>
                        <select id="mode" x-ref="mode" class="select">
                            @if (auth()->user()->hasRole(['admin', 'superadmin']))
                                @foreach (\App\Models\Mode::all() as $mode)
                                    <option value="{{ $mode->id }}">{{ ucwords($mode->denomination) }}</option>
                                @endforeach

                            @else
                                @php
                                    $trainingMode = \App\Models\Mode::where('denomination', 'training')->first();
                                @endphp
                                <option value="{{ ucwords($trainingMode->id) }}">{{ ucwords($trainingMode->denomination) }}</option>
                            @endif
                        </select>
                    </section>


                <section id="rank-challenge">
                    <h3 class="text-slate-800/70 dark:text-slate-100">Ranks</h3>
                        <select id="rank" x-ref="rank" class="select">
                            @foreach (\App\Models\Rank::all() as $rank)
                                <option value="{{ $rank->id }}">{{ ucwords($rank->name) }}</option>
                            @endforeach
                        </select>
                </section>


            </div>




            <section id="video-solution">
                <div class="text-slate-800/70 dark:text-slate-100">
                    <h3 class="text-slate-800/70 dark:text-slate-100">{{ __('Video Solution (Optional)') }}</h3>
                    <p class="text-sm">{{ __('Show a short youtube video solution to the users that passed or skipped the Challenge.') }}</p>
                </div>


                <div class="w-full md:w-3/4 py-5">
                    <x-jet-label for="videoname" value="{{ __('Youtube Video Solution Name') }}" />
                    <x-jet-input id="videoname" x-ref="videoname" type="text" name="videoname" class="mt-1 block w-full text-slate-700/70" value="{{ old('videoname') }}"/>
                    <p id="error-videoname" x-ref="errorvideoname" class="text-sm text-red-600"></p>
                </div>

                <div class="w-full md:w-3/4 py-5">
                    <x-jet-label for="videocode" value="{{ __('Youtube Video Solution Incrusted Code') }}" />
                    <x-jet-input id="videocode" x-ref="videocode" type="text" name="videocode" class="mt-1 block w-full text-slate-700/70" value="{{ old('videocode') }}"/>
                    <x-jet-input-error for="videocode" class="mt-2" id="error-videocode" />
                    <p id="error-videocode" x-ref="errorvideocode" class="text-sm text-red-600"></p>
                </div>
            </section>

            <div class="w-full flex justify-end">
                <x-jet-button id="create-btn">
                    CREATE
                </x-jet-button>
            </div>

        </div>



        <style>
            .ace_active-line {
                background-color: rgba(93, 93, 94, 0.103) !important;
            }

            .ace-solarized-light .ace_gutter  {
                background-color: rgba(180, 180, 180, 0.548) !important;
                color: gray !important;
            }

            .ace-solarized-light .ace_gutter-active-line {
                background-color: rgba(180, 180, 180, 0.548) !important;
            }

            .ace-monokai .ace_gutter {
                background-color: #1311116c !important;
                color: #bebbbb !important;
            }

            .ace-monokai .ace_gutter-active-line {
                background-color: rgba(36, 36, 36, 0.692) !important;
            }
        </style>

        <x-layout.dinamicflash type="error" name="createcodea"></x-layout.dinamicflash>


        <script>

            window.addEventListener('DOMContentLoaded', eDCL => {

                // CKEDITOR

                ClassicEditor.create(document.querySelector('#description'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic','|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                        ],
                    },
                })
                .then(editor => {
                    ckDescription = editor;
                })
                .catch( error => {
                    console.error( error );
                } );

                ClassicEditor.create(document.querySelector('#examples'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic','|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                        ],
                    },
                })
                .then(editor => {
                    ckExamples = editor;
                })
                .catch(error => console.error(error));

                ClassicEditor.create(document.querySelector('#notes'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic','|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                        ],
                    },
                })
                .then(editor => {
                    ckNotes = editor;
                })
                .catch(error => console.error(error));

                // ACE PANEL

                // Ace Editor Config
                const editor = ace.edit("code-editor");
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
                editor.setOption("enableLiveAutocompletion", true);
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

                // Select editor theme depending of the select layout theme.
                if (document.documentElement.classList.contains('dark')) {
                    ace.edit('code-editor').setTheme('ace/theme/monokai');
                } else {
                    ace.edit('code-editor').setTheme('ace/theme/solarized_light');
                }


                const solution = ace.edit("solution-editor");
                solution.setTheme("ace/theme/solarized_light"); // Theme: monokai | solarized_light
                solution.session.setMode("ace/mode/php"); // Set language parser
                //solution.setKeyboardHandler("ace"); // Keybinding: Ace
                solution.setFontSize("16px");
                solution.setOption("wrap", "free"); // Soft Wrap: View
                solution.setOption("cursorStyle", "ace"); // Estilo de cursor: Ace
                solution.setOption("foldStyle", "markbegin");
                solution.setOption("tabSize", 4); // Tabs spaces
                solution.setOption("scrollPastEnd", false); // Overscroll
                solution.setBehavioursEnabled(true); // Habilitar comportamientos
                solution.setOption("enableLiveAutocompletion", true);
                solution.setOption("wrapBehavioursEnabled", true); // Set wrapped content
                solution.setOption("enableAutoIndent", true); // Auto indentation
                solution.setOption("selectionStyle", "line"); // Select full line
                solution.setOption("highlightActiveLine", true); // Hightlight active line
                solution.setOption("showInvisibles", false); // Show tabs guide
                solution.setOption("displayIndentGuides", true); // Hightlight indent guides
                solution.setShowPrintMargin(true); // Show print margin
                solution.setOption("showGutter", true); // Show gutter (side panel)
                solution.setOption("showLineNumbers", true); // Show number lines
                solution.setOption("indentedSoftWrap", true); // Indent in soft wrap
                solution.setOption("highlightSelectedWord", true); // Hightlight selected word
                solution.setOption("useTextareaForIME", true); // Use textarea for IME
                solution.setOption("mergeUndoDeltas", "timed"); // Merge undo deltas

                // Select editor theme depending of the select layout theme.
                if (document.documentElement.classList.contains('dark')) {
                    ace.edit('solution-editor').setTheme('ace/theme/monokai');
                } else {
                    ace.edit('solution-editor').setTheme('ace/theme/solarized_light');
                }

                iodine = new Iodine();

                const rules = {
                    title: ['required', 'string', 'maxLength:255'],
                    description: ['rquired', 'string', 'maxLength:255'],
                    signature: ['required', 'string', 'maxLength:255'],
                    testclassname: ['required', 'string', 'maxLength:255'],
                };

                document.getElementById('title')
                    .addEventListener('blur', (eBlur) => {
                        let title =  document.getElementById('title').value;
                        let assert = iodine.assert(title, rules.title);
                        if (!assert.valid) {
                            document.getElementById('error-title').textContent = assert.error;
                        } else {
                            document.getElementById('error-title').textContent = '';
                        }
                    });

                document.getElementById('description')
                    .addEventListener('blur', (eBlur) => {
                        let description = document.getElementById('description').value;
                        let assert = iodine.assert(description, rules.description);
                        if (!assert.valid) {
                            document.getElementById('error-description').textContent = assert.error;
                        } else {
                            document.getElementById('error-description').textContent = '';
                        }
                    });

                document.getElementById('signature')
                    .addEventListener('blur', (eBlur) => {
                        let signature = document.getElementById('signature').value;
                        let assert = iodine.assert(signature, rules.signature);
                        if (!assert.valid) {
                            document.getElementById('error-signature').textContent = assert.error;
                        } else {
                            document.getElementById('error-signature').textContent = '';
                        }
                    });

                document.getElementById('testclassname')
                    .addEventListener('blur', (eBlur) => {
                        let testclassname = document.getElementById('testclassname').value;
                        let assert = iodine.assert(testclassname, rules.testclassname);
                        if (!assert.valid) {
                            document.getElementById('error-testclassname').textContent = assert.error;
                        } else {
                            document.getElementById('error-testclassname').textContent = '';
                        }
                    });


                document.getElementById('create-btn').addEventListener('click', (eClick) => {

                    let description = ckDescription.getData();
                    let examples = ckExamples.getData();
                    let notes = ckNotes.getData();
                    let code = ace.edit('code-editor').getValue().trim();
                    let solution = ace.edit('solution-editor').getValue().trim();

                    let categoriesIds = [...document.querySelectorAll('.checkbox')]
                        .filter(checkbox => checkbox.checked === true)
                        .map(checkbox => checkbox.id.split('_')[1]);

                    axios({
                        method: 'post',
                        url: '{{ route('mykatas.store') }}',
                        responseType: 'json',
                        data: {
                            title: document.getElementById('title').value,
                            description: description,
                            examples: examples,
                            notes: notes,
                            signature: document.getElementById('signature').value,
                            testclassname: document.getElementById('testclassname').value,
                            code: code,
                            solution: solution,
                            mode: document.getElementById('mode').value,
                            rank: document.getElementById('rank').value,
                            categories: categoriesIds,
                            videoname: document.getElementById('videoname').value,
                            videocode: document.getElementById('videocode').value,
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            window.location.reload();
                        } else {
                            $flash.show('createcode', 'error', response.data.flash);
                        }

                    })
                    .catch(error => {
                        if (error.response.data.errors?.title) {
                            document.getElementById('error-title').textContent = error.response.data.errors.title[0];
                        }

                        if (error.response.data.errors?.description) {
                            document.getElementById('error-description').textContent = error.response.data.errors.description[0];
                        } else {
                            document.getElementById('error-description').textContent = '';
                        }

                        if (error.response.data.errors?.examples) {
                            document.getElementById('error-examples').textContent = error.response.data.errors.examples[0];
                        } else {
                            document.getElementById('error-examples').textContent = '';
                        }

                        if (error.response.data.errors?.notes) {
                            document.getElementById('error-notes').textContent = error.response.data.errors.notes[0];
                        } else {
                            document.getElementById('error-notes').textContent = '';
                        }

                        if (error.response.data.errors?.signature) {
                            document.getElementById('error-signature').textContent = error.response.data.errors.signature[0];
                        } else {
                            document.getElementById('error-signature').textContent = '';
                        }

                        if (error.response.data.errors?.testclassname) {
                            document.getElementById('error-testclassname').textContent = error.response.data.errors.testclassname[0];
                        } else {
                            document.getElementById('error-testclassname').textContent = '';
                        }

                        if (error.response.data.errors?.videoname) {
                            document.getElementById('error-videoname').textContent = error.response.data.errors.videoname[0];
                        } else {
                            document.getElementById('error-videoname').textContent = '';
                        }

                        if (error.response.data.errors?.videocode) {
                            document.getElementById('error-vodeocode').textContent = error.response.data.errors.videocode[0];
                        } else {
                            document.getElementById('error-videocode').textContent = '';
                        }

                    });
                });

                let checkboxes = document.querySelectorAll('.checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', limitCheckboxes);
                });

                function limitCheckboxes() {
                    let checked = 0;
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                        checked++;
                        }
                    });
                    if (checked === 3) {
                        checkboxes.forEach(checkbox => {
                        if (!checkbox.checked) {
                            checkbox.disabled = true;
                        }
                        });
                    } else {
                        checkboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                        });
                    }
                }

            });

        </script>
    </x-layout.wrapper-secondary-panel>
</x-app-layout>

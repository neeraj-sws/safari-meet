<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ \App\Helpers\SettingHelper::get('site_name', config('app.name')) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/avif"
        href="{{ asset(\App\Helpers\SettingHelper::get('favicon', 'assets/images/WLogoLightgreen.svg')) }}">

    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">-->
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet">
    <!-- flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/app.css') }}?t={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Icon Picker CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/fontawesome-iconpicker@3.2.0/dist/css/fontawesome-iconpicker.min.css">

    <style>
        .iconpicker-popover.popover.fade.bottom.in {
            opacity: 9;
            !important
        }

        .modal {
            overflow-y: auto !important;
        }

        span.select2-selection.select2-selection--single {
            height: auto;
            border-color: #ced4da !important;
        }

        span.select2-selection__rendered {
            padding: 0.275rem 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0.275rem !important;
        }

        .select2-dropdown {
            z-index: 999999 !important;
        }
    </style>
    @livewireStyles
    @stack('styles')

</head>

<body>
    <div id="app">
        <div class="wrapper">
            @include('components.includes.agent.agent-header')
            @include('components.includes.agent.agent-sidebar')
            <div class="page-wrapper">
                <div class="page-content">
                    {{ $slot }}
                </div>
            </div>
        </div>


        @include('components.includes.agent.agent-footer')
    </div>

    @livewireScripts
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!---------------|| Js Files ||--------------->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
    <script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris/js/morris.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/nicEdit.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Icon Picker CSS -->
    <script src="https://cdn.jsdelivr.net/npm/fontawesome-iconpicker@3.2.0/dist/js/fontawesome-iconpicker.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/703e60ik4bbf0tgpid8nx2ir9yzwu22hdo6ab11waghkcofx/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    @include('components.includes.sweet-alert')
    @include('components.includes.select2')
    @include('components.includes.datepicker')

    @stack('scripts')
    <script>
        function initializeIconPicker() {

            document.querySelectorAll('.iconPicker').forEach(picker => {
                const $picker = $(picker);

                $picker.iconpicker('destroy');

                $picker.iconpicker().on('iconpickerSelected', function(e) {
                    const selectedIcon = e.iconpickerValue;
                    const wrapper = picker.closest('.icon-picker-wrapper');
                    const iconPreview = wrapper.querySelector('#iconPreview');
                    const fieldName = picker.getAttribute('data-field');
                    const pageId = picker.getAttribute('data-pageId');
                    if (iconPreview && fieldName) {
                        iconPreview.innerHTML = `<i class="${selectedIcon}"></i>`;
                        const componentElement = document.getElementById(pageId);
                        const componentId = componentElement?.getAttribute('wire:id');
                        // console.log(componentId);
                        if (componentId) {
                            // Livewire.find(componentId).set(fieldName,
                            //     `<i class="${selectedIcon}" aria-hidden="true"></i>`);
                            Livewire.find(componentId).dispatch('icon-selected', {
                                data: {
                                    field: fieldName,
                                    value: `<i class="${selectedIcon}" aria-hidden="true"></i>`
                                }
                            });
                        }
                    }
                });

                const iconValue = picker.closest('.icon-picker-wrapper')?.querySelector('#iconInput')?.value;
                if (iconValue) {
                    $picker.iconpicker('setIcon', iconValue);
                }

            });
        }

        window.addEventListener('initializeIconPicker', () => {
            setTimeout(() => initializeIconPicker(), 100);
        });

        window.addEventListener('iconPicker:reset', () => {
            document.querySelectorAll('.iconPicker').forEach(picker => {
                const $picker = $(picker);
                $picker.iconpicker('setIcon', '');
                picker.value = '';
                const wrapper = picker.closest('.icon-picker-wrapper');
                const iconPreview = wrapper.querySelector('#iconPreview');
                if (iconPreview) {
                    iconPreview.innerHTML = '';
                }
            });
        });

        window.addEventListener('iconPicker:update', (e) => {

            let newIcon = e.detail.value;
            const match = newIcon.match(/class="([^"]+)"/);
            if (match) {
                newIcon = match[1];
            }

            document.querySelectorAll('.iconPicker').forEach(picker => {
                const $picker = $(picker);
                const pageId = picker.getAttribute('data-pageId');
                $picker.iconpicker('setIcon', newIcon);
                picker.value = newIcon;

                const wrapper = picker.closest('.icon-picker-wrapper');
                const iconPreview = wrapper.querySelector('#iconPreview');
                if (iconPreview) {
                    iconPreview.innerHTML = `<i class="${newIcon}"></i>`;
                }

            });
        });
    </script>
    <script>
        window.addEventListener('init-datepicker', event => {
            const payload = event.detail[0];
            const selector = payload.selector;
            if (!selector) return;
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                if (el._flatpickr) {
                    el._flatpickr.destroy();
                }
                const instance = flatpickr(el, {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    defaultDate: el.value || null
                });

                el._flatpickr = instance;
            });
        });
    </script>

    <script>
        function initAllTinyMCEEditors() {
            document.querySelectorAll('textarea[data-editor][data-model]').forEach(el => {
                const id = el.id;
                const editorId = el.getAttribute("data-editor-id");
                const componentRoot = el.closest('[wire\\:id]');
                const componentId = componentRoot ? componentRoot.getAttribute('wire:id') : null;
                const uniqueKey = editorId.split('-').pop();
                if (tinymce.get(id)) {
                    tinymce.get(id).remove();
                }
                tinymce.init({
                    selector: `#${id}`,
                    autoresize_bottom_margin: 20,
                    menubar: false,
                    plugins: [
                        'advlist', 'autoresize', 'autolink', 'link', 'image', 'lists', 'charmap',
                        'preview', 'anchor',
                        'pagebreak', 'searchreplace', 'wordcount', 'visualblocks', 'visualchars',
                        'code',
                        'fullscreen', 'insertdatetime', 'media', 'table', 'emoticons', 'help'
                    ],
                    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                        'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                        'forecolor backcolor emoticons | help',
                    image_toolbar: 'alignleft aligncenter alignright | imageoptions',
                    menu: {
                        favs: {
                            title: 'My Favorites',
                            items: 'code visualaid | searchreplace | emoticons'
                        }
                    },
                    menubar: 'favs file edit view insert format tools table help',
                    // content_css: 'css/content.css',
                    image_advtab: true,
                    image_title: true,
                    automatic_uploads: true,
                    image_caption: true,
                    image_dimensions: true,
                    setup: function(editor) {
                        editor.on('change keyup', function() {
                            const content = editor.getContent();
                            const model = el.dataset.model;
                            if (componentId && model) {
                                Livewire.find(componentId)?.set('value', content);
                            }
                        });
                    }
                });
            });
        }

        window.addEventListener('init-tinymce', function() {
            setTimeout(() => initAllTinyMCEEditors(), 100);
        });
    </script>

    <script>
        function filterAndFormatInputs(inputElement, config = {}) {
            const {
                allowAlpha = false,
                    allowNumbers = false,
                    allowedSpecialChars = '',
                    capitalizeWords = false,
                    preserveCase = true,
                    trimSpaces = false,
                    maxLength = null
            } = config;

            const specials = allowedSpecialChars.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
            const allowedPattern = [
                allowAlpha ? 'a-zA-Z' : '',
                allowNumbers ? '0-9' : '',
                '\\s',
                specials
            ].join('');
            const regex = new RegExp(`[^${allowedPattern}]`, 'g');

            const start = inputElement.selectionStart;
            const end = inputElement.selectionEnd;
            const oldValue = inputElement.value;

            let value = oldValue.replace(regex, '');

            if (trimSpaces) {
                value = value.replace(/\s+/g, ' ').trim();
            }

            if (!preserveCase) {
                value = value.toLowerCase();
            }

            if (capitalizeWords && preserveCase && allowAlpha) {
                value = value.split(' ').map(word => {
                    return word.replace(/^[a-zA-Z]/, c => c.toUpperCase());
                }).join(' ');
            }

            if (maxLength && typeof maxLength === 'number') {
                value = value.substring(0, maxLength);
            }


            if (value !== oldValue) {
                inputElement.value = value;

                let newPos = start - (oldValue.length - value.length);
                newPos = Math.max(0, Math.min(value.length, newPos));
                inputElement.setSelectionRange(newPos, newPos);
            }
        }
    </script>
    @once
        <script>
            function updateTab(tab, subtab = null, subtabId = null) {
                const url = new URL(window.location);
                url.searchParams.set('tab', tab);

                if (subtab) {
                    url.searchParams.set('subtab', subtab);
                } else {
                    url.searchParams.delete('subtab');
                }

                window.history.pushState({}, '', url);

                // const component = Livewire.find(
                //     document.querySelector('[wire\\:id]').getAttribute('wire:id')
                // );

                // component.set('activeTab', tab);
                // if (subtab) {
                //     component.set('overviewActiveTabData', subtabId);
                //     component.set('overviewActiveTab', subtab);
                // }
            }
        </script>
    @endonce
</body>

</html>

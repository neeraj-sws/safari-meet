<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/full-forms.css') }}" v="{{ time() }}">

    {{-- <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
</head>

<body>
    {{ $slot }}


    @livewireScripts
    <!-- Script to JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @include('components.includes.sweet-alert')
     @include('components.includes.select2')
      @stack('scripts')

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
</body>

</html>

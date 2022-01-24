@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush

@push('clientCustomStyles')

{{-- font url --}}
{!! isset($clientSettings['font_url']) ? $clientSettings['font_url'] : config('global.default_font.family') !!}

<style>
    :root {
        --bg-1: {{ isset($clientSettings['colour_bg1']) ? $clientSettings['colour_bg1'] : config('global.client_settings.default_colours.bg1') }};
        --bg-2: {{ isset($clientSettings['colour_bg2']) ? $clientSettings['colour_bg2'] : config('global.client_settings.default_colours.bg2') }};
        --bg-3: {{ isset($clientSettings['colour_bg3']) ? $clientSettings['colour_bg3'] : config('global.client_settings.default_colours.bg3') }};

        --t-dark: {{ isset($clientSettings['colour_txt1']) ? $clientSettings['colour_txt1'] : config('global.client_settings.default_colours.txt1') }};
        --t-def: {{ isset($clientSettings['colour_txt2']) ? $clientSettings['colour_txt2'] : config('global.client_settings.default_colours.txt2') }};
        --t-light: {{ isset($clientSettings['colour_txt3']) ? $clientSettings['colour_txt3'] : config('global.client_settings.default_colours.txt3') }};
        --t-alt: {{ isset($clientSettings['colour_txt4']) ? $clientSettings['colour_txt4'] : config('global.client_settings.default_colours.txt4') }};

        --link-def: {{ isset($clientSettings['colour_link1']) ? $clientSettings['colour_link1'] : config('global.client_settings.default_colours.link1') }};
        --link-hf: {{ isset($clientSettings['colour_link2']) ? $clientSettings['colour_link2'] : config('global.client_settings.default_colours.link2') }};

        --but-light-1: {{ isset($clientSettings['colour_button1']) ? $clientSettings['colour_button1'] : config('global.client_settings.default_colours.button1') }};
        --but-light-2: {{ isset($clientSettings['colour_button2']) ? $clientSettings['colour_button2'] : config('global.client_settings.default_colours.button2') }};
        --but-dark-1: {{ isset($clientSettings['colour_button3']) ? $clientSettings['colour_button3'] : config('global.client_settings.default_colours.button3') }};
        --but-dark-2: {{ isset($clientSettings['colour_button4']) ? $clientSettings['colour_button4'] : config('global.client_settings.default_colours.button4') }};

    }

    .preview-canvas {
        {{ isset($clientSettings['font_family']) ? $clientSettings['font_family'] : config('global.default_font.family') }}
    }

</style>
@endpush

<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">

        @if ($isEmployer == 0)
            <li class="nav-item">
                <a class="nav-link @if ($activeTab == "vacancy-employer-details") active @endif @if($errors->hasany(['employer'])) error @endif" data-toggle="tab" href="#vacancy-employer-details" wire:click="updateTab('vacancy-employer-details')">Employer</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancy-details") active @endif @if($errors->hasany(['title', 'slug', 'role_type', 'region'])) error @endif" data-toggle="tab" href="#vacancy-details" wire:click="updateTab('vacancy-details')">Vacancy details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancy-image") active @endif @if($errors->hasany(['vacancyImage'])) error @endif" data-toggle="tab" href="#vacancy-image" wire:click="updateTab('vacancy-image')">Vacancy Image</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancy-content") active @endif" data-toggle="tab" href="#vacancy-content" wire:click="updateTab('vacancy-content')">Vacancy content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "videos") active @endif @if($errors->hasany(['relatedVideos.*'])) error @endif" data-toggle="tab" href="#videos" data-tab="videos" wire:key="videos-tab" wire:click="updateTab('videos')">Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "filter-settings") active @endif" data-toggle="tab" href="#filter" wire:click="updateTab('filter-settings')">Filter settings</a>
        </li>

        {{-- only "global admin" or "emlpoyers" cal allocate a vacancy to multiple clients--}}
        @if (isGlobalAdmin())
            <li class="nav-item">
                <a class="nav-link @if ($activeTab == "client-settings") active @endif" data-toggle="tab" href="#client" wire:click="updateTab('client-settings')">Client settings</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "preview") active @endif" data-toggle="tab" href="#client" wire:click="updateTab('vacancy-preview')">Preview</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @if ($isEmployer == 0)
            @include('livewire.admin.includes.vacancies.vacancy-employer-details')
        @endif

        @include('livewire.admin.includes.vacancies.vacancy-details')

        @include('livewire.admin.includes.vacancies.image')

        @include('livewire.admin.includes.vacancies.vacancy-content')

        @include('livewire.admin.includes.vacancies.videos')

        @include('livewire.admin.includes.vacancies.filter-settings')

        @if (isGlobalAdmin())
            @include('livewire.admin.includes.vacancies.client-settings')
        @endif

        @include('livewire.admin.includes.vacancies.preview')

    </div>

    @include('livewire.admin.includes.vacancies.submit')

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.vacancies.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>

    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-vacancy-image').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'vacancy_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        if (inputId == 'vacancy_image'){
            livewire.emit('make_vacancy_image', $url);
        }
    }

    /***************/


    tinymce.init({
        selector: 'textarea.tiny_vac_desc',
        menubar: false,
        paste_as_text: true,
        height: 400,
        custom_colors: false,
        plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media image nonbreaking',
            'save table directionality emoticons template paste'
        ],

        toolbar1: "bold italic underline strikethrough forecolor | alignleft aligncenter alignright alignjustify | formatselect",
        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image code | table | hr removeformat | subscript superscript | fullscreen",

        color_map: [
            '444444', 'Default',
            '777777', 'Gray',
            '865e9d', 'Corporate Purple',
            '489fdf', 'Blue',
            'ff7500', 'Orange',
            '78be21', 'Green',
            '28334a', 'Navy',
            'c3366f', 'Pink'
        ],

        link_assume_external_targets: 'https',
        relative_urls: false,
        document_base_url: '{{ Config::get('app.url') }}',
        file_picker_callback (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

            tinymce.activeEditor.windowManager.openUrl({
            url : '/file-manager/tinymce5',
            title : 'Laravel File manager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content, { text: message.text })
            }
            })
        },
        setup: function(editor) {
            editor.on('blur', function(e) {
                focusedElement = document.activeElement;
                //console.log(focusedElement.getAttribute('data-tab'));
                if (focusedElement.getAttribute('data-tab')){
                    @this.set('activeTab', focusedElement.getAttribute('data-tab'));
                }

                @this.set('description', tinymce.get("description").getContent());
            });
        }
    });

</script>
@endpush

<div>

    <form wire:submit.prevent="submit">

        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    {!! Form::label('page_title', 'Page Title'); !!}
                    {!! Form::text('page_title', null, array('placeholder' => 'Page Title','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'title')) !!}
                    @error('title') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    {!! Form::label('slug', 'URL'); !!}
                    {{ $this->baseUrl }}{!! Form::text('slug', null, array('placeholder' => 'URL','class' => 'form-control', 'maxlength' => 255, 'id' => 'slug', 'wire:model.lazy' => 'slug')) !!}
                    @error('slug') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group @error('lead') has-error @enderror">
                    @error('lead') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('lead', 'Lead Paragraph'); !!}
                    {!! Form::textarea('lead', (!isset($lead)) ? null : $lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
                    => 'lead')) !!}
                </div>

                <div class="form-group" wire:ignore>
                    {!! Form::label('body', 'Page body text'); !!}
                    {!! Form::textarea('body', (!isset($body)) ? null : $body,
                        array('placeholder' => 'Page body text','class' => 'form-control tiny_body', 'cols' => 50, 'rows' => 10, 'maxlength' => 999,
                        'wire:model.defer' => 'body')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('display_in_header_title', 'Display in Header and Footer'); !!}{{$displayInHeader}}
                    <div class="form-check">
                        {!! Form::checkbox('display_in_header', 'Y', $displayInHeader, ['class' => 'form-check-input', 'id' => 'display_in_header', 'wire:model.defer' => 'displayInHeader' ]) !!}
                        <label class="form-check-label" for="display_in_header">Display in Header and Footer</label>
                    </div>
                </div>




                <div class="form-group">
                    @error('banner') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('banner', 'Banner Image'); !!}
                    <div class="input-group">
                    {!! Form::text('banner', null, array('placeholder' => 'Banner Image','class' => 'form-control', 'maxlength' => 255, 'id' => "banner_image", 'wire:model' => 'banner' )) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image-banner">Select</button>
                    </div>
                    </div>
                    <div class="article-image-preview">
                        <img src="{{ $bannerOriginal }}">
                    </div>
               {{--      <div class="article-image-preview">
                        <img src="{{ $bannerImagePreview }}">
                    </div> --}}
                </div>

            </div>
        </div>





        @if ($errors->any())
        <div class="row">
            <div class="col-lg-8">
                <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>There are some errors in your article.
                </div>
            </div>
        </div>
        @endif


        @if (Session::has('fail'))
        <div class="row">
            <div class="col-lg-8">
                <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>Your data could not be saved - Please log
                    back in.</div>
            </div>
        </div>
        @endif



        <div class="row">
            <button type="button" wire:click.prevent="store()" class="btn mydir-button mr-2">Save And Exit</button>
            <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make
                Live</button>
        </div>

    </form>

</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.1.0/dist/livewire-sortable.js"></script>
@endpush


@push('scripts')
<script>

    // input
    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-banner').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'banner_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });


    // set file link
    function fmSetLink($url) {
        if (inputId == 'banner_image'){
            livewire.emit('make_banner_image', $url);
        }
    }



    tinymce.init({
        selector: 'textarea.tiny_body',
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


        relative_urls: true,
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
                field_id = tinymce.activeEditor.id;
                @this.set(field_id, tinymce.get(field_id).getContent());
            });
        }
    });

</script>
@endpush

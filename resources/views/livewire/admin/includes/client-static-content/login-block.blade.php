<div id="login-box" class="tab-pane @if ($activeTab == "login-box") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">


            <div class="form-group">
                @error('loginBoxBanner') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('login_box_banner', 'Login box image'); !!}
                <div class="input-group">
                    {!! Form::text('login_box_banner', null, array('placeholder' => 'Banner Image','class' => 'form-control', 'maxlength' => 255, 'id' => "login_box_banner_image", 'wire:model' => 'loginBoxBanner' )) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image-banner">Select</button>
                    </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $loginBoxBannerOriginal }}">
                </div>

            </div>


            <div class="form-group">

                @error('login_box_title') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('login_box_title', 'Login heading'); !!}
                {!! Form::text('login_box_title', (empty($login_box_title)) ? null : $login_box_title, array('placeholder' => 'Login heading', 'class' => 'form-control', 'maxlength' => 200, 'wire:model.defer' => 'login_box_title')) !!}

            </div>


            <div class="form-group">

                @error('login_box_intro') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('login_box_intro', 'Login introduction'); !!}
                {!! Form::textarea('login_box_intro', (empty($login_box_intro)) ? null : $login_box_intro, array('placeholder' => 'Login introduction', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy' => 'login_box_intro')) !!}

            </div>

        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush

@push('scripts')
<script>

    /*****************/

    // input
    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-banner').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'login_box_banner_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        if (inputId == 'login_box_banner_image'){
            livewire.emit('make_login_box_banner_image', $url);
        }
    }


</script>
@endpush

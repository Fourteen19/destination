@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Client Branding</h1>
            <p class="mydir-instructions">This screen allows you to control the colours, fonts and logo used within a client system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <form wire:submit.prevent="submit">

        @livewire('admin.client-settings-form')

    </form>






{{-- <!-- Tab panes -->
<div class="tab-content">

    <div id="colours" class="tab-pane active">
        <div class="row">
            <div class="col-lg-6">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-palette mr-2"></i>Background and block colours</h2>

            <div class="form-group row">
                <label for="bg_colour_1" class="col-sm-3 col-form-label">Background #1</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="bg_colour_1">
                <small>This colour is used as the primary brand colour e.g. the background for the main site heading.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="bg_colour_2" class="col-sm-3 col-form-label">Background #2</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="bg_colour_2">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>
            <div class="form-group row mb-5">
                <label for="bg_colour_3" class="col-sm-3 col-form-label">Background #3</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="bg_colour_3">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-swatchbook mr-2"></i>Text colours</h2>

            <div class="form-group row">
                <label for="t_def" class="col-sm-3 col-form-label">Default body text</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="t_def">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="t_dark" class="col-sm-3 col-form-label">Headings and dark text</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="t_dark">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="t_light" class="col-sm-3 col-form-label">Light text</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="t_light">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>
            <div class="form-group row mb-5">
                <label for="t_alt" class="col-sm-3 col-form-label">Alternate text</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="t_alt">
                <small>Support text explaining usage tbc...</small>
                </div>
            </div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-link mr-2"></i>Link colours</h2>

            <div class="form-group row">
                <label for="link_def" class="col-sm-3 col-form-label">Default link colour</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="link_def">
                <small>This is the colour a standard link will appear within the body text.</small>
                </div>
            </div>
            <div class="form-group row mb-5">
                <label for="link_hf" class="col-sm-3 col-form-label">Link colour on hover/focus</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="link_hf">
                <small>This is the colour a standard link will appear when in the hover or focus state.</small>
                </div>
            </div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-mouse-pointer mr-2"></i>Button colours</h2>

            <div class="form-group row">
                <label for="but_light_1" class="col-sm-3 col-form-label">Button text #1</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="but_light_1">
                <small>This is the colour of standard button text.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="but_light_2" class="col-sm-3 col-form-label">Button text #2</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="but_light_2">
                <small>This is the alternative colour of standard button text.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="but_bg_1" class="col-sm-3 col-form-label">Button background #1</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="but_bg_1">
                <small>This is the colour of standard button text.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="but_bg_2" class="col-sm-3 col-form-label">Button background #2</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="but_bg_2">
                <small>This is the alternative colour of standard button text.</small>
                </div>
            </div>

            </div>
        </div>
    </div>


    <div id="logo" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-6">

            <label>System logo</label>
            <div class="custom-file mb-4">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select file</label>
            <small>Support text explaining usage tbc...</small>
            </div>

            </div>
        </div>
    </div>

    <div id="fonts" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    <label for="font_address">Font address</label>
                    <input placeholder="Example https://use.typekit.net/ruw0ofr.css" class="form-control" maxlength="255" wire:model="font_address" name="font_address" type="text" id="font_address">
                    <small><b>IMPORTANT:</b> Your chosen font must have options for weights at 400 and 700. It is also recommended that the font-swap option is set.</small>
                </div>

            </div>
        </div>
    </div>



</div>

<div class="row">
    <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>
</div>

</form> --}}



    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.clients.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>

@endsection

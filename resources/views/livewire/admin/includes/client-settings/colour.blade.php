<div id="colours" class="tab-pane @if ($activeTab == "colours") active @else fade @endif"  wire:key="colours-pane">
    <div class="row">
        <div class="col-lg-6">

        <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-palette mr-2"></i>Background and block colours</h2>

        <div class="form-group row">
            @error('colour_bg1') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_bg1" class="col-sm-3 col-form-label">Background #1</label>
            <div class="col-sm-9">
                <div class="input-group" wire:ignore>
                    {!! Form::text('colour_bg1', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 9, 'id' => 'colour_bg1', 'wire:model.defer' => 'colour_bg1', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="bg1" class="colour-picker" data-color="{{$colour_bg1}}" data-colorid="colour_bg1" style="width:40px;height:20px;background:{{$colour_bg1}}"></div></span>
                    </span>
                </div>
                <small>This colour is used as the primary brand colour e.g. the background for the main site heading etc.</small>
            </div>
        </div>
        <div class="form-group row">
            @error('colour_bg2') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_bg2" class="col-sm-3 col-form-label">Background #2</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_bg2', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 9, 'id' => 'colour_bg2', 'wire:model.defer' => 'colour_bg2', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="bg2" class="colour-picker" data-color="{{$colour_bg2}}" data-colorid="colour_bg2" style="width:40px;height:20px;background:{{$colour_bg2}}"></div></span>
                    </span>
                </div>
                <small>This colour is generally used as the secondary brand colour e.g. the background for the main site footer etc.</small>
            </div>
        </div>
        <div class="form-group row mb-5">
            @error('colour_bg3') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_bg3" class="col-sm-3 col-form-label">Background #3</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_bg3', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_bg3', 'wire:model.defer' => 'colour_bg3', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="bg3" class="colour-picker" data-color="{{$colour_bg3}}" data-colorid="colour_bg3" style="width:40px;height:20px;background:{{$colour_bg3}}"></div></span>
                    </span>
                </div>
                <small>This colour is generally used as a third brand colour e.g. the background for the login prompt box on the homepage etc.</small>
            </div>
        </div>

        <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-swatchbook mr-2"></i>Text colours</h2>
        <div class="form-group row">
            @error('colour_txt2') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_txt2" class="col-sm-3 col-form-label">Default body text</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_txt2', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_txt2', 'wire:model.defer' => 'colour_txt2', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="txt2" class="colour-picker" data-color="{{$colour_txt2}}" data-colorid="colour_txt2" style="width:40px;height:20px;background:{{$colour_txt2}}"></div></span>
                    </span>
                </div>
                <small>This colour is used as the default text colour through out the front-end.</small>
            </div>
        </div>
        <div class="form-group row">
            @error('colour_txt1') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_txt1" class="col-sm-3 col-form-label">Headings and dark text</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_txt1', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_txt1', 'wire:model.defer' => 'colour_txt1', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="txt1" class="colour-picker" data-color="{{$colour_txt1}}" data-colorid="colour_txt1" style="width:40px;height:20px;background:{{$colour_txt1}}"></div></span>
                    </span>
                </div>
                
                <small>This colour is used for all headings and ephsis text through out the front-end.</small>
            </div>
        </div>
        
        <div class="form-group row">
            @error('colour_txt3') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_txt3" class="col-sm-3 col-form-label">Light text</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_txt3', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_txt3', 'wire:model.defer' => 'colour_txt3', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="txt3" class="colour-picker" data-color="{{$colour_txt3}}" data-colorid="colour_txt3" style="width:40px;height:20px;background:{{$colour_txt3}}"></div></span>
                    </span>
                </div>
                <small>This colour is used when using lighter text on a dark background. Ensure the contrast ratio of your text is appropriate by choosing a colour that is light enough.</small>
            </div>
        </div>
        <div class="form-group row mb-5">
            @error('colour_txt4') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_txt4" class="col-sm-3 col-form-label">Alternate text</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_txt4', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_txt4', 'wire:model.defer' => 'colour_txt4', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="txt4" class="colour-picker" data-color="{{$colour_txt4}}" data-colorid="colour_txt4" style="width:40px;height:20px;background:{{$colour_txt4}}"></div></span>
                    </span>
                </div>
                <small>This colour is used only sparingly through out the system when an additional colour is required to provide an alternative option to aid visibility.</small>
            </div>
        </div>

        <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-link mr-2"></i>Link colours</h2>

        <div class="form-group row">
            @error('colour_link1') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="link_def" class="col-sm-3 col-form-label">Default link colour</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_link1', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_link1', 'wire:model.defer' => 'colour_link1', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="link1" class="colour-picker" data-color="{{$colour_link1}}" data-colorid="colour_link1" style="width:40px;height:20px;background:{{$colour_link1}}"></div></span>
                    </span>
                </div>
                <small>This is the colour a standard link will appear within the body text.</small>
            </div>
        </div>
        <div class="form-group row mb-5">
            @error('colour_link2') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_link2" class="col-sm-3 col-form-label">Link colour on hover/focus</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_link2', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_link2', 'wire:model.defer' => 'colour_link2', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="link2" class="colour-picker" data-color="{{$colour_link2}}" data-colorid="colour_link2" style="width:40px;height:20px;background:{{$colour_link2}}"></div></span>
                    </span>
                </div>
                <small>This is the colour a standard link will appear when in the hover or focus state.</small>
            </div>
        </div>

        <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-mouse-pointer mr-2"></i>Button colours</h2>

        <div class="form-group row">
            @error('colour_button2') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_button2" class="col-sm-3 col-form-label">Button text #1</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_button1', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_button1', 'wire:model.defer' => 'colour_button1', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="button1" class="colour-picker" data-color="{{$colour_button1}}" data-colorid="colour_button1" style="width:40px;height:20px;background:{{$colour_button1}}"></div></span>
                    </span>
                </div>
                <small>This is the colour of standard button text.</small>
            </div>
        </div>
        <div class="form-group row">
            @error('colour_button2') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="but_light_2" class="col-sm-3 col-form-label">Button text #2</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_button2', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_button2', 'wire:model.defer' => 'colour_button2', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="button2" class="colour-picker" data-color="{{$colour_button2}}" data-colorid="colour_button2" style="width:40px;height:20px;background:{{$colour_button2}}"></div></span>
                    </span>
                </div>
                <small>This is the alternative colour of standard button text.</small>
            </div>
        </div>
        <div class="form-group row">
            @error('colour_button3') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_button3" class="col-sm-3 col-form-label">Button background #1</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_button3', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_button3', 'wire:model.defer' => 'colour_button3', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="button3" class="colour-picker" data-color="{{$colour_button3}}" data-colorid="colour_button3" style="width:40px;height:20px;background:{{$colour_button3}}"></div></span>
                    </span>
                </div>
                <small>This is the background colour of standard button.</small>
            </div>
        </div>
        <div class="form-group row">
            @error('colour_button4') <span class="text-danger error">{{ $message }}</span>@enderror
            <label for="colour_button4" class="col-sm-3 col-form-label">Button background #2</label>
            <div class="col-sm-9" wire:ignore>
                <div class="input-group">
                    {!! Form::text('colour_button4', null, array('placeholder' => '', 'class' => 'form-control', 'maxlength' => 7, 'id' => 'colour_button4', 'wire:model.defer' => 'colour_button4', 'readonly' )) !!}
                    <span class="input-group-append">
                        <span class="input-group-text"><div id="button4" class="colour-picker" data-color="{{$colour_button4}}" data-colorid="colour_button4" style="width:40px;height:20px;background:{{$colour_button4}}"></div></span>
                    </span>
                </div>
                <small>This is the alternative background colour of buttons.</small>
            </div>
        </div>

        </div>
    </div>

</div>


@push('scripts')
<script>

    {{-- loops through the Livewire `$js_colour_picker_names` variable --}}
    @foreach($js_colour_picker_names as $js_colour_picker_name)

        // Create a new Picker instance and set the parent element.
        // By default, the color picker is a popup which appears when you click the parent.
        window['parent_{{$js_colour_picker_name}}'] = document.querySelector('#{{$js_colour_picker_name}}');

        var picker = new Picker({
            parent: window['parent_{{$js_colour_picker_name}}'],
            popup: 'right',
            color: window['parent_{{$js_colour_picker_name}}'].style.background,
            editorFormat: 'rgb',
            onChange: function(color) {

            },
            onOpen: function(color) {

            },
            onDone: function(color) {
                $("#"+window['parent_{{$js_colour_picker_name}}'].dataset.colorid).val(color.hex);
                window['parent_{{$js_colour_picker_name}}'].style.background = color.rgbaString;
                @this.set('colour_{{$js_colour_picker_name}}', color.hex);
            },
        });

    @endforeach

</script>
@endpush


<div id="fonts" class="tab-pane @if ($activeTab == "fonts") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="font_address">Font address</label>
                {!! Form::textarea('font_url', null, array('placeholder' => 'Example https://use.typekit.net/ruw0ofr.css', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'id' => 'font_url', 'wire:model.defer' => 'font_url')) !!}
                <small><b>IMPORTANT:</b> Your chosen font must have options for weights at 400 and 700. It is also recommended that the font-swap option is set.</small>
            </div>

            <div class="form-group">
                <label for="font_address">Font family</label>
                {!! Form::text('font_family', null, array('placeholder' => 'Example font-family: proxima-nova,sans-serif;', 'class' => 'form-control', 'maxlength' => 255, 'id' => 'font_family', 'wire:model.defer' => 'font_family')) !!}
                <small><b>IMPORTANT:</b> Your chosen font must have options for weights at 400 and 700. It is also recommended that the font-swap option is set.</small>
            </div>

        </div>
    </div>
</div>

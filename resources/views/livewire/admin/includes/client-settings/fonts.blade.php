<div id="fonts" class="tab-pane @if ($activeTab == "fonts") active @else fade @endif">
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

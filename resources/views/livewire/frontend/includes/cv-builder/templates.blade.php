<div id="templates" class="tab-pane @if ($activeTab == "templates") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group" wire:ignore>
                {!! Form::label('template', 'Template'); !!}
                <select class="form-control form-control-lg" name="template" wire:model="template">
                    <option value="1">Template 1</option>
                    <option value="2">Template 2</option>
                    <option value="3">Template 3</option>
                </select>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('references')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Previous</button>
        </div>
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('preview')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
        </div>
    </div>

</div>

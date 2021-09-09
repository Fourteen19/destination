<div id="templates" class="tab-pane @if ($activeTab == "templates") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group" wire:ignore>

                <input class="form-check-input mt-2" type="radio" name="template" id="template[1]" value="1" wire:model="template" wire.key="template_1">Template 1
                <input class="form-check-input mt-2" type="radio" name="template" id="template[2]" value="2" wire:model="template" wire.key="template_2">Template 2
                <input class="form-check-input mt-2" type="radio" name="template" id="template[3]" value="3" wire:model="template" wire.key="template_3">Template 3
                <input class="form-check-input mt-2" type="radio" name="template" id="template[4]" value="4" wire:model="template" wire.key="template_4">Template 4
                <input class="form-check-input mt-2" type="radio" name="template" id="template[5]" value="5" wire:model="template" wire.key="template_5">Template 5

       {{--          {!! Form::label('template', 'Template'); !!}
                <select class="form-control form-control-lg" name="template" wire:model="template">
                    <option value="1">Template 1</option>
                    <option value="2">Template 2</option>
                    <option value="3">Template 3</option>
                </select> --}}

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

<div id="vacancy-content" class="tab-pane px-0 @if ($activeTab == "vacancy-content") active @else fade @endif" wire:key="vacancy-content-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group @error('lead_para') has-error @enderror">
                @error('lead_para') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('lead', 'Lead Paragraph'); !!}
                {!! Form::textarea('lead', (!isset($vacancy->lead_para)) ? null : $vacancy->lead_para, array('placeholder' => 'Lead Paragraph', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'lead_para')) !!}
            </div>

            <div wire:ignore>
                <div class="form-group">
                @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('description', 'Vacancy description text'); !!}
                {!! Form::textarea('description', (!isset($vacancy->text)) ? null : $vacancy->text, array('placeholder' => 'Vacancy description text', 'class' => 'form-control tiny_vac_desc', 'wire:model.defer' => 'description')) !!}
                </div>
            </div>

            <div wire:ignore>
                <div class="form-group">
                @error('entry_requirements') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('entry_requirements', 'Vacancy entry requirements text'); !!}
                {!! Form::textarea('entry_requirements', (!isset($vacancy->entry_requirements)) ? null : $vacancy->entry_requirements, array('placeholder' => 'Vacancy entry requirements text', 'class' => 'form-control tiny_vac_entry_requirements', 'wire:model.defer' => 'entry_requirements')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('vac_map', 'Google Maps Embed code') !!}
                {!! Form::textarea('vac_map', $this->vac_map, array('placeholder' => 'Map URL i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 5000, 'wire:model.defer' => 'vac_map' )) !!}
                <div class="mt-3"><small>(To embed a map from Google Maps - 1) Click on the 'Share' option in Google Maps for the selected map, 2) Select the 'Embed a map' tab and click 'Copy HTML', 3) Paste the code in the field above.)</small></div>
            </div>

        </div>
    </div>
</div>

<div id="vacancy-content" class="tab-pane">
    <div class="row">
        <div class="col-lg-6">


            <div class="form-group @error('lead_para') has-error @enderror">
                @error('lead_para') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('lead', 'Lead Paragraph'); !!}
                {!! Form::textarea('lead', (!isset($vacancy->lead_para)) ? null : $vacancy->lead_para, array('placeholder' => 'Lead Paragraph', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer'
                => 'lead_para')) !!}
            </div>

            <div wire:ignore>
                <div class="form-group">
                @error('vac_desc') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('vac_desc', 'Vacancy description text'); !!}
                {!! Form::textarea('vac_desc', (!isset($vacancy->text)) ? null : $vacancy->text, array('placeholder' => 'Vacancy description text', 'class' => 'form-control tiny_vac_desc', 'wire:model.defer' => 'vac_desc')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('vac_vid', 'Video URL'); !!}
                {!! Form::text('vac_vid', $this->title, array('placeholder' => 'Video URL i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'vac_vid' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('vac_map', 'Map URL'); !!}
                {!! Form::text('vac_map', $this->title, array('placeholder' => 'Map URL i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'vac_map' )) !!}
            </div>


            <label>Vacancy Image</label>
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select image</label>
            </div>
        </div>
    </div>
    </div>

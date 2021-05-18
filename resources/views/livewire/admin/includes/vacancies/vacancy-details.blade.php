<div id="vacancy-details" class="tab-pane active">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('vacancy_title', 'Vacancy Title'); !!}
                {!! Form::text('vacancy_title', $this->title, array('placeholder' => 'Vacancy Title','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'title' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_name', 'Contact Name'); !!}
                {!! Form::text('contact_name', $this->title, array('placeholder' => 'Contact Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_number', 'Contact Number'); !!}
                {!! Form::text('contact_number', $this->title, array('placeholder' => 'Contact Number','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_number' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_email', 'Contact Email'); !!}
                {!! Form::text('contact_email', $this->title, array('placeholder' => 'Contact Email','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_email' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_link', 'Contact Link'); !!}
                {!! Form::text('contact_link', $this->title, array('placeholder' => 'Contact Link','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_link' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('employer_name', 'Employer Name'); !!}
                {!! Form::text('employer_name', $this->title, array('placeholder' => 'Employer Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'employer_name' )) !!}
            </div>

            <label>Employer Logo</label>
                <div class="custom-file mb-4">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Select image</label>
            </div>

            <div class="form-group">
            <label for="role_type">Role Type</label>
            <select class="form-control" wire:model.lazy="role_type" id="role_type" name="role_type">
                <option value="Please select">Please select</option>
                <option value="Full Time">Full Time</option>
                <option value="Part Time">Part Time</option>
                <option value="Apprenticeship">Apprenticeship</option>
            </select>
            </div>

            <div class="form-group">
            <label for="area">Area</label>
            <select class="form-control" wire:model.lazy="area" id="area" name="area">
                <option value="Please select">Please select</option>
                <option value="Area 1">Area 1</option>
                <option value="Area 2">Area 2</option>
                <option value="Area 3">Area 3</option>
            </select>
            </div>

            <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" wire:model.lazy="category" id="category" name="category">
                <option value="Please select">Please select</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
            </select>
            </div>

            <div class="form-group">
                {!! Form::label('apply_link', 'Apply Online Link'); !!}
                {!! Form::text('apply_link', $this->title, array('placeholder' => 'Apply Online Link i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'apply_link' )) !!}
            </div>


        </div>
    </div>
</div>

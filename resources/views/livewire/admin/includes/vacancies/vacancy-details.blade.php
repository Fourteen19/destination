<div id="vacancy-details" class="tab-pane active">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="vacancy_title">Vacancy Title 2</label>
                <input placeholder="Vacancy Title" class="form-control" maxlength="255" wire:model="vacancy_title" name="vacancy_title" type="text" id="vacancy_title">
            </div>

            <div class="form-group">
                <label for="contact_name">Contact Name</label>
                <input placeholder="Contact Name" class="form-control" maxlength="255" wire:model="contact_name" name="contact_name" type="text" id="contact_name">
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input placeholder="Contact Number" class="form-control" maxlength="255" wire:model="contact_number" name="contact_number" type="tel" id="contact_number">
            </div>

            <div class="form-group">
                <label for="contact_email">Contact Email</label>
                <input placeholder="Contact Email" class="form-control" maxlength="255" wire:model="contact_email" name="contact_email" type="email" id="contact_email">
            </div>

            <div class="form-group">
                <label for="contact_link">Contact Link</label>
                <input placeholder="Contact Link" class="form-control" maxlength="255" wire:model="contact_link" name="contact_link" type="url" id="contact_link">
            </div>

            <div class="form-group mb-3">
                <label for="employer_name">Employer Name</label>
                <input placeholder="Employer Name" class="form-control" maxlength="255" wire:model="employer_name" name="employer_name" type="text" id="employer_name">
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
                <label for="apply_link">Apply Online Link</label>
                <input placeholder="Apply Online Link i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="apply_link" name="apply_link" type="url" id="apply_link">
            </div>

        </div>
    </div>
</div>

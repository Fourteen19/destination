@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Create Vacancy</h1>
            <p class="mydir-instructions">From this screen you can enter all the details required to create a vacancy within the system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#vacancy-details">Vacancy details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#vacancy-content">Vacancy content</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#filter">Filter settings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#client">Client settings</a>
        </li>
    </ul>

    <!-- Tab panes -->
<div class="tab-content">

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

<div id="vacancy-content" class="tab-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
            <label for="vac_lp">Lead Paragraph</label>
            <textarea placeholder="Lead Paragraph" class="form-control" cols="40" rows="5" wire:model.lazy="vac_lp" name="vac_lp" id="vac_lp"></textarea>
            </div>

            <div wire:ignore>
            <div class="form-group">
            <label for="vac_desc">Vacancy description text</label>
            <textarea placeholder="Vacancy description text" class="form-control tiny_body" maxlength="999" wire:model.lazy="vac_desc" name="vac_desc" cols="50" rows="10" id="vac_desc"></textarea>
            </div>
            </div>

            <div class="form-group">
                <label for="vac_vid">Video URL</label>
                <input placeholder="Video URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="vac_vid" name="vac_vid" type="url" id="vac_vid">
            </div>

            <div class="form-group mb-4">
                <label for="vac_map">Map URL</label>
                <input placeholder="Map URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="vac_map" name="vac_map" type="url" id="vac_map">
            </div>

            <label>Vacancy Image</label>
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select image</label>
            </div>
        </div>
    </div>
</div>

<div id="filter" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-8">

            Standard article filter settings

        </div>
    </div>
</div>

<div id="client" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-8">

            Set which clients see this - all or just one?

        </div>
    </div>
</div>



</div>

<div class="row">
<button type="button" class="btn mydir-button mr-2">Save And Exit</button>
<button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>
</div>

</form>

<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            <a class="mydir-action" href="{{ route('admin.vacancies.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>

@endsection

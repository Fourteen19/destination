@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Teaching Resource</h1>
            <p class="mydir-instructions">From this screen you can edit the details for the selected teaching resource.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

   <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="filename">File name</label>
                <input placeholder="Vacancy Title" class="form-control" maxlength="255" wire:model="filename" name="filename" type="text" id="filename">
            </div>

            <div class="form-group">
            <label for="clients">Select Clients</label>
            <select class="form-control" wire:model.lazy="clients" id="clients" name="clients">
                <option value="All">All</option>
                <option value="Client name 1">Client name 1</option>
                <option value="Client name 2">Client name 2</option>
                <option value="Client name 3">Client name 3</option>
            </select>
            </div>

            <label>Upload file</label>
            <div class="custom-file mb-4">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select file</label>
            </div>

            <div class="form-group">
            <label for="description">Description</label>
            <textarea placeholder="Description" class="form-control" cols="40" rows="5" wire:model.lazy="description" name="description" id="description"></textarea>
            </div>

            <div class="form-group">
                <label for="uploader">Uploaded by</label>
                <input placeholder="Admin name" class="form-control" maxlength="255" wire:model="uploader" name="uploader" type="text" id="uploader" readonly>
            </div>

            <div class="form-group">
                <label for="uploaded">Uploaded date</label>
                <input placeholder="Date of upload" class="form-control" maxlength="255" wire:model="uploaded" name="uploaded" type="text" id="uploaded" readonly>
            </div>
        </div>
    </div>


<div class="row">
<button type="button" class="btn mydir-button mr-2">Save And Exit</button>
</div>

</form>

<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            <a class="mydir-action" href="{{ route('admin.resources.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>


@endsection

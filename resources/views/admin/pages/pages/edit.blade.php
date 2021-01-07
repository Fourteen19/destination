@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Public Page</h1>
            <p class="mydir-instructions">Use this screen to edit the selected information page on the public website. This should not be used for article or user content.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

   <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="page_title">Page Title</label>
                <input placeholder="Page Title" class="form-control" maxlength="255" wire:model="page_title" name="page_title" type="text" id="page_title">
            </div>

            <div class="form-group">
            <label for="lead">Lead Paragraph</label>
            <textarea placeholder="Lead Paragraph" class="form-control" cols="40" rows="5" wire:model.lazy="lead" name="lead" id="lead"></textarea>
            </div>

            <div wire:ignore>
            <div class="form-group">
            <label for="page_body">Page body text</label>
            <textarea placeholder="Page body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="page_body" name="page_body" cols="50" rows="10" id="page_body"></textarea>
            </div>
            </div>

            <label>Banner image</label>
            <div class="custom-file mb-4">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select file</label>
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
            <a class="mydir-action" href="{{ route('admin.pages.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>

@endsection

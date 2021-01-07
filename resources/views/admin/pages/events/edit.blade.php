@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Event</h1>
            <p class="mydir-instructions">From this screen you can edit the details for the selected event.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#event-details">Event details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#event-content">Event content</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#links">Links</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#downloads">Downloads</a>
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

<div id="event-details" class="tab-pane active">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="event_title">Event Title</label>
                <input placeholder="Event Title" class="form-control" maxlength="255" wire:model="event_title" name="event_title" type="text" id="event_title">
            </div>

            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input placeholder="Event Date" class="form-control" maxlength="255" wire:model="event_date" name="event_date" type="text" id="event_date">
            </div>

            <div class="form-group">
                <label for="event_start">Event Start Time</label>
                <input placeholder="Event Start Time" class="form-control" maxlength="255" wire:model="event_start" name="event_start" type="text" id="event_start">
            </div>

            <div class="form-group">
                <label for="event_end">Event End Time</label>
                <input placeholder="Event End Time" class="form-control" maxlength="255" wire:model="event_end" name="event_end" type="text" id="event_end">
            </div>

            <div class="form-group">
                <label for="venue_name">Venue Name</label>
                <input placeholder="Venue Name" class="form-control" maxlength="255" wire:model="venue_name" name="venue_name" type="text" id="venue_name">
            </div>

            <div class="form-group">
                <label for="town">Town / City</label>
                <input placeholder="Venue Name" class="form-control" maxlength="255" wire:model="town" name="town" type="text" id="town">
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
                <label for="booking_link">Booking Link</label>
                <input placeholder="Booking Link" class="form-control" maxlength="255" wire:model="booking_link" name="booking_link" type="url" id="booking_link">
            </div>

            

        </div>
    </div>
</div>

<div id="event-content" class="tab-pane">
    <div class="row">
        <div class="col-lg-6">

            <label>Banner image</label>
            <div class="custom-file mb-4">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select image</label>
            </div>
            
            <div class="form-group">
            <label for="ev_lp">Lead Paragraph</label>
            <textarea placeholder="Lead Paragraph" class="form-control" cols="40" rows="5" wire:model.lazy="ev_lp" name="ev_lp" id="ev_lp"></textarea>
            </div>

            <div wire:ignore>
            <div class="form-group">
            <label for="ev_desc">Event description text</label>
            <textarea placeholder="Event description text" class="form-control tiny_body" maxlength="999" wire:model.lazy="ev_desc" name="ev_desc" cols="50" rows="10" id="ev_desc"></textarea>
            </div>
            </div>

            <div class="form-group">
                <label for="ev_vid">Video URL</label>
                <input placeholder="Video URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="ev_vid" name="ev_vid" type="url" id="ev_vid">
            </div>

            <div class="form-group mb-4">
                <label for="ev_map">Map URL</label>
                <input placeholder="Map URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="ev_map" name="ev_map" type="url" id="ev_map">
            </div>

            <label>Supporting image</label>
            <div class="custom-file mb-4">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select image</label>
            </div>
        </div>
    </div>
</div>

<div id="links" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-8">

            Standard links settings from article

        </div>
    </div>
</div>

<div id="downloads" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-8">

            Standard downloads settings from article

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
            <a class="mydir-action" href="{{ route('admin.events.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>


@endsection

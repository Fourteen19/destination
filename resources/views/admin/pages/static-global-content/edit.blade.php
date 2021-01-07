@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Global Static Content</h1>
            <p class="mydir-instructions">From this screen you can control all of the static (or constant) content that appears through out every client system. NOTE: Making a change here will instantly publish the changes to all client systems.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#tab-a">[TBC]</a>
        </li>
        
    </ul>


<!-- Tab panes -->
<div class="tab-content">

    <div id="tab-a" class="tab-pane active">
        <div class="row">
            <div class="col-lg-6">

                TBC

            </div>
        </div>
    </div>


</div>

<div class="row">
    <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>
</div>

</form>

</div>

@endsection

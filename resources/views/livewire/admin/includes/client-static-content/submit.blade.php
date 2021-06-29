@if ($errors->any())
    <div class="row">
        <div class="col-lg-8">
            <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>There are some errors in your content</div>
        </div>
    </div>
@endif

@if (Session::has('fail'))
    <div class="row">
        <div class="col-lg-8">
        <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>Your data could not be saved</div>
        </div>
    </div>
@endif

@if (Session::has('success'))
    <div class="row">
        <div class="col-lg-8">
        <div class="mydir-success"><i class="fas fa-check-circle mr-2"></i>Your data has been saved!</div>
        </div>
    </div>
@endif


<div class="row">

    <div class="col-lg-6">

        <button type="button" wire:loading.attr="disabled" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>

        <div wire:loading wire:target="storeAndMakeLive">Processing... Please wait</div>

    </div>

</div>

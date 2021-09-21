@if ($errors->any())
    <div class="row">
        <div class="col-lg-8">
            <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>There are some errors in your cv.
            </div>
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

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="cv-split mb-4"></div>
        <button type="button" wire:click.prevent="store()" wire:loading.attr="disabled" class="btn platform-button mr-2">Save</button>
        <button type="button" wire:click.prevent="exportAsPdf()" wire:loading.attr="disabled" class="btn platform-button ">Save &amp; Download as PDF</button>
    </div>
    <div wire:loading wire:target="store">
        <div class="col-lg-12 mt-4">
            <span class="fw600 t20"><i class="fas fa-hourglass-half mr-2"></i>Processing... Please wait</span>
        </div>
    </div>
</div>

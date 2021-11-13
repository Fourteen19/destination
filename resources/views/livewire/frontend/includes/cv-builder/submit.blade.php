<div class="row mt-5">
    <div class="col-lg-12">
        <div class="cv-split mb-4"></div>
        <button type="button" wire:click.prevent="store()" wire:loading.attr="disabled" class="btn platform-button mr-2">Save</button>
        <button type="button" wire:click.prevent="exportAsPdf()" wire:loading.attr="disabled" class="btn platform-button ">Save and Download as PDF</button>
    </div>
    <div wire:loading wire:target="store, exportAsPdf">
        <div class="col-lg-12 mt-4">
            <span class="fw600 t20"><i class="fas fa-hourglass-half mr-2"></i>Processing... Please wait</span>
        </div>
    </div>
</div>

@if (Session::has('error'))
    <div class="row">
        <div class="col-lg-8">
            <div class="mydir-error red"><i class="fas fa-info-circle mr-2"></i>There was an error saving your CV</div>
        </div>
    </div>
@endif

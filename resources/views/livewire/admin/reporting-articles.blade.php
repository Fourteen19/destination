<div>

    <div class="form-group mb-4">
        <label for="institution">Filter by Article Type</label>
        <select class="form-control" id="type" name="type" wire:model.defer="type">
            <option value="all">All</option>
            <option value="global">Global</option>
            <option value="client">Client</option>
        </select>
        @error('type') <div class="text-danger error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group mb-4" wire:ignore>
        <label for="institution">Filter by Institution</label>
        <select class="form-control" id="institution" name="institution" wire:model="institution">
            <option value="">Please Select</option>
            <option value="all">All My Institutions</option>
            @foreach($institutionsList as $key => $institution)
                <option value="{{$institution->uuid}}">{{$institution->name}}</option>
            @endforeach
        </select>
        @error('institution') <div class="text-danger error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group mb-4">
        <label for="institution">Filter by Article Template</label>
        <select class="form-control" id="template" name="template" wire:model.defer="template">
            <option value="all">All</option>
            <option value="article">Article</option>
            <option value="accordion">Accordion</option>
            <option value="employer_profile">Employer Profile</option>
            <option value="work_experience">Work Experience</option>
        </select>
        @error('template') <div class="text-danger error">{{ $message }}</div>@enderror
    </div>

    @if ($displayExportButtons == 1)

        <button type="button" class="btn mydir-button" wire:click="checkResults" wire:loading.attr="disabled">Check results</button>

        <h3 class="mt-4 border-top pt-4">
            <span wire:loading.delay wire:target="checkResults">Processing...Please wait</span>
            <span wire:loading.remove wire:target="checkResults">{{$resultsPreviewMessage}}</span>
        </h3>

        <button type="button" class="btn mydir-button"  wire:click="generate" wire:loading.attr="disabled">Generate and send report</button>

        <h3 class="mt-4 border-top pt-4">
            <span wire:loading.delay wire:target="generate">Processing...Please wait</span>
            <span wire:loading.remove wire:target="generate">{{$message}}</span>
        </h3>

    @endif
</div>

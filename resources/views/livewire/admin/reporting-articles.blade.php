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

    <div class="form-group mb-4">
        <label for="institution">Filter by Institution</label>
        <select class="form-control" id="institution" name="institution" wire:model.defer="institution">
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

    <button type="button" class="btn mydir-button" wire:click="checkResults" wire:loading.attr="disabled">Check results</button>

    <h3 class="mt-4 border-top pt-4">There are {{$this->resultsPreview}} matching records.</h3>

    <button type="button" class="btn mydir-button"  wire:click="generate" wire:loading.attr="disabled">Generate and send report</button>

    <div wire:target="generate">{{$message}}</div>

</div>

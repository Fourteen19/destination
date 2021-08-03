<div>

    <div class="form-group mb-4" wire:ignore>
        <label for="institution">Filter by Institution</label>
        <select class="form-control" id="institution" name="institution" wire:model="institution">
            <option value="">Please Select</option>
            @foreach($institutionsList as $key => $institution)
                <option value="{{$institution->uuid}}">{{$institution->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-4" wire:ignore>
        <label for="year">Filter by Year</label>
        <select class="form-control" id="year" name="year" wire:model="year">
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">Post Education</option>
        </select>
    </div>

    <div class="form-group mb-4" wire:ignore>
        <label for="activity">Filter by Activity</label>
        <select class="form-control" id="activity" name="activity" wire:model="activity">
            <option value="all">All</option>
            @foreach($activitiesList as $key => $activity)
                <option value="{{$key}}">{{$activity}}</option>
            @endforeach
        </select>
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

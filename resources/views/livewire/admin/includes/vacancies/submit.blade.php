@if ($errors->any())
<div class="row">
    <div class="col-lg-8">
        <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>There are some errors in your vacancy.
        </div>
    </div>
</div>
@endif


@if (Session::has('fail'))
<div class="row">
    <div class="col-lg-8">
        <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>Your data could not be saved - Please log
            back in.</div>
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

@if (Session::has('email_fail'))
<div class="row">
    <div class="col-lg-8">
        <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>Your action could not be sent to CK</div>
    </div>
</div>
@endif

<div class="row">

    <div class="col-lg-6">

        @cannot('vacancy-make-live', 'admin')
            <div class="form-group">
                {!! Form::label('action_requested', 'Action Request'); !!}
                {!! Form::select('action_requested', ['make_live' => 'Make Live', 'remove_live' => 'Remove From Live', 'delete' => 'Delete'], null, ['placeholder' => 'No Action', 'class' => "form-control", 'wire:model.defer' => "action_requested", 'id' => "action_requested" ]); !!}
            </div>
        @endcan

        <button type="button" wire:click.prevent="store('')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Save</button>

        <button type="button" wire:click.prevent="store('exit')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Save and Exit</button>

        @if ($canMakeVacancyLive)
            <button type="button" wire:click.prevent="store('live_exit')" wire:loading.attr="disabled" class="btn mydir-button">Save And Make Live</button>
        @endif

    </div>

    <div wire:loading wire:target="store @if ($canMakeVacancyLive), storeAndMakeLive @endif">Processing... Please wait</div>

</div>

<div class="row">

    <button type="button" wire:click.prevent="store('exit')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Save and Exit</button>

    @if ($canMakeVacancyLive)
        <button type="button" wire:click.prevent="store('live_exit')" wire:loading.attr="disabled" class="btn mydir-button">Save And Make Live</button>
    @endif

</div>

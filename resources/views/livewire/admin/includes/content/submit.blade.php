<div class="row">


    {{-- $('#slug').attr('readonly', false); --}}

    <button type="button" wire:click.prevent="store()" class="btn mydir-button mr-2">Save @if($action == 'add') and Exit @endif</button>

    <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>



    @if ($errors->any())
        <div>Error! Please check your article</div>
    @else
        <div>Saved!</div>
    @endif


    @if (Session::has('fail'))
        <div>Your data could not be saved!</div>
    @endif

    @if (Session::has('success'))
        <div>Your data has been saved!</div>
    @endif

</div>

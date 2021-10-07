<div>
    <div class="form-row">

        @if ($displayDeleteButton == 'Y')
            <div class="form-group col d-flex align-items-end">
                <button type="submit" class="open-delete-modal btn mydir-button-sm m-0">Delete the selected {{Str::plural('user', count($users))}} and destroy all associated content</button>
            </div>
        @endif



    </div>

    <div x-data="{show:false}" x-show.transition.opacity.out.duration.1500ms="show" x-init="@this.on('deleted', () => {window.livewire.emit('reset_batch_filter'); show = true; setTimeout(() => {show = false; }, 10000) })"class="transfer-msg"><i class="fas fa-check-circle mr-2"></i>{{$updateTxt}}</div>
</div>

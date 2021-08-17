<div class="form-row">

    @if ($displayDeleteButton == 'Y')
        <div class="form-group col d-flex align-items-end">
            <button type="submit" class="open-delete-modal btn mydir-button-sm m-0">Delete the selected {{Str::plural('user', count($users))}} and destroy all associated content</button>
        </div>
    @endif

    <div x-data="{show:false}" x-show.transition.opacity.out.duration.1500ms="show" x-init="@this.on('deleted', () => {show = true; setTimeout(() => {show = false; }, 5000) })">{{$updateTxt}}</div>

</div>

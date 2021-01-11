<div class="form-row">

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Role:</label>
        <select name="role" id="role" class="form-control">
            <option value=''>Any role</option>
            @foreach($rolesList as $key => $role)
                <option value="{{ $key }}">{{ $role }}</option>
            @endforeach
        </select>
    </div>


    {{-- if access type 3, we can select a client--}}
    @if (session()->get('adminAccessLevel') == 3)
        <div class="form-group col">
            <label class="inline-block w-32 font-bold">Client:</label>
            <select name="client" id="client" wire:model="client" class="form-control">
                <option value=''>Choose a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->uuid }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Institution:</label>
        <select name="institution" id="institution" wire:model="institution" class="form-control">
            <option value=''>Choose an institution</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->uuid }}">{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col d-flex align-items-end">
    <button type="submit" class="btn mydir-button-sm m-0">Search</button>
    </div>

</div>
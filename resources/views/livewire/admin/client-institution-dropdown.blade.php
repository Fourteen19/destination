<div>

    {{-- if access type 3, we can select a client--}}
    @if (session()->get('adminAccessLevel') == 3)
        <div class="mb-8">
            <label class="inline-block w-32 font-bold">Client:</label>
            <select name="client" id="client" wire:model="client" class="form-control">
                <option value=''>Choose a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->uuid }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="mb-8">
        <label class="inline-block w-32 font-bold">Institution:</label>
        <select name="institution" id="institution" wire:model="institution" class="form-control">
            <option value=''>Choose an institution</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->uuid }}">{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>
    
</div>
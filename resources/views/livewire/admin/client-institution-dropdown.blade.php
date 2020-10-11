<div>

    <div class="mb-8">
        <label class="inline-block w-32 font-bold">Client:</label>
        <select name="client" wire:model="client" class="border shadow p-2 bg-white">
            <option value=''>Choose a client</option>
            @foreach($clients as $client)
                <option value={{ $client->uuid }}>{{ $client->name }}</option>
            @endforeach
        </select>
    </div>
        
    <div class="mb-8">
        <label class="inline-block w-32 font-bold">Institution:</label>
        <select name="institution" wire:model="institution" 
            class="p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline">
            <option value=''>Choose an institution</option>
            @foreach($institutions as $institution)
                <option value={{ $institution->uuid }}>{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>
    
</div>
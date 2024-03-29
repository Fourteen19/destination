<div id="institution" class="tab-pane @if ($activeTab == "institution") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            @if ($displayClientsDropdown == 1)
                <div class="form-group">
                    <label for="client">Set client</label>
                    <select name="client" class="form-control" id="client" wire:model.lazy="client">
                        <option value="">Choose a client</option>
                        @foreach($this->clientsList as $key => $client)
                            <option value="{{ $key }}">{{ $client }}</option>
                        @endforeach
                    </select>
                    @error('client') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>
            @endif


            <div wire:loading.delay wire:target="client">
                Loading institutions...
            </div>

            <div class="form-group">
                <label for="inst_name">Set institution</label>
                <select name="institution" class="form-control" id="institution" wire:model.lazy="institution">
                    <option value="">Please select</option>
                    @foreach($this->institutionsList as $key => $institution)
                        <option value="{{$institution->uuid}}">{{$institution->name}}</option>
                    @endforeach
                </select>
                @error('institution') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            @if ($this->institution != "")

                <div wire:loading.delay wire:target="institution">
                    Loading advisers...
                </div>

                @if (!empty($this->advisers))

                    <div class="form-inline">
                        @foreach($this->advisers as $key => $adviser)
                            <label class="mr-2">Adviser:</label>{{ $adviser['first_name'] }} {{ $adviser['last_name'] }} <br>
                        @endforeach
                    </div>

                @else

                    <div class="form-inline">
                        <label class="mr-2">Adviser: </label>This institution has no adviser allocated
                    </div>

                @endif

            @endif

        </div>
    </div>
</div>

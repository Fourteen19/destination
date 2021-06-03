<div id="client-settings" class="tab-pane px-0 @if ($activeTab == "client-settings") active @else fade @endif" wire:key="client-settings-pane">
    <div class="row">
        <div class="col-lg-8">

            @if ($displayAllClients == 1)
                <div class="form-group">
                    <div class="form-check mb-3 border-top pt-3">
                        {!! Form::checkbox('all_clients', 'Y', ($all_clients == NULL) ? False : True, ['class' => '', 'id' => 'all_clients', 'wire:model' => 'all_clients' ]) !!}
                        <label class="form-check-label" for="all_clients">
                        {!! Form::label('all_clients', 'Allocate this event to all current and future clients/institutions'); !!}
                        </label>
                    </div>
                </div>
            @endif


            @if ($displayClients == 1)
                <div class="form-group" id="clients">
                    <label class="inline-block w-32 font-bold">Client:</label>
                    @error('client') <span class="text-danger error">{{ $message }}</span>@enderror
                    <select name="client" id="client" wire:model="client" class="form-control">
                        <option value=''>Choose a client</option>
                        @foreach($clientsList as $client)
                            <option value="{{ $client['uuid'] }}">{{ $client['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif


            @if ($displayInstitutions == 1)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">
                        {!! Form::label('institution', (isGlobalAdmin()) ? 'Institutions (optional)' : 'Institutions (select only the institutions you want to be able to see this event. If the event needs to be seen by all institutions, do not select ant institutions)'); !!}
                        @foreach($institutionsList as $institution)
                            <div class="form-check">
                                {!! Form::checkbox('institutions[]', $institution['uuid'], false, ['class' => 'form-check-input', 'id' => $institution['uuid'], 'wire:model.defer' => 'institutions' ]) !!}
                                <label class="form-check-label" for="{{$institution['uuid']}}">{{$institution['name']}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

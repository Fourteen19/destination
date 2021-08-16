<div id="client-settings" class="tab-pane px-0 @if ($activeTab == "client-settings") active @else fade @endif" wire:key="client-settings-pane">
    <div class="row">
        <div class="col-lg-8">

           {{--  @if ($displayClients == 1) --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                        {!! Form::label('client', 'Clients') !!}
                        @foreach($clientsList as $key => $client)
                            <div class="form-check">
                                {!! Form::checkbox('clients[]', $client['uuid'], false, ['class' => 'form-check-input', 'id' => $client['uuid'], 'wire:model' => 'clients' ]) !!}
                                <label class="form-check-label" for="{{$client['uuid']}}">{{$client['name']}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            {{-- @endif --}}



            {{--  @if ($displayAllClients == 1) --}}
            <div class="form-group">
                <div class="form-check mb-3 border-top pt-3">
                    {!! Form::checkbox('all_clients', 'Y', ($all_clients == NULL) ? False : True, ['class' => 'form-check-input', 'id' => 'all_clients', 'wire:model' => 'all_clients' ]) !!}
                    <label class="form-check-label" for="all_clients">
                    {!! Form::label('all_clients', 'Allocate this vacancy to all current and future clients'); !!}
                    </label>
                </div>
            </div>
            {{-- @endif --}}



        </div>
    </div>
</div>

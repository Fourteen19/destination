<div id="client-settings" class="tab-pane px-0 @if ($activeTab == "client-settings") active @else fade @endif" wire:key="client-settings-pane">
    <div class="row">
        <div class="col-lg-8">

            @if (isGlobalAdmin())

                {{-- @livewire('admin.resource-client-selector', ['allClientsParam' => (!empty(old('all_clients'))) ? old('all_clients') : $vacancy->all_clients,
                                                             'clientsParam' => (!empty(old('clients'))) ? old('clients') : $vacancy->clients,
                                                            ]) --}}
            @endif

        </div>
    </div>
</div>

<div id="featured-events" class="tab-pane @if ($activeTab == "featured-events") active @else fade @endif">
    <div class="row">
        <div class="col-lg-10">

            @livewire('admin.event-selector', ['label' => 'Event - slot 1',
                                                'eventUuid' => $eventSlot1Page,
                                                'name' => 'eventSlot1Page',
                                                'includeClientEvents' => True,
                                                'key' => "featured-event-1",
                                                'includeInternal' => 'N',])

            @livewire('admin.event-selector', ['label' => 'Event - slot 2',
                                                'eventUuid' => $eventSlot2Page,
                                                'name' => 'eventSlot2Page',
                                                'includeClientEvents' => True,
                                                'key' => "featured-event-2",
                                                'includeInternal' => 'N',])

        </div>
    </div>
</div>

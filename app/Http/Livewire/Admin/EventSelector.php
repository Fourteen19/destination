<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\EventLive;
use Illuminate\Support\Facades\Session;

class EventSelector extends Component
{

    public $query= '';
    public array $events = [];
    public string $selectedEvent = '';
    public int $highlightIndex = 0;
    public bool $showDropdown;
    public bool $includeClientEvents;


    public $label;
    public $name;
    public $validate;

    public function mount($label, $eventUuid, $name, $includeClientEvents, $key, $includeInternal)
    {
        $this->reset();

        if ($eventUuid)
        {
            $event = EventLive::where('uuid', '=', $eventUuid)->select('uuid', 'title')->first();

            if ($event)
            {
                $event = $event->toArray();

                $this->selectedEvent = $event['uuid'];
                $this->query = $event['title'];
            }
        }

        $this->label = $label;
        $this->name = $name;
        $this->includeClientEvents = $includeClientEvents;
        $this->includeInternal = $includeInternal;
    }


    public function reset(...$properties)
    {
        $this->events = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedEvent = 0;
        $this->showDropdown = true;
        $this->emitUp('event_selector', [$this->name, NULL]);
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->events) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->events) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function selectEvent($id = null)
    {

        $id = $id ?: $this->highlightIndex;

        $event = $this->events[$id] ?? null;

        if ($event) {
            //$this->showDropdown = true;
            $this->hideDropdown();
            $this->query = $event['title'];
            $this->selectedEvent = $event['uuid'];
            $this->emitUp('event_selector', [$this->name, $event['uuid']]);
        }
    }

    /**
     * updatedQuery
     * if includeClientEvents is TRUE, then display global and client events
     * if includeClientEvents is FALSE, then display global events
     *
     * @return void
     */
    public function updatedQuery()
    {

        if (strlen($this->query) > 2)
        {

            if ($this->includeClientEvents)
            {
                $events = EventLive::where('title', 'like', '%' . $this->query. '%')
                    ->select('uuid', 'title')
                    ->Where(function($query) {
                        $query->where('client_id', NULL)
                        ->orWhere('client_id', Session::get('adminClientSelectorSelected'));
                    });


            } else {
                $events = EventLive::where('title', 'like', '%' . $this->query. '%')
                    ->select('uuid', 'title')
                    ->where('client_id', '=', NULL);

            }

            if ($this->includeInternal == "N")
            {
                $events = $events->where('is_internal', '=', "N");
            }

            $this->events = $events->get()->toArray();

        }

        return NULL;

    }


    public function render()
    {
        return view('livewire.admin.event-selector');
    }

}

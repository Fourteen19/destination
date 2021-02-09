<div>

    <form wire:submit.prevent="submit">

        <ul class="nav nav-tabs mydir-tabs" role="tablist">

            <li class="nav-item">
              <a class="nav-link @if ($activeTab == "user-details") active @endif @if($errors->hasany(['first_name'])) error @endif" data-toggle="tab" href="#user-details" wire:click="updateTab('user-details')">User details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" @if ($activeTab == "additional-information") active @endif data-toggle="tab" href="#additional-information" wire:click="updateTab('additional-information')">Additional information</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" @if ($activeTab == "institution") active @endif data-toggle="tab" href="#institution" wire:click="updateTab('institution')">Institution</a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" @if ($activeTab == "self-assessment-tags") active @endif data-toggle="tab" href="#self-assessment-tags" wire:click="updateTab('self-assessment-tags')">Self assessment tags</a>
            </li> --}}
        </ul>


        <!-- Tab panes -->
        <div class="tab-content">

            @include('livewire.admin.includes.users.user-details')

            @include('livewire.admin.includes.users.additional-information')

            @include('livewire.admin.includes.users.institution-selector')

            {{-- @include('livewire.admin.includes.users.self-assessment-tags') --}}

        </div>

        @include('livewire.admin.includes.users.submit')

    </form>

</div>



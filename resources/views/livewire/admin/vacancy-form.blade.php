<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancy-details") active @endif" data-toggle="tab" href="#vacancy-details" wire:click="updateTab('vacancy-details')">Vacancy details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancy-content") active @endif" data-toggle="tab" href="#vacancy-content" wire:click="updateTab('vacancy-content')">Vacancy content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "filter-settings") active @endif" data-toggle="tab" href="#filter" wire:click="updateTab('filter-settings')">Filter settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "client-settings") active @endif" data-toggle="tab" href="#client" wire:click="updateTab('client-settings')">Client settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "preview") active @endif" data-toggle="tab" href="#client" wire:click="updateTab('preview')">Preview</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.vacancies.vacancy-details')

        @include('livewire.admin.includes.vacancies.vacancy-content')

        @include('livewire.admin.includes.vacancies.filter-settings')

        @include('livewire.admin.includes.vacancies.client-settings')

        @include('livewire.admin.includes.vacancies.preview')

    </div>

    @include('livewire.admin.includes.vacancies.submit')

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.vacancies.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>

<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "personal-details") active @endif" data-toggle="tab" href="#personal-details" data-tab="personal-details" wire:key="personal-details-tab" wire:click="updateTab('personal-details')">Personal details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "personal-profile") active @endif" data-toggle="tab" href="#personal-profile" data-tab="personal-profile" wire:key="personal-profile-tab" wire:click="updateTab('personal-profile')">Personal profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "key-skills") active @endif" data-toggle="tab" href="#key-skills" data-tab="key-skills" wire:key="key-skills-tab" wire:click="updateTab('key-skills')">Key skills</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "employment") active @endif" data-toggle="tab" href="#employment" data-tab="employment" wire:key="employment-tab" wire:click="updateTab('employment')">Employment history</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "education") active @endif" data-toggle="tab" href="#education" data-tab="education" wire:key="education-tab" wire:click="updateTab('education')">Education</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "additional-interests") active @endif" data-toggle="tab" href="#additional-interests" data-tab="additional-interests" wire:key="additional-interests-tab" wire:click="updateTab('additional-interests')">Interests and achievements</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "references") active @endif" data-toggle="tab" href="#references" data-tab="references" wire:key="references-tab" wire:click="updateTab('references')">References</a>
        </li>
{{--         <li class="nav-item">
            <a class="nav-link @if ($activeTab == "templates") active @endif" data-toggle="tab" href="#templates" data-tab="templates" wire:key="templates-tab" wire:click="updateTab('templates')">Select template</a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "layout") active @endif" data-toggle="tab" href="#layout" data-tab="layout" wire:key="layout-tab" wire:click="updateTab('preview')">Layout</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content cv-builder">

        @include('livewire.frontend.includes.cv-builder.personal-details')

        @include('livewire.frontend.includes.cv-builder.personal-profile')

        @include('livewire.frontend.includes.cv-builder.key-skills')

        @include('livewire.frontend.includes.cv-builder.employment')

        @include('livewire.frontend.includes.cv-builder.education')

        @include('livewire.frontend.includes.cv-builder.additional-interests')

        @include('livewire.frontend.includes.cv-builder.references')

        {{-- @include('livewire.frontend.includes.cv-builder.templates') --}}

        @include('livewire.frontend.includes.cv-builder.layout')

    </div>

    @include('livewire.frontend.includes.cv-builder.submit')

</div>

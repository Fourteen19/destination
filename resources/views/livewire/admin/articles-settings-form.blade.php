<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "year7") active @endif" data-toggle="tab" href="#year7" wire:key="year7-tab" wire:click="updateTab('year7')">Year 7</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "year9") active @endif" data-toggle="tab" href="#year8" wire:key="year8-tab" wire:click="updateTab('year8')">Year 8</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year9") active @endif" data-toggle="tab" href="#year9" wire:key="year9-tab" wire:click="updateTab('year9')">Year 9</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year10") active @endif" data-toggle="tab" href="#year10" wire:key="year10-tab" wire:click="updateTab('year10')">Year 10</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year11") active @endif" data-toggle="tab" href="#year11" wire:key="year11-tab" wire:click="updateTab('year11')">Year 11</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year12") active @endif" data-toggle="tab" href="#year12" wire:key="year12-tab" wire:click="updateTab('year12')">Year 12</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year13") active @endif" data-toggle="tab" href="#year13" wire:key="year13-tab" wire:click="updateTab('year13')">Year 13</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year14") active @endif" data-toggle="tab" href="#year14" wire:key="year14-tab" wire:click="updateTab('year14')">Post Education 8</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.article-settings.year7')

        @include('livewire.admin.includes.article-settings.year8')

        @include('livewire.admin.includes.article-settings.year9')

        @include('livewire.admin.includes.article-settings.year10')

        @include('livewire.admin.includes.article-settings.year11')

        @include('livewire.admin.includes.article-settings.year12')

        @include('livewire.admin.includes.article-settings.year13')

        @include('livewire.admin.includes.article-settings.year14')

    </div>

    @include('livewire.admin.includes.content.submit')

</div>








<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "welcome-banner") active @endif" data-toggle="tab" href="#welcome" {{-- wire:click="updateTab('welcome-banner')" --}}>Welcome Banner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "free-articles") active @endif" data-toggle="tab" href="#free" {{-- wire:click="updateTab('free-articles')" --}}>Free Articles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "preview") active @endif" data-toggle="tab" href="#preview" {{-- wire:click="updateTab('preview')" --}}>Preview</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.client-homepage.welcome-banner')

        @include('livewire.admin.includes.client-homepage.free-articles')

        @include('livewire.admin.includes.client-homepage.preview')

    </div>

    @include('livewire.admin.includes.client-homepage.submit')

</div>

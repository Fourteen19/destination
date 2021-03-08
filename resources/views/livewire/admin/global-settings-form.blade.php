<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "articles") active @endif @if($errors->hasany(['wordcount'])) error @endif" data-toggle="tab" href="#articles" {{-- wire:click="updateTab('articles')" --}}>Articles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "advisor-contact-form") active @endif @if($errors->hasany(['questionType'])) error @endif" data-toggle="tab" href="#advisor-contact-form" {{-- wire:click="updateTab('advisor-contact-form')" --}}>Contact Advisor</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.global-settings.articles')

        @include('livewire.admin.includes.global-settings.advisor-contact-form')

        @include('livewire.admin.includes.global-settings.submit')

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.1.0/dist/livewire-sortable.js"></script>
@endpush

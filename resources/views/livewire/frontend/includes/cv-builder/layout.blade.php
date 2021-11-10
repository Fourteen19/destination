<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

        <div class="mb-3">{!! $staticContent['cv_layout_instructions'] !!}</div>

        <div class="cv-split mb-5"></div>

        @if ($template == 1)

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-key-skills')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Employment history"])

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 2)

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-key-skills')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Work experience"])

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @endif

        </div>
    </div>

    <div class="row mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('templates')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
    </div>


</div>


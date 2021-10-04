<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

        @if ($template == 1)

            <h2 class="fw700 t18">You have selected "CV 1 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')
                    
                    @if ($addPageBreakBeforeEmployment == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Employment history"])

                    @if ($addPageBreakBeforeEducation == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @if ($addPageBreakBeforeAdditionalInterest == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @if ($addPageBreakBeforeReferences == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 2)

            <h2 class="fw700 t18">You have selected "CV 2 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @if ($addPageBreakBeforeEmployment == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-key-skills')

                    @if ($addPageBreakBeforeEducation == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @if ($addPageBreakBeforeAdditionalInterest == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @if ($addPageBreakBeforeReferences == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 3)

            <h2 class="fw700 t18">You have selected "CV 3 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @if ($addPageBreakBeforeEmployment == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @if ($addPageBreakBeforeEducation == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Work Experience"])

                    @if ($addPageBreakBeforeAdditionalInterest == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @if ($addPageBreakBeforeReferences == "Y")
                        </div></div><div class="cv-preview-outer"><div class="cv-preview-inner">
                    @endif

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 4)

            <h2 class="fw700 t18">You have selected "CV 4 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Employment history"])

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 5)

            <h2 class="fw700 t18">You have selected "CV 5 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-key-skills')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 6)

            <h2 class="fw700 t18">You have selected "CV 6 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Work Experience"])

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


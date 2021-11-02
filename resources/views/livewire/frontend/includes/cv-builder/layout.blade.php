<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

        <p class="t16">This preview below is so you can check the information in your CV and that all the sections are complete.</p>
        <p class="t16"><b>To see what your CV actually looks like, you need to click on ‘Save & download as PDF’ at the bottom of the screen.</b></p>
        <p class="t16">Open up the PDF and check the number of pages in your CV and what your CV looks like. <b>Ideally, your CV should fill one side of A4 –</b> do you need to add or take out some text? Ask your careers adviser or teacher if you need help doing this.<br/>
            If your CV has to go on to 2 pages, decide where you want the page break to be so it’s not cutting across a section. Click on the box under the section where you want the break and select the ‘Save & download as PDF’ button again.<br/>
            You can ‘Save & download as PDF’ as many times as you want, to get the best layout for your CV. Once you have a version you like, save the final version with your name to the computer – which you can then print out or attach to an email.</p>

        @if ($template == 1)

            {{-- <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p> --}}

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">1

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Employment history"])

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 2)

            {{-- <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p> --}}

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">2

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-key-skills')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 3)

            {{-- <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p> --}}

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">3

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-details')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.personal-profile')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.education')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.employment-history', ['block_title' => "Work experience"])

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.additional-interests')

                    @include('livewire.frontend.includes.cv-builder.preview-blocks.references')

                </div>
            </div>

        @elseif ($template == 4)


            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

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


            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

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


            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You can set where you would like to insert a page break using the options below. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

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


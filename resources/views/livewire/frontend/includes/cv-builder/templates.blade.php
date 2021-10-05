<div id="templates" class="tab-pane @if ($activeTab == "templates") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div wire:ignore>

                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[1]" value="1" wire:model="template" wire.key="template_1">
                            <label for="template[1]">
                                <img src="{{ asset('images/cv-template-1.png') }}" alt="CV 1 (Modern)">
                                <div class="t16">
                                    <h4 class="t16 fw700">CV 1 (Modern)</h4>
                                    <span>This CV is ideal if you have an employment history. The order of sections is Personal profile / Skills and experience / Education / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[2]" value="2" wire:model="template" wire.key="template_2">
                            <label for="template[2]">
                                <img src="{{ asset('images/cv-template-2.png') }}" alt="CV 2 (Modern)">
                                <div class="t16">
                                    <h4 class="t16 fw700">CV 2 (Modern)</h4>
                                    <span>This CV is ideal if you have no work experience or employment history. The order of sections is Personal profile / Key Skills / Education / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[3]" value="3" wire:model="template" wire.key="template_3">
                            <label for="template[3]">
                                <img src="{{ asset('images/cv-template-3.png') }}" alt="CV 3 (Modern)">
                                <div class="t16">
                                <h4 class="t16 fw700">CV 3 (Modern)</h4>
                                    <span>This CV is ideal if you have some work experience but no employment history i.e. a school leaver in year 11 or 13. The order of sections is Personal profile / Education / Work Experience / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    {{--
                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[4]" value="4" wire:model="template" wire.key="template_4">
                            <label for="template[4]">
                                <img src="{{ asset('images/cv-template-4.png') }}" alt="CV 4 (Traditional)">
                                <div class="t16">
                                    <h4 class="t16 fw700">CV 4 (Traditional)</h4>
                                    <span>This CV is ideal if you have an employment history. The order of sections is Personal profile / Skills and experience / Education / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[5]" value="5" wire:model="template" wire.key="template_5">
                            <label for="template[5]">
                                <img src="{{ asset('images/cv-template-5.png') }}" alt="CV 5 (Traditional)">
                                <div class="t16">
                                    <h4 class="t16 fw700">CV 5 (Traditional)</h4>
                                    <span>This CV is ideal if you have no work experience or employment history. The order of sections is Personal profile / Key Skills / Education / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[6]" value="6" wire:model="template" wire.key="template_6">
                            <label for="template[6]">
                                <img src="{{ asset('images/cv-template-6.png') }}" alt="CV 6 (Traditional)">
                                <div class="t16">
                                <h4 class="t16 fw700">CV 6 (Traditional)</h4>
                                    <span>This CV is ideal if you have some work experience but no employment history i.e. a school leaver in year 11 or 13. The order of sections is Personal profile / Education / Work Experience / Additional interests / References</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    --}}
                </div>
                

            </div>

        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('references')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('preview')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>


</div>

<div id="templates" class="tab-pane @if ($activeTab == "templates") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div wire:ignore>

                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[1]" value="1" wire:model="template" wire.key="template_1">
                            <label for="template[1]">
                                <img src="https://via.placeholder.com/150x200.png">
                                <div class="t16">
                                    <h4 class="t16 fw700">Template description 1</h4>
                                    <span>Nunc tempus vulputate nunc in rutrum. Fusce accumsan nulla a dictum rutrum. In sit amet consequat erat. Vestibulum sodales eleifend cursus. Morbi maximus orci iaculis purus suscipit feugiat.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[2]" value="2" wire:model="template" wire.key="template_2">
                            <label for="template[2]">
                                <img src="https://via.placeholder.com/150x200.png">
                                <div class="t16">
                                    <h4 class="t16 fw700">Template description 2</h4>
                                    <span>Nunc tempus vulputate nunc in rutrum. Fusce accumsan nulla a dictum rutrum. In sit amet consequat erat. Vestibulum sodales eleifend cursus. Morbi maximus orci iaculis purus suscipit feugiat.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[3]" value="3" wire:model="template" wire.key="template_3">
                            <label for="template[3]">
                                <img src="https://via.placeholder.com/150x200.png">
                                <div class="t16">
                                    <h4 class="t16 fw700">Template description 3</h4>
                                    <span>Nunc tempus vulputate nunc in rutrum. Fusce accumsan nulla a dictum rutrum. In sit amet consequat erat. Vestibulum sodales eleifend cursus. Morbi maximus orci iaculis purus suscipit feugiat.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[4]" value="4" wire:model="template" wire.key="template_4">
                            <label for="template[4]">
                                <img src="https://via.placeholder.com/150x200.png">
                                <div class="t16">
                                    <h4 class="t16 fw700">Template description 4</h4>
                                    <span>Nunc tempus vulputate nunc in rutrum. Fusce accumsan nulla a dictum rutrum. In sit amet consequat erat. Vestibulum sodales eleifend cursus. Morbi maximus orci iaculis purus suscipit feugiat.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="template-outer">
                            <input class="mr-3" type="radio" name="template" id="template[5]" value="5" wire:model="template" wire.key="template_5">
                            <label for="template[5]">
                                <img src="https://via.placeholder.com/150x200.png">
                                <div class="t16">
                                    <h4 class="t16 fw700">Template description 5</h4>
                                    <span>Nunc tempus vulputate nunc in rutrum. Fusce accumsan nulla a dictum rutrum. In sit amet consequat erat. Vestibulum sodales eleifend cursus. Morbi maximus orci iaculis purus suscipit feugiat.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
                
                
                
                

       {{--          {!! Form::label('template', 'Template'); !!}
                <select class="form-control form-control-lg" name="template" wire:model="template">
                    <option value="1">Template 1</option>
                    <option value="2">Template 2</option>
                    <option value="3">Template 3</option>
                </select> --}}

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

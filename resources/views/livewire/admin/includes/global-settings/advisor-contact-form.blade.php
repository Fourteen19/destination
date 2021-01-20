<div id="advisor-contact-form" class="tab-pane px-0 @if ($activeTab == "advisor-contact-form") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">
            <div class="rounded p-4 form-outer">

                <ul wire:sortable="updateQuestionTypeOrder" class="drag-list">
                @foreach($contactAdvisorQuestionTypes as $key => $questionType)
                    <li wire:sortable.item="{{ $key }}" wire:key="{{ $key }}" class="drag-box">
                        <div class="row">
                            <div class="col-md-1"><div wire:sortable.handle class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Question Type:</label>
                                    <input type="text" class="form-control" placeholder="Enter Question Type" wire:model="contactAdvisorQuestionTypes.{{$key}}">
                                    @error('contactAdvisorQuestionTypes.'.$key)<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-1 ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeQuestionType({{$key}})"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                    </li>
                @endforeach
                </ul>
                <button class="mydir-action btn" wire:click.prevent="addQuestionType({{$contactAdvisorQuestionTypesIteration}})"><i class="fas fa-plus-square mr-2"></i>Add a question type</button>

            </div>
        </div>
    </div>
</div>

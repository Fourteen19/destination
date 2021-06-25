<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-11">
        <div class="p-4 p-lg-0">

            <form wire:submit.prevent="submit">

                <div class="row justify-content-center">
                    <div class="col-12 col-lg mb-3 mb-lg-0">
                        {!! Form::text('keyword', $this->keyword, array('id' => 'keywords', 'placeholder' => 'Enter a keyword','class' => 'form-control form-control-lg mr-sm-4','wire:model.defer' => 'keyword', 'autocomplete' => 'off' )) !!}
                    </div>
                    <div class="col-12 col-lg mb-3 mb-lg-0">
                        {!! Form::label('areas', 'Choose an Area', ['class' => "sr-only"]) !!}
                        {!! Form::select('areas', $this->areaList, null, ['id' => 'areas', 'placeholder' => 'Select an area', 'class' => "form-control form-control-lg mr-sm-4", 'wire:model.defer' => "area"]) !!}
                    </div>
                    <div class="col-12 col-lg mb-3 mb-lg-0">
                        {!! Form::label('category', 'Choose a category', ['class' => "sr-only"]) !!}
                        {!! Form::select('category', $this->categoryList, null, ['id' => 'category', 'placeholder' => 'Select an category', 'class' => "form-control form-control-lg mr-sm-2", 'wire:model.defer' => "category"]) !!}
                    </div>

                    <div class="col-12 col-lg mb-3 mb-lg-0 text-center text-lg-left">
                        <button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn platform-button pb-inv">Search jobs</button>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>


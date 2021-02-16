<div id="free" class="tab-pane @if ($activeTab == "free-articles") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('free_heading', 'Free articles block heading'); !!}
                {!! Form::text('free_heading', $bannerTitle, array('placeholder' => 'Free articles block heading', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'freeArticlesBlockHeading')) !!}
                @error('link1Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('free_intro', 'Free articles introduction'); !!}
                {!! Form::textarea('free_intro', $bannerTitle, array('placeholder' => 'Free articles block introduction', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'freeArticlesBlockText')) !!}
                @error('link1Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('suplink1', 'Free article - slot 1'); !!}
                {!! Form::select('suplink1', $this->contentList, (!empty($freeArticlesSlot1Page)) ? $freeArticlesSlot1Page : '', array('class' => 'form-control', 'wire:model.lazy' => 'freeArticlesSlot1Page')) !!}
                @error('freeArticlesSlot1Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('suplink2', 'Free article - slot 2'); !!}
                {!! Form::select('suplink2', $this->contentList, (!empty($freeArticlesSlot2Page)) ? $freeArticlesSlot2Page : '', array('class' => 'form-control', 'wire:model.lazy' => 'freeArticlesSlot2Page')) !!}
                @error('freeArticlesSlot2Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('suplink3', 'Free article - slot 3'); !!}
                {!! Form::select('suplink3', $this->contentList, (!empty($freeArticlesSlot3Page)) ? $freeArticlesSlot3Page : '', array('class' => 'form-control', 'wire:model.lazy' => 'freeArticlesSlot3Page')) !!}
                @error('freeArticlesSlot3Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

<div id="keywords" class="tab-pane @if ($activeTab == "keywords") active @else fade @endif" wire:key="keywords-pane">
    <div class="row">
        <div class="col-lg-12">
        {!! Form::label('tagsKeywords', 'Keywords'); !!}
        <div class="form-group keyword-columns">
            

            @foreach($tagsKeywords as $tag)
                <div class="form-check">
                {!! Form::checkbox('tagsKeywords[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.defer' => 'contentKeywordTags' ]) !!}
                <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                {{$tag['name'][app()->getLocale()]}}
                </label>
                </div>
            @endforeach
        </div>

        </div>
    </div>
</div>

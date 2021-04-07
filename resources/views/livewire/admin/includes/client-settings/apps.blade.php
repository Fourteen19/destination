<div id="apps" class="tab-pane @if ($activeTab == "apps") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                @error('alt_block_text') <span class="text-danger error">{{ $message }}</span>@enderror
                <div  wire:ignore>
                {!! Form::label('chat_app', 'Chat App'); !!}
                {!! Form::textarea('chat_app', (!isset($chat_app)) ? null : $chat_app, array('placeholder' => 'Chat App code', 'class' => 'form-control', 'rows' => 5, 'cols' => 50, 'wire:model.lazy' => 'chat_app')) !!}
                </div>
            </div>

        </div>
    </div>
</div>

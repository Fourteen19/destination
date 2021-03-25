<div id="free-articles" class="tab-pane @if ($activeTab == "free-articles") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-info-circle mr-2"></i>Free Articles</h2>
            <p>Enter the text that will be displayed in the public home page when someone is viewing a free article.</p>

            <div wire:ignore>
                <div class="form-group">
                    {!! Form::label('free_articles_message', 'Free Articles message'); !!}
                    {!! Form::textarea('free_articles_message', $free_articles_message, array('placeholder' => 'Message', 'class' => 'form-control tiny_body', 'wire:model.defer' => 'free_articles_message')) !!}
                </div>
            </div>

        </div>
    </div>
</div>

<div id="public-content" class="tab-pane @if ($activeTab == "public-content") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Pre-footer Block</h2>

            <div class="form-group ">
                {!! Form::label('ppfheading', 'Heading'); !!}
                {!! Form::text('ppfheading', $staticClientContent->pre_footer_heading, array('placeholder' => 'Heading', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'staticClientContent.pre_footer_heading')) !!}
            </div>

            <div wire:ignore>
                <div class="form-group">
                    {!! Form::label('ppfbody', 'Block body text'); !!}
                    {!! Form::textarea('ppfbody', $staticClientContent->pre_footer_body, array('placeholder' => 'Block body text','class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.pre_footer_body')) !!}
                </div>
            </div>

            <div class="form-group ">
                {!! Form::label('ppfbuttom', 'Button text'); !!}
                {!! Form::text('ppfbuttom', $staticClientContent->pre_footer_button_text, array('placeholder' => 'Button text i.e. Find out more', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'staticClientContent.ppfbuttom')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('ppflink', 'Link destination'); !!}
                {!! Form::select('ppflink', ['' => 'Please Select', '1' => 'page 1', '2' => 'page 2'], $staticClientContent->pre_footer_link , array('class' => 'form-control', 'wire:model.defer' => 'staticClientContent.pre_footer_link') ) !!}
            </div>

        </div>
    </div>
</div>

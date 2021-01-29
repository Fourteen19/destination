<div id="loggedin" class="tab-pane @if ($activeTab == "logged-in-content") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Support Block</h2>

            <div class="form-group ">
                {!! Form::label('supheading', 'Heading text'); !!}
                {!! Form::text('supheading', $staticClientContent->support_block_heading, array('placeholder' => 'Heading', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'staticClientContent.support_block_heading')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('supbody', 'Block body text'); !!}
                {!! Form::textarea('supbody', $staticClientContent->support_block_body, array('placeholder' => 'Block body text', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.support_block_body')) !!}
            </div>

            <div class="form-group ">
                {!! Form::label('supbuttom', 'Button text'); !!}
                {!! Form::text('supbuttom', $staticClientContent->support_block_button_text, array('placeholder' => 'Block body text', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'staticClientContent.support_block_button_text')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('suplink', 'Link destination'); !!}
                {!! Form::select('suplink', ['' => 'Please Select', '1' => 'page 1', '2' => 'page 2'], $staticClientContent->support_block_link , array('class' => 'form-control', 'wire:model.defer' => 'staticClientContent.support_block_link') ) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Getting it right Block</h2>

            <div class="form-group ">
                {!! Form::label('grheading', 'Heading text'); !!}
                {!! Form::text('grheading', $staticClientContent->get_in_right_heading, array('placeholder' => 'Heading text', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'staticClientContent.get_in_right_heading')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('grtext', 'Block text'); !!}
                {!! Form::textarea('supbody', $staticClientContent->support_block_body, array('placeholder' => 'Block body text', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.support_block_body')) !!}
            </div>

        </div>
    </div>
</div>

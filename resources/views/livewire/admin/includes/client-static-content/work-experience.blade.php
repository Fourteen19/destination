<div id="work-experience" class="tab-pane @if ($activeTab == "work-experience") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('we_dashboard_intro', 'Dashboard Introduction'); !!}
                {!! Form::textarea('we_dashboard_intro', $we_intro, array('placeholder' => 'Dashboard Introduction','class' => 'form-control', 'wire:model.defer' => 'we_dashboard_intro')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('we_intro', 'Introduction'); !!}
                {!! Form::textarea('we_intro', $we_intro, array('placeholder' => 'Introduction','class' => 'form-control', 'wire:model.defer' => 'we_intro')) !!}
            </div>

            <div class="form-group ">
                {!! Form::label('we_button_text', 'Button text'); !!}
                {!! Form::text('we_button_text', $we_button_text, array('placeholder' => 'Button text i.e. Find out more', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'we_button_text')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('we_button_link', 'Link destination'); !!}
                {!! Form::select('we_button_link', ['' => 'Please Select'] + $clientPages, $pre_footer_link , array('class' => 'form-control', 'wire:model.defer' => 'we_button_link') ) !!}
            </div>

        </div>
    </div>
</div>

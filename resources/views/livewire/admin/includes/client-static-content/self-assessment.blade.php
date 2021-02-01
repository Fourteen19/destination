<div id="self-assessment" class="tab-pane @if ($activeTab == "self-assessment") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group" wire:ignore>
                {!! Form::label('login_intro', 'Login page introduction'); !!}
                {!! Form::textarea('login_intro', $login_intro, array('placeholder' => 'Login page introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'login_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('welcome_intro', 'Welcome screen introduction'); !!}
                {!! Form::textarea('welcome_intro', $welcome_intro, array('placeholder' => 'Welcome screen introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'welcome_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('careers_intro', 'Careers readiness introduction'); !!}
                {!! Form::textarea('careers_intro', $careers_intro, array('placeholder' => 'Careers readiness introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'careers_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('subjects_intro', 'Subjects introduction'); !!}
                {!! Form::textarea('subjects_intro', $subjects_intro, array('placeholder' => 'Subjects introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'subjects_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('routes_intro', 'Routes introduction'); !!}
                {!! Form::textarea('routes_intro', $routes_intro, array('placeholder' => 'Routes introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'routes_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('sectors_intro', 'Sectors introduction'); !!}
                {!! Form::textarea('sectors_intro', $sectors_intro, array('placeholder' => 'Sectors introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'sectors_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('assessment_completed_txt', 'Self assessment completed message'); !!}
                {!! Form::textarea('assessment_completed_txt', $assessment_completed_txt, array('placeholder' => 'Self assessment completed message', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'assessment_completed_txt')) !!}
            </div>

        </div>
    </div>
</div>

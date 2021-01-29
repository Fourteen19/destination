<div id="self-assessment" class="tab-pane @if ($activeTab == "self-assessment") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group" wire:ignore>
                {!! Form::label('loginintro', 'Login page introduction'); !!}
                {!! Form::textarea('loginintro', $staticClientContent->login_intro, array('placeholder' => 'Login page introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.login_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('welcomeintro', 'Welcome screen introduction'); !!}
                {!! Form::textarea('welcomeintro', $staticClientContent->welcome_intro, array('placeholder' => 'Welcome screen introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.welcome_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('crintro', 'Careers readiness introduction'); !!}
                {!! Form::textarea('crintro', $staticClientContent->careers_intro, array('placeholder' => 'Careers readiness introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.careers_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('subjectsintro', 'Subjects introduction'); !!}
                {!! Form::textarea('subjectsintro', $staticClientContent->subjects_intro, array('placeholder' => 'Subjects introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.subjects_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('routesintro', 'Routes introduction'); !!}
                {!! Form::textarea('routesintro', $staticClientContent->routes_intro, array('placeholder' => 'Routes introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.routes_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('sectorsintro', 'Sectors introduction'); !!}
                {!! Form::textarea('sectorsintro', $staticClientContent->sectors_intro, array('placeholder' => 'Sectors introduction', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.sectors_intro')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('sacompleted', 'Self assessment completed message'); !!}
                {!! Form::textarea('sacompleted', $staticClientContent->assessment_completed_txt, array('placeholder' => 'Self assessment completed message', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.assessment_completed_txt')) !!}
            </div>

        </div>
    </div>
</div>

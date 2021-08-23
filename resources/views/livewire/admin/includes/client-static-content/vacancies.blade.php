<div id="vacancies" class="tab-pane @if ($activeTab == "vacancies") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Featured vacancies</h2>

            <div class="form-group">
                {!! Form::label('featured_vacancy_1', 'Vacancy 1'); !!}
                {!! Form::select('featured_vacancy_1', ['' => 'Please Select'] + $vacanciesList, NULL, array('class' => 'form-control', 'wire:model.defer' => 'featured_vacancy_1') ) !!}
            </div>

            <div class="form-group">
                {!! Form::label('featured_vacancy_2', 'Vacancy 2'); !!}
                {!! Form::select('featured_vacancy_2', ['' => 'Please Select'] + $vacanciesList, NULL , array('class' => 'form-control', 'wire:model.defer' => 'featured_vacancy_2') ) !!}
            </div>

            <div class="form-group">
                {!! Form::label('featured_vacancy_3', 'Vacancy 3'); !!}
                {!! Form::select('featured_vacancy_3', ['' => 'Please Select'] + $vacanciesList, NULL , array('class' => 'form-control', 'wire:model.defer' => 'featured_vacancy_3') ) !!}
            </div>

            <div class="form-group">
                {!! Form::label('featured_vacancy_4', 'Vacancy 4'); !!}
                {!! Form::select('featured_vacancy_4', ['' => 'Please Select'] + $vacanciesList, NULL , array('class' => 'form-control', 'wire:model.defer' => 'featured_vacancy_4') ) !!}
            </div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Notifications</h2>

            <div class="form-group">
                @error('vacancy_email_notification') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('notifications', 'Please enter a semicolon separated list of administrator emails who should be notified when an employer creates or updates a vacancy'); !!}
                {!! Form::textarea('notifications', $vacancy_email_notification, array('placeholder' => 'admin1@mydirections.co.uk;admin2@mydirections.co.uk','class' => 'form-control', 'wire:model.defer' => 'vacancy_email_notification')) !!}
            </div>

        </div>
    </div>
</div>

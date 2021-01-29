<div id="legal" class="tab-pane @if ($activeTab == "legal") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Terms & Conditions</h2>

            <div wire:ignore>
                <div class="form-group">
                    {!! Form::label('terms-body', 'Terms & conditions page body text'); !!}
                    {!! Form::textarea('terms-body', $staticClientContent->terms, array('placeholder' => 'Terms & conditions body text','class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.terms')) !!}
                </div>
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Privacy Policy</h2>

            <div wire:ignore>
                <div class="form-group">
                    {!! Form::label('privacy-body', 'Privacy policy page body text'); !!}
                    {!! Form::textarea('privacy-body', $staticClientContent->privacy, array('placeholder' => 'Privacy policy body text','class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.privacy')) !!}
                </div>
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Cookie Policy</h2>

            <div wire:ignore>
                <div class="form-group">
                    {!! Form::label('cookie-body', 'Cookie policy page body text'); !!}
                    {!! Form::textarea('cookie-body', $staticClientContent->cookies, array('placeholder' => 'Cookie policy page body text','class' => 'form-control tiny_body', 'wire:model.defer' => 'staticClientContent.cookies')) !!}
                </div>
            </div>

        </div>
    </div>
</div>

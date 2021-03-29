<div id="welcome" class="tab-pane @if ($activeTab == "welcome-banner") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">


            <div class="form-group">
                <div class="rounded p-4 form-outer">
                    @error('banner') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('banner', 'Select banner background image'); !!}
                    <div class="input-group">
                    {!! Form::text('banner', null, array('placeholder' => 'Banner Image','class' => 'form-control', 'maxlength' => 255, 'id' => "banner_image", 'wire:model' => 'banner' )) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image-banner">Select</button>
                    </div>
                    </div>
                    <div class="article-image-preview">
                        <img src="{{ $bannerOriginal }}">
                    </div>
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('banner_title', 'Banner title'); !!}
                {!! Form::text('banner_title', $bannerTitle, array('placeholder' => 'Banner title', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'bannerTitle')) !!}
                @error('bannerTitle') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('banner_intro', 'Banner introduction'); !!}
                {!! Form::textarea('banner_intro', $bannerText, array('placeholder' => 'Banner introduction', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'bannerText')) !!}
                @error('bannerText') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('slot1_linktext', 'Link 1 - Button text'); !!}
                {!! Form::text('slot1_linktext', $bannerLink1Text, array('placeholder' => 'Button text i.e. Find out more', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'bannerLink1Text')) !!}
                @error('bannerLink1Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('slot1_url', 'Link 1 - destination'); !!}
                {!! Form::select('slot1_url', $this->pageList, (!empty($bannerLink1Page)) ? $bannerLink1Page : '', array('class' => 'form-control', 'wire:model.defer' => 'bannerLink1Page')) !!}
                @error('bannerLink1Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('slot2_linktext', 'Link 2 - Button text'); !!}
                {!! Form::text('slot2_linktext', $bannerLink2Text, array('placeholder' => 'Button text i.e. Find out more', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'bannerLink2Text')) !!}
                @error('bannerLink2Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>


            <div class="form-group">
                {!! Form::label('slot2_url', 'Link 2 - destination'); !!}
                {!! Form::select('slot2_url', $this->pageList, (!empty($bannerLink2Page)) ? $bannerLink2Page : '', array('class' => 'form-control', 'wire:model.defer' => 'bannerLink2Page')) !!}
                @error('bannerLink2Page') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

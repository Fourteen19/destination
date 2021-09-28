<div id="client-settings" class="tab-pane px-0 @if ($activeTab == "client-settings") active @else fade @endif" wire:key="client-settings-pane">
    <div class="row">
        <div class="col-lg-8">

            @if ($displayAllClients == 1)
                <div class="form-group">
                    <div class="form-check mb-3 border-top pt-3">
                        {!! Form::checkbox('all_clients', 'Y', ($all_clients == NULL) ? False : True, ['class' => 'form-check-input', 'id' => 'all_clients', 'wire:model' => 'all_clients' ]) !!}
                        <label class="form-check-label" for="all_clients">
                        {!! Form::label('all_clients', 'Allocate this event to all current and future clients/institutions'); !!}
                        </label>
                    </div>
                </div>
            @endif


            @if ($displayClients == 1)
                <div class="form-group" id="clients">
                    <label class="inline-block w-32 font-bold">Client:</label>
                    @error('client') <span class="text-danger error">{{ $message }}</span>@enderror
                    <select name="client" id="client" wire:model="client" class="form-control">
                        <option value=''>Choose a client</option>
                        @foreach($clientsList as $client)
                            <option value="{{ $client['uuid'] }}">{{ $client['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif



            @if ($displayAllInstitutions == 1)
                <div class="form-group">
                    <div class="form-check mb-3 border-top pt-3">
                        {!! Form::checkbox('all_institutions', 'Y', ($all_institutions == NULL) ? False : True, ['class' => 'form-check-input', 'id' => 'all_institutions', 'wire:model' => 'all_institutions' ]) !!}
                        <label class="form-check-label" for="all_institutions">
                            {!! Form::label('all_institutions', 'Allocate this event to all current and future institutions'); !!}
                        </label>
                    </div>
                </div>
            @endif


            @if ($displayInstitutions == 1)

                <div class="form-group{{ $errors->has('is_internal') ? ' has-error' : '' }}">
                    <div class="form-check mb-3 border-top pt-3">
                        {!! Form::label('is_internal', 'Internal') !!}
                        <label class="form-check-label" for="is_internal">
                            {!! Form::checkbox('is_internal', 'Y', ($is_internal == NULL) ? False : True, ['class' => 'form-check-input', 'id' => 'is_internal', 'wire:model.defer' => 'is_internal' ]) !!}
                        </label>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="inst" class="form-group{{ $errors->has('institutions') ? ' has-error' : '' }}">
                        {!! Form::label('institutions', 'Institutions') !!}
                        @error('institutions') <span class="text-danger error">{{ $message }}</span>@enderror
                        <div class="form-check">
                            <input type="checkbox" id='checkall' class='form-check-input'/><label class="form-check-label fw700" for="checkall">Select All</label>
                        </div>
                        @foreach($institutionsList as $institution)
                            <div class="form-check">
                                {!! Form::checkbox('institutions[]', $institution['uuid'], false, ['class' => 'form-check-input institution-checkbox', 'id' => $institution['uuid'], 'wire:model.defer' => 'institutions' ]) !!}
                                <label class="form-check-label" for="{{$institution['uuid']}}">{{$institution['name']}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script type='text/javascript'>

$(document).ready(function(){

    var enable_check_all = 1;

    $('#client-settings').on('click', "#checkall", function(){

        if (enable_check_all)
        {
            if(this.checked){
                $('.institution-checkbox').each(function(){
                    if (!$(this).is(":checked"))
                    {
                        $(this).trigger('click');
                    }
                });
            }else{
                $('.institution-checkbox').each(function(){
                    if ($(this).is(":checked"))
                    {
                        $(this).trigger('click');
                    }
                });
            }
        }
    });

    $('#client-settings').on('click', ".institution-checkbox", function(){
        if ($('.institution-checkbox:checked').length == $('.institution-checkbox').length){
            if (!$('#checkall').is(":checked"))
            {
                enable_check_all = 0;
                $('#checkall').trigger('click');
            }
        } else {
            console.log(2);
            if ($('#checkall').is(":checked"))
            {
                enable_check_all = 0;
                $('#checkall').trigger('click');
            }
        }
        enable_check_all = 1;
    });
});

</script>
@endpush

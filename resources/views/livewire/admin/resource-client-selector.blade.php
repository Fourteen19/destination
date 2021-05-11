<div class="form-group">
    <div class="form-check mb-3 border-top pt-3">
        {!! Form::checkbox('all_clients', 'Y', ($all_clients == 'Y') ? True : False, ['class' => 'form-check-input', 'id' => 'all_clients', 'wire:model.defer' => 'all_clients' ]) !!}
        <label class="form-check-label" for="all_clients">
        {!! Form::label('all_clients', 'Allocate this resource to all current and future clients'); !!}
        </label>
    </div>

    <div class="form-group mb-3 border-top pt-3" id="clients" @if ($all_clients == 'Y') style="display:none" @endif>
        {!! Form::label('clients', 'Select specific clients'); !!}
        @foreach($clientsList as $key => $client)
            <div class="form-check">
            {!! Form::checkbox('clients[]', $client['uuid'], False, ['class' => 'form-check-input', 'id' => $client['uuid'], 'wire:model.defer' => 'clients']) !!}
            <label class="form-check-label" for="{{$client['uuid']}}">
            {{$client['name']}}
            </label>
            </div>
        @endforeach
    </div>

</div>

@push('scripts')
<script>

    $("#all_clients").click(function(){
        if ($(this).is(':checked')) {
            $("#clients").hide();
        } else {
            $("#clients").show();
        }
    });

</script>
@endpush

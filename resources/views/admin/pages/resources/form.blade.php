<div class="row">
    <div class="col-lg-6">

        <div class="form-group{{ $errors->has('filename') ? ' has-error' : '' }}">
            {!! Form::label('filename', 'Provide a file name or title e.g. Activity Lesson Plan'); !!}
            {!! Form::text('filename', null, array('placeholder' => 'File name', 'class' => 'form-control', 'maxlength' => 255, 'id' => "filename")) !!}
        </div>

        @if (isGlobalAdmin())
            @livewire('admin.resource-client-selector', ['allClientsParam' => (!empty(old('all_clients'))) ? old('all_clients') : $resource->all_clients,
                                                         'clientsParam' => (!empty(old('clients'))) ? old('clients') : $resource->clients,
                                                         ])
        @endif

        <div class="border-top pt-3 form-group{{ $errors->has('customFile') ? ' has-error' : '' }}">
            {!! Form::label('customFile', 'Upload file'); !!}
            <div class="input-group">
                {!! Form::text('customFile_label', ($action == 'edit') ? $resource->getFirstMedia('resource')->getCustomProperty('folder') : '', array('placeholder' => 'File', 'class' => 'form-control', 'maxlength' => 255, 'id' => "customFile_label")) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="customFile">Select</button>
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Add a description of the file'); !!}
            {!! Form::textarea('description', null, array('placeholder' => 'Add a description', 'rows' => 5, 'cols' => 40, 'class' => 'form-control')) !!}
        </div>


        <div class="form-group">
            <div class="form-check mb-3 border-top pt-3">
                {!! Form::checkbox('work_experience', 'Y', ($resource->work_experience == 'Y') ? True : False, ['class' => 'form-check-input', 'id' => 'work_experience' ]) !!}
                <label class="form-check-label" for="all_clients">
                {!! Form::label('work_experience', 'This resource is work experience related'); !!}
                </label>
            </div>
        </div>


        @if ($action == 'edit')

            <div class="form-group">
                {!! Form::label('uploaded_by', 'Last updated by'); !!}
                {!! Form::text('uploaded_by', $resource->admin->fullName, array('placeholder' => 'Admin name', 'class' => 'form-control', 'maxlength' => 255, 'readonly')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('updated_at', 'Last Updated date'); !!}
                {!! Form::text('updated_at', \Carbon\Carbon::parse($resource->updated_at)->format('d/m/Y H:i:s') , array('placeholder' => 'Date of upload', 'class' => 'form-control', 'maxlength' => 255, 'readonly')) !!}
            </div>

        @endif


    </div>
</div>


<div class="row">
    <button type="submit" class="btn mydir-button mr-2">Save And Exit</button>
</div>



@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush


@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('customFile').addEventListener('click', (event) => {
        event.preventDefault();
        window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        document.getElementById('customFile_label').value = $url;
    }

</script>
@endpush

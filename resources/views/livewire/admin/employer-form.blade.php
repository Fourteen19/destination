<div>

    

        @include('livewire.admin.includes.employers.employer-details')

    

    @include('livewire.admin.includes.employers.submit')

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.employers.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>

    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-employer-logo').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'logo';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });


    // set file link
    function fmSetLink($url) {
        if (inputId == 'logo'){
            livewire.emit('make_employer_logo_image', $url);
        }
    }


</script>
@endpush

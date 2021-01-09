@push('scripts')
    <script type="text/javascript">

        function display_client_dropdown(display){

            if (display == true){
                $("#client_container").show();
            } else {
                $("#client_container").hide();
            }
        }

        function display_institution_dropdown(display){
            if (display == true){
                $("#institution_container").show();
            } else {
                $("#institution_container").hide();
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $("#role").change(function(){

            console.log( $(this).val() );
            get_clients = false;

            display_client_dropdown(false);
            display_institution_dropdown(false);

            @role('System Administrator', 'admin')

                if ( $(this).val() == ''){
                    display_client_dropdown(false);
                    display_institution_dropdown(false);
                    get_clients = false;
                } else if ( $(this).val() == 'Advisor'){
                    display_client_dropdown(true);
                    display_institution_dropdown(true);
                    get_clients = true;
                } else if ( $(this).val() == 'Client Admin'){
                    display_client_dropdown(true);
                    display_institution_dropdown(false);
                    get_clients = true;
                } else if ( $(this).val() == 'Client Content Admin'){
                    display_client_dropdown(true);
                    display_institution_dropdown(false);
                    get_clients = true;
                } else if ( $(this).val() == 'Global Content Admin'){
                    display_client_dropdown(false);
                    display_institution_dropdown(false);
                } else if ( $(this).val() == 'System Administrator'){
                    display_client_dropdown(false);
                    display_institution_dropdown(false);
                } else if ( $(this).val() == 'Third Party Admin'){
                    display_client_dropdown(true);
                    display_institution_dropdown(false);
                    get_clients = true;
                }

            @elserole('Client Admin', 'admin')

                display_client_dropdown(false);
                display_institution_dropdown(false);
                get_clients = false;

                if ( $(this).val() == 'Advisor'){
                    display_institution_dropdown(true);
                }

            @endrole


            if (get_clients == true){

                $('#client').empty();
                $('#institution').empty();

                $.ajax({
                    url: "{{ route('admin.getClient') }}",
                    method: 'POST',
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#client').append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                });

            }
        });


        @role('System Administrator|Client Admin', 'admin')

            $("#client").change(function(){

                @role('System Administrator', 'admin')

                    formdata = { uuid : $("#client").val() };

                @elserole('Client Admin', 'admin')

                    {{-- formdata = { uuid : {{ $admin->client->uuid }}; --}}
                    formdata = { uuid : '1234' };

                @endrole


                $('#institution').empty();
                $.ajax({
                    url: "{{ route('admin.getInstitution') }}",
                    method: 'POST',
                    dataType: "json",
                    data: formdata,
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#institution ').append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                });
            });

        @endrole


    </script>
@endpush

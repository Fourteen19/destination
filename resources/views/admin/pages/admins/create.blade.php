@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.admins.index') }}"> Back</a>
        </div>
    </div>
</div>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{!! Form::open(array('route' => 'admin.admins.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Last Name:</strong>
            {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control'))
            !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('role', $roles,[], array('class' => 'form-control', 'id' => 'role')) !!}
        </div>
    </div>

    @role('System Administrator', 'admin')
        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none" id="client_container">
            <div class="form-group">
                <strong>Client:</strong>
                {!! Form::select('client', $clients = [],[], array('class' => 'form-control', 'id' => 'client')) !!}
            </div>
        </div>
    @endrole

    @role('System Administrator|Client Admin', 'admin')
        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none" id="institution_container">
            <div class="form-group">
                <strong>Institution:</strong>
                {!! Form::select('institution[]', $institutions = [],[], array('class' => 'form-control', 'id' => 'institution', 'multiple')) !!}
            </div>
        </div>
    @endrole



    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

@endsection



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

                    //formdata = { uuid : {{ $admin->client->uuid }};
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
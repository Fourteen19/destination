@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">User Batch Transfer</h1>

    <p>The table below lists the users for the selected institution (that belongs to the selected client above). Use the filter to change institution and the keyword search to find a user by name.</p>

    @include('admin.pages.includes.modal')

    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter users</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])
                    @endif

                </form>
            </div>
        </div>

    @endif


    <table id="user_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>



    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Transfer to institution</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="batch-tranfer-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.datatable-institution-transfer', ['institution' => session()->get('institution_filter'), 'displayTransferButton' => 'N'])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-institution-transfer', ['institution' => session()->get('institution_filter'), 'displayTransferButton' => 'N'])
                    @endif

                </form>
            </div>
        </div>

    @endif


</div>
@endsection


@push('scripts')
<script src="{{ asset('admin/js/pages/users/list.js')}}"></script>

<script type="text/javascript">
    $(function () {

        var oTable = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 350,
            paging: false,
            @if (session()->get('adminAccessLevel') != 1)
                deferLoading: 0,
            @endif
            ajax: {
                url: "{{ route('admin.users.batch-transfer') }}",
                data: function (d) {
                    d.institution = $('#institution').val();
                }
            },
            columns: [
                {data: 'select', name: 'select', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'email', name: 'email', orderable: true, searchable: true},
            ],
        });

        //datatable filter triggered on return
        $('#user_table').dataTable().fnFilterOnReturn();


        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

        @if (!empty(session()->get('institution_filter')))
            oTable.draw();
        @endif


        $(document).on('change', '.chck', function(){
            //console.log($(this).val());
            var allVals = [];
            $('.chck:checked').each(function () {
                allVals.push($(this).val());
            });
            livewire.emit('userAdded', allVals);
            //alert(allVals);
        });

        /* $(".chk").on("change", "input[type='checkbox']", function (e) {
            console.log(e.attr('name'));

        }); */

/*         $(".chk").change(function(e){
            count_batch()
        }); */

        function count_batch(){
            var inputElems = document.getElementsByTagName("users[]");
            console.log(inputElems);
            count = 0;
            for (var i=0; i<inputElems.length; i++) {
                if (inputElems[i].type === "checkbox" && inputElems[i].checked === true){
                    count++;
                }
            }
            console.log(count);
        }



    });

</script>
@endpush

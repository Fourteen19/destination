@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">Edit Reporting Tag</h1>
            <p class="mydir-instructions">Use this screen to edit the selected reporting tag.</p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <form >

<div class="row">
     <div class="col-lg-6">

        <div class="form-group">
            <label for="name">Name</label>
            <input placeholder="Name" class="form-control" maxlength="255" name="name" type="text" id="name">
        </div>

        <div class="form-group">
            <label for="live">Live</label>
            <select class="form-control" id="live" name="live"><option value="Y">Yes</option><option value="N">No</option></select>
        </div>

     </div>
 </div>


<div class="row">
<button type="button" class="btn mydir-button mr-2">Submit</button>
</div>

</form>


<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            <a class="mydir-action" href="{{ route('admin.client-reporting-tags.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>

@endsection

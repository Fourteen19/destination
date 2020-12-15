@extends('frontend.layouts.loggedin')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="border-left ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Edit my details</h1>
            <p>You can use the form below to update your details. Not all of your details can be edited. If any of the information is incorrect then you can <a href="{{ route('frontend.my-account.contact-my-adviser.edit') }}">contact your adviser</a> or your school to request that they are changed.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <form>
                    <div class="form-group">
                        <label for="Firstname">First name</label>
                        <input type="text" class="form-control form-control-lg" id="Firstname" placeholder="[Users First Name]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Surname">Surname</label>
                        <input type="text" class="form-control form-control-lg" id="Surname" placeholder="[Users Surname]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Dateofbirth">Date of birth</label>
                        <input type="text" class="form-control form-control-lg" id="Dateofbirth" placeholder="[Users Date of birth]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="SchoolorCollege">School or College</label>
                        <input type="text" class="form-control form-control-lg" id="SchoolorCollege" placeholder="[Users Institution]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="SchoolYear">School Year</label>
                        <input type="text" class="form-control form-control-lg" id="SchoolYear" placeholder="[Users School Year]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Postcode">Postcode</label>
                        <input type="text" class="form-control form-control-lg" id="Postcode" placeholder="[Users Postcode]">
                    </div>
                    <div class="form-group">
                        <label for="Schoolemailaddress">School email address</label>
                        <input type="email" class="form-control form-control-lg" id="Schoolemailaddress " placeholder="[Users School email address]" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Personalemailaddress">Personal email address</label>
                        <input type="email" class="form-control form-control-lg" id="Personalemailaddress " placeholder="[Users Personal email address]">
                    </div>
                    <button type="submit" class="platform-button border-0 t-def mt-5">
                        Save
                    </button>

                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  


@endsection

@extends('frontend.layouts.loggedin')

@section('content')
<div class="row p-w">
    @include('frontend.pages.includes.account-menu')
    <div class="col-lg-9">
        <div class="border-left ml-lg-4 pl-lg-5 def-border">
            <h1 class="t36 fw700 mb-4">Contact my adviser</h1>
            <p>You can use the form below to contact your adviser or ask them a question.</p>
            <div class="row">
                <div class="col">
                    <div class="border-top def-border w-100 mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <form class="pb-5">
                    <div class="form-group">
                        <label for="Whatsyourquestion">Whats your question about?</label>
                        <select class="form-control form-control-lg" id="Whatsyourquestion">
                            <option>How to use the website</option>
                            <option>Careers advice</option>
                            <option>GCSE Options</option>
                            <option>A-level Options</option>
                            <option>Something else</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Yourquestion">Your question</label>
                        <textarea class="form-control form-control-lg" id="Yourquestion" rows="6"></textarea>
                    </div>
                    <button type="submit" class="platform-button border-0 t-def mt-5">
                        Send your message
                    </button>

                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

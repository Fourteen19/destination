@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">View User Data for [User FirstName] [User Surname] @ [Institution Name]</h1>
            <p class="mydir-instructions">The page below provides current and historic data about this user.</p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


    <form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#careers-readiness">Careers Readiness</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#self">Self Assessment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tags">Tag Scoring</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#keywords">Keywords history</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#articles">Articles Read</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#stats">Other Statistics</a>
        </li> 
    </ul>


<!-- Tab panes -->
    <div class="tab-content">

        <div id="careers-readiness" class="tab-pane active">
            <div class="row">
                <div class="col-lg-8">

                <p>The information below shows the careers readiness score for this user for each year they have used the system. Click on the score to see a break down of the users answers in the careers readiness assessment.</p>

                <div class="accordion" id="cr-stats">
    <div class="card">
        <div class="card-header stat-header" id="y7-heading">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left stat-button" type="button" data-toggle="collapse" data-target="#y7-stats" aria-expanded="true" aria-controls="y7-stats">
                <b>Year 7</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
                </button>
            </h2>
        </div>
        <div id="y7-stats" class="collapse show" aria-labelledby="y7-heading" data-parent="#cr-stats">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Question</th>
                        <th scope="col">Score</th>
                        <th scope="col">Statement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>I feel confident about my future</td>
                        <td>[Score]</td>
                        <td>Strongly agree</td>
                        </tr>            
                        
                        <tr>
                        <td>I understand the all the different career options and choices</td>
                        <td>[Score]</td>
                        <td>Agree</td>
                        </tr>
                        
                        <tr>
                        <td>I make good decisions and choices</td>
                        <td>[Score]</td>
                        <td>Neither agree or disagree</td>
                        </tr>

                        <tr>
                        <td>I know what I need to do to achieve my career goals</td>
                        <td>[Score]</td>
                        <td>Disagree</td>
                        </tr>

                        <tr>
                        <td>I am worried I won’t be able to achieve my career goals</td>
                        <td>[Score]</td>
                        <td>Strongly disagree</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header stat-header" id="y8-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y8-stats" aria-expanded="false" aria-controls="y8-stats">
                <b>Year 8</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y8-stats" class="collapse" aria-labelledby="y8-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header stat-header" id="y9-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y9-stats" aria-expanded="false" aria-controls="y9-stats">
                <b>Year 9</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y9-stats" class="collapse" aria-labelledby="y9-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header stat-header" id="y10-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y10-stats" aria-expanded="false" aria-controls="y10-stats">
                <b>Year 10</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y10-stats" class="collapse" aria-labelledby="y10-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header stat-header" id="y11-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y11-stats" aria-expanded="false" aria-controls="y11-stats">
                <b>Year 11</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y11-stats" class="collapse" aria-labelledby="y11-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header stat-header" id="y12-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y12-stats" aria-expanded="false" aria-controls="y12-stats">
                <b>Year 12</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y12-stats" class="collapse" aria-labelledby="y12-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header stat-header" id="y13-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#y13-stats" aria-expanded="false" aria-controls="y13-stats">
                <b>Year 13</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
            </button>
        </h2>
        </div>
        <div id="y13-stats" class="collapse" aria-labelledby="y13-heading" data-parent="#cr-stats">
        <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Question</th>
                <th scope="col">Score</th>
                <th scope="col">Statement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>I feel confident about my future</td>
                <td>[Score]</td>
                <td>Strongly agree</td>
                </tr>            
                
                <tr>
                <td>I understand the all the different career options and choices</td>
                <td>[Score]</td>
                <td>Agree</td>
                </tr>
                
                <tr>
                <td>I make good decisions and choices</td>
                <td>[Score]</td>
                <td>Neither agree or disagree</td>
                </tr>

                <tr>
                <td>I know what I need to do to achieve my career goals</td>
                <td>[Score]</td>
                <td>Disagree</td>
                </tr>

                <tr>
                <td>I am worried I won’t be able to achieve my career goals</td>
                <td>[Score]</td>
                <td>Strongly disagree</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    
    <div class="card">
            <div class="card-header stat-header" id="post-heading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left stat-button collapsed" type="button" data-toggle="collapse" data-target="#post-stats" aria-expanded="false" aria-controls="post-stats">
                        <b>Post</b> <span class="stat-text">| Average score:</span> <b>3.2</b>
                    </button>
                </h2>
            </div>
            <div id="post-stats" class="collapse" aria-labelledby="post-heading" data-parent="#cr-stats">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Score</th>
                                <th scope="col">Statement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>I feel confident about my future</td>
                                <td>[Score]</td>
                                <td>Strongly agree</td>
                            </tr>                
                            <tr>
                                <td>I understand the all the different career options and choices</td>
                                <td>[Score]</td>
                                <td>Agree</td>
                            </tr>
                            <tr>
                                <td>I make good decisions and choices</td>
                                <td>[Score]</td>
                                <td>Neither agree or disagree</td>
                            </tr>
                            <tr>
                                <td>I know what I need to do to achieve my career goals</td>
                                <td>[Score]</td>
                                <td>Disagree</td>
                            </tr>
                            <tr>
                                <td>I am worried I won’t be able to achieve my career goals</td>
                                <td>[Score]</td>
                                <td>Strongly disagree</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

            </div>
        </div>
    </div>


    <div id="self" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

                <p>The data below shows the users selections from their self assessment.</p>

                <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Routes</h2>

                <ul class="list-group">
                <li class="list-group-item">[Route]</li>
                <li class="list-group-item">[Route]</li>
                <li class="list-group-item">[Route]</li>
                </ul>

                <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Subects</h2>

                <ul class="list-group">
                <li class="list-group-item">[Subject]</li>
                <li class="list-group-item">[Subject]</li>
                <li class="list-group-item">[Subject]</li>
                </ul>

                <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Sectors</h2>

                <ul class="list-group">
                <li class="list-group-item">[Sector]</li>
                <li class="list-group-item">[Sector]</li>
                <li class="list-group-item">[Sector]</li>
                </ul>

            </div>
        </div>
    </div>

    <div id="tags" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-6">

            <p>The data below shows the scores accumulated by the user via their interaction with platform articles.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Routes</th>
                        <th scope="col" width="10%">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Route]</td>
                        <td>[Score]</td>
                    </tr>                
                    <tr>
                        <td>[Route]</td>
                        <td>[Score]</td>
                    </tr> 
                    <tr>
                        <td>[Route]</td>
                        <td>[Score]</td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-split"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Subjects</th>
                        <th scope="col" width="10%">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Subject]</td>
                        <td>[Score]</td>
                    </tr>                
                    <tr>
                        <td>[Subject]</td>
                        <td>[Score]</td>
                    </tr> 
                    <tr>
                        <td>[Subject]</td>
                        <td>[Score]</td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-split"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sectors</th>
                        <th scope="col" width="10%">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Sector]</td>
                        <td>[Score]</td>
                    </tr>                
                    <tr>
                        <td>[Sector]</td>
                        <td>[Score]</td>
                    </tr> 
                    <tr>
                        <td>[Sector]</td>
                        <td>[Score]</td>
                    </tr> 
                </tbody>
            </table>

            </div>
        </div>
    </div>

    <div id="keywords" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

            <p>The data below shows the keywords the user has selected via the suggestions provided in the keyword search, where the user then went on to read an article.</p>

                <h2 class="border-bottom pb-2 mb-4 mt-4">Selected Keywords</h2>

                <ul class="list-group">
                <li class="list-group-item">[Keyword]</li>
                <li class="list-group-item">[Keyword]</li>
                <li class="list-group-item">[Keyword]</li>
                <li class="list-group-item">[Keyword]</li>
                <li class="list-group-item">[Keyword]</li>
                <li class="list-group-item">[Keyword]</li>
                </ul>
            

            </div>
        </div>
    </div>

    <div id="articles" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-4">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Total number of articles viewed:</th>
                        <th scope="col" width="10%">[Total]</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
            <div class="form-split"></div>
            <p>The data below shows the articles the user has clicked on the last 12 months.</p>

                <h2 class="border-bottom pb-2 mb-4 mt-4">Article titles</h2>

                <ul class="list-group">
                <li class="list-group-item">[Article title]</li>
                <li class="list-group-item">[Article title]</li>
                <li class="list-group-item">[Article title]</li>
                <li class="list-group-item">[Article title]</li>
                <li class="list-group-item">[Article title]</li>
                <li class="list-group-item">[Article title]</li>
                </ul>
            
            </div>
        </div>
    </div>

    <div id="stats" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-6">
                <p>The data below shows general statistics for the user.</p>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Total number of red flag articles viewed:</th>
                            <th scope="col" width="20%">[Total]</th>
                        </tr>
                        <tr>
                            <th scope="col">Total number of times logged in:</th>
                            <th scope="col" width="20%">[Total]</th>
                        </tr>
                        <tr>
                            <th scope="col">Date system was last accessed:</th>
                            <th scope="col" width="20%">[Date]</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>


</form>


    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.users.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

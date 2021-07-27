@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between">
        <div class="col mb-5">
            <h1>Welcome {{ Auth::guard('admin')->user()->first_name }}</h1>
            <h2>You are logged in - your role is: {{ Auth::guard('admin')->user()->getRoleNames()->first() }}</h2>
        </div>
        <div class="col text-right">
            <a href="{{ route('admin.dashboard') }}#viewstats" class="mydir-action"><i class="fas fa-chart-bar mr-2"></i>View Stats</a>
        </div>

    </div>

</div>




<div class="container-fluid">

        @include('admin.pages.includes.menu')

</div>

<div class="container-fluid" id="viewstats">
    <div class="row">
        <div class="col-12">
            <div class="stats-outer mt-4 p-3">
                <div class="row">
                    <div class="col-12"><div class="border-bottom md-border pb-2 mb-4"><small>Last updated: 27/07/21</small></div></div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="table-title">Top 10 articles in the last 30 days</h3>
                        <table class="table stats-table">
                            <tr>
                                <th width="5%">#</th>
                                <th>Article Title</th>
                                <th width="10%">Views</th>
                            </tr>
                            <tr class="odd">
                                <td>1.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>3.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>5.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>7.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>9.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>10.</td>
                                <td>An article title</td>
                                <td>123456</td>
                            </tr>
                        </table>    
                    </div>
                    <div class="col-lg-4">
                    <h3 class="table-title">5 most active institutions <span class="fw300">(last 30 days)</span></h3>
                        <table class="table stats-table">
                            <tr>
                                <th width="5%">#</th>
                                <th>Institutions</th>
                                <th width="10%">Logins</th>
                            </tr>
                            <tr class="odd">
                                <td>1.</td>
                                <td>Institution Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Institution Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>3.</td>
                                <td>Institution Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Institution Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>5.</td>
                                <td>Institution Name</td>
                                <td>123456</td>
                            </tr>
                        </table> 
                        
                        <h3 class="table-title mt-4">Total number of logins</h3>
                        <table class="table stats-table">
                            <tr class="odd">
                                <td>Yesterday</td>
                                <td width="5%">123456</td>
                            </tr>
                            <tr>
                                <td>Last 7 days</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>Last 30 days</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>This academic year</td>
                                <td>123456</td>
                            </tr>
                        </table> 

                    </div>
                    <div class="col-lg-4">
                    <h3 class="table-title">5 most popular vacancies <span class="fw300">(last 30 days)</span></h3>
                        <table class="table stats-table">
                            <tr>
                                <th width="5%">#</th>
                                <th>Vacancy title</th>
                                <th width="10%">Views</th>
                            </tr>
                            <tr class="odd">
                                <td>1.</td>
                                <td>Vacancy Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Vacancy Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>3.</td>
                                <td>Vacancy Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Vacancy Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>5.</td>
                                <td>Vacancy Name</td>
                                <td>123456</td>
                            </tr>
                        </table>
                        
                        <h3 class="table-title mt">5 most popular events <span class="fw300">(last 30 days)</span></h3>
                        <table class="table stats-table">
                            <tr>
                                <th width="5%">#</th>
                                <th>Event title</th>
                                <th width="10%">Views</th>
                            </tr>
                            <tr class="odd">
                                <td>1.</td>
                                <td>Event Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Event Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>3.</td>
                                <td>Event Name</td>
                                <td>123456</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Event Name</td>
                                <td>123456</td>
                            </tr>
                            <tr class="odd">
                                <td>5.</td>
                                <td>Event Name</td>
                                <td>123456</td>
                            </tr>
                        </table> 

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

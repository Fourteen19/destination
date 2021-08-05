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
                    <div class="col-12"><div class="border-bottom md-border pb-2 mb-4"><small>Last updated: {{\Carbon\Carbon::parse($dashboardStats['created_at'])->format('d/m/Y')}}</small></div></div>
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
                            @for ($i = 1; $i <= 10; $i++)
                                <tr @if ($i % 2 != 0) class="odd" @endif >
                                    <td>{{$i}}.</td>
                                    <td>{{$dashboardStats['top_article_'.$i]}}</td>
                                    <td>{{ (empty($dashboardStats['top_article_'.$i.'_views'])) ? '' : $dashboardStats['top_article_'.$i.'_views'] }}</td>
                                </tr>
                            @endfor
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
                            @for ($i = 1; $i <= 5; $i++)
                                <tr @if ($i % 2 != 0) class="odd" @endif >
                                    <td>{{$i}}.</td>
                                    <td>{{$dashboardStats['top_institution_'.$i]}}</td>
                                    <td>{{ (empty($dashboardStats['top_institution_'.$i.'_views'])) ? '' : $dashboardStats['top_institution_'.$i.'_views'] }}</td>
                                </tr>
                            @endfor
                        </table>

                        <h3 class="table-title mt-4">Total number of logins</h3>
                        <table class="table stats-table">
                            <tr class="odd">
                                <td>Yesterday</td>
                                <td>{{$dashboardStats['logins-1']}}</td>
                            </tr>
                            <tr>
                                <td>Last 7 days</td>
                                <td>{{$dashboardStats['logins-7']}}</td>
                            </tr>
                            <tr class="odd">
                                <td>Last 30 days</td>
                                <td>{{$dashboardStats['logins-30']}}</td>
                            </tr>
                            <tr>
                                <td>This academic year</td>
                                <td>{{$dashboardStats['logins-academic-year']}}</td>
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
                            @for ($i = 1; $i <= 5; $i++)
                                <tr @if ($i % 2 != 0) class="odd" @endif >
                                    <td>{{$i}}.</td>
                                    <td>{{$dashboardStats['top_vacancy_'.$i]}}</td>
                                    <td>{{ (empty($dashboardStats['top_vacancy_'.$i.'_views'])) ? '' : $dashboardStats['top_vacancy_'.$i.'_views'] }}</td>
                                </tr>
                            @endfor
                            </tr>
                        </table>

                        <h3 class="table-title mt">5 most popular events <span class="fw300">(last 30 days)</span></h3>
                        <table class="table stats-table">
                            <tr>
                                <th width="5%">#</th>
                                <th>Event title</th>
                                <th width="10%">Views</th>
                            </tr>
                            @for ($i = 1; $i <= 5; $i++)
                                <tr @if ($i % 2 != 0) class="odd" @endif >
                                    <td>{{$i}}.</td>
                                    <td>{{$dashboardStats['top_event_'.$i]}}</td>
                                    <td>{{ (empty($dashboardStats['top_event_'.$i.'_views'])) ? '' : $dashboardStats['top_event_'.$i.'_views'] }}</td>
                                </tr>
                            @endfor
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

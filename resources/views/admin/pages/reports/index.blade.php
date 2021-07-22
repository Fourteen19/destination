@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
        <h1 class="mb-4">Preset Reports</h1>

        <p>Click on the required report below to set the specific filter parameters.</p>

        @include('admin.pages.includes.modal')

        @include('admin.pages.includes.flash-message')

            <a href="{{ route('admin.reports.user-data') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>All user data by Institution</h2>
                <p class="mb-0">This report contains all the user data for a specific institution, sorted alphanumerically by name.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.not-logged-in') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Users who have not used the system by Institution</h2>
                <p class="mb-0">This report contains a list of all  the users who have an account but have not accessed the system for a specific institution.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.articles') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Article report</h2>
                <p class="mb-0">This report shows the performance of articles.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.career-readiness') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Self Assessment Careers Readiness data per institution</h2>
                <p class="mb-0">This report shows a percentage breakdown per year for this area of the self assessment. As well as the overall CRS bandings, for each question  percentage data is provided showing the users who fall into this category.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.sectors') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Self Assessment Sector data per institution</h2>
                <p class="mb-0">This report shows a percentage breakdown per year for this area of the self assessment. As well as the overall CRS bandings, for each question  percentage data is provided showing the users who fall into this category.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.subjects') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Self Assessment Subject data per institution</h2>
                <p class="mb-0">This report shows a percentage breakdown per year for this area of the self assessment. As well as the overall CRS bandings, for each question  percentage data is provided showing the users who fall into this category.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.routes') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Self Assessment Route data per institution</h2>
                <p class="mb-0">This report shows a percentage breakdown per year for this area of the self assessment. As well as the overall CRS bandings, for each question  percentage data is provided showing the users who fall into this category.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.keywords') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Keywords report</h2>
                <p class="mb-0">This report provides a list showing the popularity of Keywords on the system.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.red-flag') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Red flag Report</h2>
                <p class="mb-0">This report lists the users at an institution who have read a selected red flag article.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.vacancies') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Live Vacancy Report</h2>
                <p class="mb-0">This report provides a list showing the performance of live vacancies accross the system.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>

            <a href="{{ route('admin.reports.events') }}">
            <div class="report-preview">
                <div class="report-prev-inner"><h2>Live Event Report</h2>
                <p class="mb-0">This report provides a list showing the performance of live events accross the system.</p></div>
                <div class="report-arrow"><i class="fas fa-chevron-right fa-3x"></i></div>
            </div>
            </a>
        </div>
    </div>
</div>
@endsection

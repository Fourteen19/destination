@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
        <h1 class="mb-4">All user data by Institution</h1>
        <p>This report contains all the user data for a specific institution, sorted alphanumerically by name.</p>
        <p>Set the filter below and click generate report. To save processing time and impact on the server, your report will be emailed to you when it is ready.</p>

        @include('admin.pages.includes.modal')

        @include('admin.pages.includes.flash-message')
        </div>
    </div>
    <div class="row mt-4">

        <div class="col-lg-8">
            <h2 class="mb-4 border-bottom pb-3"><i class="fas fa-sliders-h mr-3"></i>Set Filter(s)</h2>

            <form wire:submit.prevent="submit">

                @livewire('admin.reporting-users', ['user-data'])

            </form>

            <div class="row">
                <div class="col">
                    <div class="mydir-controls mt-5">
                        <a class="mydir-action" href="{{ route('admin.reports') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
                    </div>
                </div>
            </div>
{{--
            <form>
                <div class="form-group mb-4">
                    <label for="institution">Filter 1 e.g. Institution</label>
                    <select class="form-control" id="institution">
                    <option>Name 1</option>
                    <option>Name 2</option>
                    <option>Name 3</option>
                    <option>Name 4</option>
                    <option>Name 5</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="institution-2">Filter 2</label>
                    <select class="form-control" id="institution-2">
                    <option>Name 1</option>
                    <option>Name 2</option>
                    <option>Name 3</option>
                    <option>Name 4</option>
                    <option>Name 5</option>
                    </select>
                </div>
            </form>
 --}}




        </div>
    </div>
</div>
@endsection

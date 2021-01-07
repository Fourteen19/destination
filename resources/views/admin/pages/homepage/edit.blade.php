@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Public Homepage</h1>
            <p class="mydir-instructions">Use this screen to control all content showing on your public homepage.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#welcome">Welcome Banner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#login">Login Box</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#free">Free Articles</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#preview">Preview</a>
          </li>  
    </ul>


<!-- Tab panes -->
<div class="tab-content">

    <div id="welcome" class="tab-pane active">
        <div class="row">
            <div class="col-lg-6">

                <label>Select banner background image</label>
                <div class="custom-file mb-4">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Select file</label>
                </div>

                <div class="form-group">
                    <label for="banner_title">Banner title</label>
                    <input placeholder="Banner title" class="form-control" maxlength="255" wire:model="banner_title" name="banner_title" type="text" id="banner_title">
                </div>

                <div class="form-group">
                <label for="banner_intro">Banner introduction</label>
                <textarea placeholder="Banner introduction" class="form-control" cols="40" rows="5" wire:model.lazy="banner_intro" name="banner_intro" id="banner_intro"></textarea>
                </div>

                <div class="form-group ">
                <label for="slot1_linktext">Link 1 - Button text</label>
                <input placeholder="Button text i.e. Find out more" class="form-control" cols="40" rows="5" wire:model.lazy="slot1_linktext" name="slot1_linktext" type="text" id="slot1_linktext">
                </div>

                <div class="form-group">
                <label for="slot1_url">Link 1 - destination</label>
                <select class="form-control" wire:model.lazy="slot1_url" id="slot1_url" name="slot1_url">
                    <option value="Please select">Please select</option>
                    <option value="Public page 1">Public Page 1</option>
                    <option value="Public page 2">Public Page 2</option>
                </select>
                </div>

                <div class="form-group ">
                <label for="slot2_linktext">Link 2 - Button text</label>
                <input placeholder="Button text i.e. Find out more" class="form-control" cols="40" rows="5" wire:model.lazy="slot2_linktext" name="slot2_linktext" type="text" id="slot2_linktext">
                </div>

                <div class="form-group">
                <label for="slot2_url">Link 2 - destination</label>
                <select class="form-control" wire:model.lazy="slot2_url" id="slot2_url" name="slot2_url">
                    <option value="Please select">Please select</option>
                    <option value="Public page 1">Public Page 1</option>
                    <option value="Public page 2">Public Page 2</option>
                </select>
                </div>

            </div>
        </div>
    </div>


    <div id="login" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

                <label>Login box image</label>
                <div class="custom-file mb-4">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Select file</label>
                </div>

                <div class="form-group">
                    <label for="login_title">Login heading</label>
                    <input placeholder="Login heading" class="form-control" maxlength="255" wire:model="login_title" name="login_title" type="text" id="login_title">
                </div>

                <div class="form-group">
                <label for="login_intro">Login introduction</label>
                <textarea placeholder="Login introduction" class="form-control" cols="40" rows="5" wire:model.lazy="login_intro" name="login_intro" id="login_intro"></textarea>
                </div>

            </div>
        </div>
    </div>

    <div id="free" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

                
                
                <div class="form-group ">
                <label for="free_heading">Free articles block heading</label>
                <input placeholder="Free articles block heading" class="form-control" cols="40" rows="5" wire:model.lazy="free_heading" name="free_heading" type="text" id="free_heading">
                </div>

                <div class="form-group">
                <label for="free_intro">Free articles introduction</label>
                <textarea placeholder="Login introduction" class="form-control" cols="40" rows="5" wire:model.lazy="free_intro" name="free_intro" id="free_intro"></textarea>
                </div>

                <div class="form-group">
                <label for="suplink">Free article - slot 1</label>
                <select class="form-control" wire:model.lazy="suplink" id="suplink" name="suplink">
                    <option value="Please select">Please select</option>
                    <option value="Article 1">Article 1</option>
                    <option value="Article 1">Article 2</option>
                </select>
                </div>

                <div class="form-group">
                <label for="suplink">Free article - slot 2</label>
                <select class="form-control" wire:model.lazy="suplink" id="suplink" name="suplink">
                    <option value="Please select">Please select</option>
                    <option value="Article 1">Article 1</option>
                    <option value="Article 1">Article 2</option>
                </select>
                </div>

                <div class="form-group">
                <label for="suplink">Free article - slot 3</label>
                <select class="form-control" wire:model.lazy="suplink" id="suplink" name="suplink">
                    <option value="Please select">Please select</option>
                    <option value="Article 1">Article 1</option>
                    <option value="Article 1">Article 2</option>
                </select>
                </div>

            </div>
        </div>
    </div>

    <div id="preview" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

            Preview
            

            </div>
        </div>
    </div>

    

</div>

<div class="row">
    <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>
</div>

</form>

</div>


@endsection

@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Client Static Content</h1>
            <p class="mydir-instructions">From this screen you can control all of the static (or constant) content that appears through out your system. NOTE: Making a change here will instantly publish the changes to the live system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


<form >

<ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#contact-details">Contact details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#legal">Legal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#public-content">Public content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#self-assessment">Self assessment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#loggedin">Logged in content</a>
          </li>  
    </ul>


<!-- Tab panes -->
<div class="tab-content">

    <div id="contact-details" class="tab-pane active">
        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    <label for="tel">Telephone Number</label>
                    <input placeholder="Telephone Number" class="form-control" maxlength="255" wire:model="tel" name="tel" type="tel" id="tel">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input placeholder="Email Address" class="form-control" maxlength="255" wire:model="email" name="email" type="email" id="email">
                </div>

            </div>
        </div>
    </div>


    <div id="legal" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

                <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Terms & Conditions</h2>

                <div wire:ignore>
                <div class="form-group">
                <label for="terms-body">Terms & conditions page body text</label>
                <textarea placeholder="Terms & conditions body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="terms-body" name="terms-body" cols="50" rows="10" id="terms-body"></textarea>
                </div>
                </div>

                <div class="form-split"></div>

                <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Privacy Policy</h2>

                <div wire:ignore>
                <div class="form-group">
                <label for="privacy-body">Privacy policy page body text</label>
                <textarea placeholder="Privacy policy body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="privacy-body" name="privacy-body" cols="50" rows="10" id="privacy-body"></textarea>
                </div>
                </div>

                <div class="form-split"></div>

                <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-balance-scale mr-2"></i>Cookie Policy</h2>

                <div wire:ignore>
                <div class="form-group">
                <label for="cookie-body">Cookie policy page body text</label>
                <textarea placeholder="Cookie policy body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="cookie-body" name="cookie-body" cols="50" rows="10" id="cookie-body"></textarea>
                </div>
                </div>

            </div>
        </div>
    </div>

    <div id="public-content" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

                <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Pre-footer Block</h2>
                
                <div class="form-group ">
                <label for="ppfheading">Heading</label>
                <input placeholder="Heading" class="form-control" cols="40" rows="5" wire:model.lazy="ppfheading" name="ppfheading" type="text" id="ppfheading">
                </div>

                <div wire:ignore>
                <div class="form-group">
                <label for="ppfbody">Block body text</label>
                <textarea placeholder="Block body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="ppfbody" name="ppfbody" cols="50" rows="10" id="ppfbody"></textarea>
                </div>
                </div>

                <div class="form-group ">
                <label for="ppfbuttom">Button text</label>
                <input placeholder="Button text i.e. Find out more" class="form-control" cols="40" rows="5" wire:model.lazy="ppfbuttom" name="ppfbuttom" type="text" id="ppfbuttom">
                </div>

                <div class="form-group">
                <label for="ppflink">Link destination</label>
                <select class="form-control" wire:model.lazy="ppflink" id="ppflink" name="ppflink">
                    <option value="Please select">Please select</option>
                    <option value="Public page 1">Public Page 1</option>
                    <option value="Public page 2">Public Page 2</option>
                </select>
                </div>

            </div>
        </div>
    </div>

    <div id="self-assessment" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

            <div class="form-group">
            <label for="loginintro">Login page introduction</label>
            <textarea placeholder="Login page introduction" class="form-control" cols="40" rows="5" wire:model.lazy="loginintro" name="loginintro" id="loginintro"></textarea>
            </div>

            <div class="form-group">
            <label for="welcomeintro">Welcome screen introduction</label>
            <textarea placeholder="Welcome screen introduction" class="form-control" cols="40" rows="5" wire:model.lazy="welcomeintro" name="welcomeintro" id="welcomeintro"></textarea>
            </div>

            <div class="form-group">
            <label for="crintro">Careers readiness introduction</label>
            <textarea placeholder="Careers readiness introduction" class="form-control" cols="40" rows="5" wire:model.lazy="crintro" name="crintro" id="crintro"></textarea>
            </div>

            <div class="form-group">
            <label for="subjectsintro">Subjects introduction</label>
            <textarea placeholder="Subjects introduction" class="form-control" cols="40" rows="5" wire:model.lazy="subjectsintro" name="subjectsintro" id="subjectsintro"></textarea>
            </div>

            <div class="form-group">
            <label for="routesintro">Routes introduction</label>
            <textarea placeholder="Routes introduction" class="form-control" cols="40" rows="5" wire:model.lazy="routesintro" name="routesintro" id="routesintro"></textarea>
            </div>

            <div class="form-group">
            <label for="sectorsintro">Sectors introduction</label>
            <textarea placeholder="Sectors introduction" class="form-control" cols="40" rows="5" wire:model.lazy="sectorsintro" name="sectorsintro" id="sectorsintro"></textarea>
            </div>

            <div class="form-group">
            <label for="sacompleted">Self assessment completed message</label>
            <textarea placeholder="Self assessment completed message" class="form-control" cols="40" rows="5" wire:model.lazy="sacompleted" name="sacompleted" id="sacompleted"></textarea>
            </div>
            

            </div>
        </div>
    </div>

    <div id="loggedin" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Support Block</h2>
                
                <div class="form-group ">
                <label for="supheading">Heading text</label>
                <input placeholder="Heading" class="form-control" cols="40" rows="5" wire:model.lazy="supheading" name="supheading" type="text" id="supheading">
                </div>

                <div wire:ignore>
                <div class="form-group">
                <label for="supbody">Block body text</label>
                <textarea placeholder="Block body text" class="form-control tiny_body" maxlength="999" wire:model.lazy="supbody" name="supbody" cols="50" rows="10" id="supbody"></textarea>
                </div>
                </div>

                <div class="form-group ">
                <label for="supbuttom">Button text</label>
                <input placeholder="Button text i.e. Find out more" class="form-control" cols="40" rows="5" wire:model.lazy="supbuttom" name="supbuttom" type="text" id="supbuttom">
                </div>

                <div class="form-group">
                <label for="suplink">Link destination</label>
                <select class="form-control" wire:model.lazy="suplink" id="suplink" name="suplink">
                    <option value="Please select">Please select</option>
                    <option value="Logged in page 1">Logged in Page 1</option>
                    <option value="Logged page 2">Logged in Page 2</option>
                </select>
                </div>

                <div class="form-split"></div>

                <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-cube mr-2"></i>Getting it right Block</h2>

                <div class="form-group ">
                <label for="grheading">Heading text</label>
                <input placeholder="Heading" class="form-control" cols="40" rows="5" wire:model.lazy="grheading" name="grheading" type="text" id="grheading">
                </div>

                <div class="form-group">
                <label for="grtext">Block text</label>
                <textarea placeholder="Block text" class="form-control" cols="40" rows="5" wire:model.lazy="grtext" name="grtext" id="grtext"></textarea>
                </div>
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

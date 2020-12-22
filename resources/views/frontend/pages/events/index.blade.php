@extends('frontend.layouts.master')

@section('content')
<div class="row justify-content-center mt-5 r-sep">
        <div class="col-lg-8">
           <div class="pt-4">
           <h1 class="fw700 t36">Events</h1>
           <div class="form-check form-check-inline">
           <label class="form-check-label mr-3 t20 fw700">Filter all events:</label>
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
            <label class="form-check-label t20 fw700" for="inlineRadio1">Best Match for me</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
            <label class="form-check-label t20 fw700" for="inlineRadio2">All events</label>
            </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border-left def-border pl-4 pt-4 pb-4">
            <h2 class="t24 fw700">Search for an event</h2>
            <form class="form-inline">
            
            <div class="form-group mr-3">
                <label for="searchevents" class="sr-only">Search for an event</label>
                <input type="field" class="form-control" id="searchevents" placeholder="Enter keywords">
            </div>
            <button type="submit" class="platform-button border-0 t-def">Search</button>
            </form>
            </div>
        </div>
    </div>

<div class="row r-pad r-sep">
    <div class="col-12">
        <h2 class="t30 fw700 mb-0">Upcoming</h2>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-3 col-md-3 col-lg-3">
        <a href="/events/an-event" class="td-no">    
			<div class="w-bg">
                <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                <div class="row no-gutters">
					<div class="col-8">
                        <div class="article-summary mlg-bg mbh-1">
                        <h4 class="fw700 t20">Event title</h4>
                        <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                        </div>
					</div>
					<div class="col-4">
						<div class="event-summary p-3 w-bg t-up text-center fw700">
                            <div class="row">
                                <div class="col t48">
                                    29
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t24">
                                    Sept
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="split border-top def-border w-100"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t16">
                                    <span>Starts:<br>
                                    12:59 PM</span>
                                </div>
                            </div>
						</div>
					</div>
                </div>
            </div>
		</a>
    </div>
    <div class="col-sm-3 col-md-3 col-lg-3">
        <a href="#" class="td-no">    
			<div class="w-bg">
                <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                <div class="row no-gutters">
					<div class="col-8">
                        <div class="article-summary mlg-bg mbh-1">
                        <h4 class="fw700 t20">Event title</h4>
                        <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                        </div>
					</div>
					<div class="col-4">
						<div class="event-summary p-3 w-bg t-up text-center fw700">
                            <div class="row">
                                <div class="col t48">
                                    29
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t24">
                                    Sept
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="split border-top def-border w-100"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t16">
                                    <span>Starts:<br>
                                    12:59 PM</span>
                                </div>
                            </div>
						</div>
					</div>
                </div>
            </div>
		</a>
    </div>
    <div class="col-sm-3 col-md-3 col-lg-3">
        <a href="#" class="td-no">    
			<div class="w-bg">
                <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                <div class="row no-gutters">
					<div class="col-8">
                        <div class="article-summary mlg-bg mbh-1">
                        <h4 class="fw700 t20">Event title</h4>
                        <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                        </div>
					</div>
					<div class="col-4">
						<div class="event-summary p-3 w-bg t-up text-center fw700">
                            <div class="row">
                                <div class="col t48">
                                    29
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t24">
                                    Sept
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="split border-top def-border w-100"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t16">
                                    <span>Starts:<br>
                                    12:59 PM</span>
                                </div>
                            </div>
						</div>
					</div>
                </div>
            </div>
		</a>
    </div>
    <div class="col-sm-3 col-md-3 col-lg-3">
        <a href="#" class="td-no">    
			<div class="w-bg">
                <img src="https://via.placeholder.com/740x440.png?text=Event+Image">
                <div class="row no-gutters">
					<div class="col-8">
                        <div class="article-summary mlg-bg mbh-1">
                        <h4 class="fw700 t20">Event title</h4>
                        <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                        </div>
					</div>
					<div class="col-4">
						<div class="event-summary p-3 w-bg t-up text-center fw700">
                            <div class="row">
                                <div class="col t48">
                                    29
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t24">
                                    Sept
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="split border-top def-border w-100"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col t16">
                                    <span>Starts:<br>
                                    12:59 PM</span>
                                </div>
                            </div>
						</div>
					</div>
                </div>
            </div>
		</a>
    </div>     
        
</div>

<div class="row r-pad r-sep">
    <div class="col-12">
        <h2 class="t30 fw700 mb-0">Future Events</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
    <div class="col-lg-4 mb-4">
       <a href="#" class="td-no">
       <div class="row no-gutters">
           <div class="col-lg-3">
           <div class="square" style="background-image: url('https://via.placeholder.com/737x737/5379a6/ffffff?text=Thumbnail')"></div>
           </div>
           <div class="col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">Inner heading</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">29 Sept 2020</span> | Starts: <span class="fw700">12:59 PM</span></div>
                </div>
           </div>
           <div class="col-lg-2 vlg-bg d-flex align-items-center justify-content-end">
           <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="29px" height="48px">
            <path fill-rule="evenodd" class="def-bg"
            d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
            <path fill-rule="evenodd" class="w-bg" 
            d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
            </svg>
           </div>
       </div>
       </a> 
    </div>
</div>

<div class="row my-5">
    <div class="col">
    <a href="#" class="platform-button pb-lge">Load more</a>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="/" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

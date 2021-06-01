{{count($futureEvents)}}

@foreach($futureEvents as $event)
    <div class="col-xl-4 col-lg-6 mb-4">
        <a href="#" class="td-no">
        <div class="row no-gutters">
            <div class="col-3 vlg-bg">
                <div class="square" style="background-image: url('{{ parse_encode_url($event->getFirstMediaUrl('summary', 'small')) ?? '' }}')"></div>
            </div>
            <div class="col-9 col-lg-7 vlg-bg">
                <div class="ev-lst-inner d-flex align-items-start flex-column">
                    <h4 class="t18 fw700">{{$event->summary_heading}}</h4>
                    <div class="ev-lst-details t-up mt-auto t16"><span class="fw700">{{ date('d M Y', strtotime($event->date)) }}</span> | <span class="fw700">{{ str_pad($event->start_time_hour,2,'0',STR_PAD_LEFT) }}:{{ str_pad($event->start_time_min,2,'0',STR_PAD_LEFT) }}</span></div>
                </div>
            </div>
            <div class="col-lg-2 vlg-bg d-none d-lg-flex align-items-center justify-content-end">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="29px" height="48px" class="side-button">
                    <path fill-rule="evenodd" class="bg-1"
                    d="M23.934,0.001 L29.000,-0.000 L29.000,48.000 L24.145,47.908 L23.934,47.908 C10.719,47.908 0.006,37.184 0.006,23.955 C0.006,10.725 10.719,0.001 23.934,0.001 Z"/>
                    <path fill-rule="evenodd" class="w-bg"
                    d="M23.293,25.031 L23.276,25.048 C23.254,25.072 23.238,25.099 23.215,25.123 C23.203,25.135 23.186,25.138 23.174,25.150 L15.927,32.405 C15.249,33.083 14.150,33.083 13.472,32.405 C12.794,31.726 12.794,30.625 13.472,29.947 L19.520,23.892 L13.355,17.719 C12.674,17.038 12.674,15.933 13.355,15.251 C14.035,14.570 15.139,14.570 15.820,15.251 L22.815,22.255 C22.985,22.337 23.152,22.431 23.293,22.573 C23.971,23.251 23.971,24.352 23.293,25.031 Z"/>
                    </svg>
            </div>
        </div>
        </a>
    </div>
@endforeach

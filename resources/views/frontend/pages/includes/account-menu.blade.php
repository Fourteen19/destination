<div class="col-lg-2">
    <div class="sticky-p position-sticky">
        <ul class="list-unstyled py-3">
            <li class="mb-2"><a href="{{ route('frontend.my-account') }}" class="t-up t-wg w900 t16 td-no">Edit my details</a></li>
            <li class="mb-2"><a href="{{ route('frontend.my-account.update-my-preferences.edit') }}" class="t-up t-wg w900 t16 td-no">My preferences</a></li>

            @if (!empty($institutionAdvisor))
                @if ($institutionAdvisor->contact_me == 'Y')
                    <li class="mb-2"><a href="{{ route('frontend.my-account.contact-my-adviser') }}" class="t-up t-wg w900 t16 td-no">Contact my adviser</a></li>
                @endif
            @endif

            <li class="mb-2"><a href="{{ route('frontend.my-account.my-articles') }}" class="t-up t-wg w900 t16 td-no">My articles</a></li>
            <li class="mb-2"><a class="t-up t-wg w900 t16 td-no" href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                @csrf
            </form></li>
        </ul>
    </div>
</div>

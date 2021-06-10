<div>

    @include('admin.pages.includes.flash-message')

    @if ($displayForm == 'Y')
        <div class="accept">
            <p>Before you proceed please click below to accept our <a href="{{ route('frontend.terms', ['clientSubdomain' => session('fe_client.subdomain')]) }}" target="_blank">terms & conditions</a></p>
            <div class="form-check">
            <input class="form-check-input mt-2" type="checkbox" value="terms" id="terms" wire:model="terms">
            <label class="form-check-label ml-2 fw700" for="terms">
                I agree to the MyDirections terms and conditions.
            </label>
            </div>
        </div>
    @endif

    @if ($termsAccepted == 'Y')
        {{-- NEEDS TO BE A BUTTON, not a link --}}
        <button type="button" wire:click.prevent="submit" wire:loading.attr="disabled" class="platform-button mt-4">Get started</button>
        <a href="{{ route('frontend.self-assessment.career-readiness.edit', ['clientSubdomain' => session('fe_client.subdomain')] ) }}" class="platform-button mt-4">Get started</a>
    @endif

</div>

<div class="row r-base mt-5" >
{{$timer15Submitted}}

    {{-- Sends an Ajax call to the server every 15 seconds to check how long a user has been on reading the page --}}
    @if ($timer15Submitted === 0) <div wire:poll.15000ms="timer15"></div> @endif
    @if ($timerFullyReadSubmitted === 0) <div wire:poll.25000ms="timerArticleIsRead"></div> @endif{{-- The timer need to be made dynamic based on the unmber of character an article contains--}}

    <form wire:submit.prevent="submit">
        <div class="col-12">

            <div class="mlg-bg p-5">

                <h3 class="fw700 t36 mb-4">Was this page relevant?</h3>

                @if ($feedbackSubmitted == 0)

                    <div class="form-check mb-3">
                        <input class="form-check-input position-relative mr-2" type="radio" name="relevant" id="yes" value="yes" wire:model="relevant">
                        <label class="form-check-label t20 fw700" for="yes">
                        Yes - It was relevant to me and helpful
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input position-relative mr-2" type="radio" name="relevant" id="no" value="no" wire:model="relevant">
                        <label class="form-check-label t20 fw700" for="no">
                            Not at all - it's not what I was after
                        </label>
                    </div>
                    @error('relevant') <span class="error">{{ $message }}</span> @enderror

                    <button type="submit" class="platform-button border-0 t-def">
                    Improve your profile
                    </button>

                @else

                    <div class="form mb-3">
                        Thanks you your feedback
                    </div>

                @endif
            </div>

        </div>

    </form>

</div>

@if ($feedbackSubmitted == 0)

    @push('scripts')
    <script>
    $(document).ready(function(){

        var articleScroll75 = {{$this->articleRead75PerCentScrolled}};
        var articleScroll100 = {{$this->articleRead100PerCentScrolled}};

        document.addEventListener(
            'scroll',
            (event) => {
                update_scroll();
            },
            { passive: true }
        );

        update_scroll();

        function update_scroll(){
            var windowBottom = $(this).scrollTop() + $(this).height();
            var elementTop = $("#article-body").offset().top;
            var percentage = (windowBottom - elementTop) / $("#article-body").height() * 100;

            if ( (percentage >= 100) && (articleScroll100 == 0) ){
                livewire.emit('articleScroll100PerCent');
                articleScroll100 = 1;
            } else if ( (windowBottom >= elementTop)  && (articleScroll75 == 0) ){
                if (`${Math.round(percentage)}` >= 75){
                    livewire.emit('articleScroll75PerCent');
                    articleScroll75 = 1;
                }
            } else {
            }
        }

    });
    </script>
    @endpush

@endif

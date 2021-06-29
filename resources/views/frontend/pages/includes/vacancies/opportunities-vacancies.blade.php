@if (count($moreVacancies) > 0)

    @foreach($moreVacancies as $vacancy)

        <a href="#" class="td-no article-row">
            <div class="row align-items-center t24">
                <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                    <img src="https://via.placeholder.com/200x200.png?text=Logo">
                </div>
                <div class="col-8 col-sm-10 col-lg-3 col-xl-4">
                    <div><h3 class="fw700">[Job name]</h3>[Employer Name]</div>
                </div>
                <div class="col-lg-2 col-8 col-sm-auto offset-4 offset-sm-2 offset-lg-0">
                    <i class="fas fa-map-marker mr-2"></i><span class="fw700">[Location]</span>
                </div>
                <div class="col-lg-5 col-8 col-sm-auto offset-4 offset-sm-0 offset-lg-0">
                    <div><span class="fw700">[Role type]</span><div class="d-none d-sm-inline-block mx-2"> | </div><div class="d-sm-inline-block d-block">Posted # months ago</div></div>
                </div>
            </div>
        </a>

        <div class="row">
            <div class="col my-4">
                <div class="border-top gg-border"></div>
            </div>
        </div>

    @endforeach

@endif

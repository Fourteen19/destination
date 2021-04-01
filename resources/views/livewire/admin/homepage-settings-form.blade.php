<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "year7") active @endif @if($errors->hasany(['year7_slot1_article', 'year7_slot2_article', 'year7_slot3_article', 'year7_slot4_article', 'year7_slot5_article', 'year7_slot6_article'])) error @endif" data-toggle="tab" href="#year7" wire:key="year7-tab" wire:click="updateTab('year7')">Year 7</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "year8") active @endif @if($errors->hasany(['year8_slot1_article', 'year8_slot2_article', 'year8_slot3_article', 'year8_slot4_article', 'year8_slot5_article', 'year8_slot6_article'])) error @endif" data-toggle="tab" href="#year8" wire:key="year8-tab" wire:click="updateTab('year8')">Year 8</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year9") active @endif @if($errors->hasany(['year9_slot1_article', 'year9_slot2_article', 'year9_slot3_article', 'year9_slot4_article', 'year9_slot5_article', 'year9_slot6_article'])) error @endif" data-toggle="tab" href="#year9" wire:key="year9-tab" wire:click="updateTab('year9')">Year 9</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year10") active @endif @if($errors->hasany(['year10_slot1_article', 'year10_slot2_article', 'year10_slot3_article', 'year10_slot4_article', 'year10_slot5_article', 'year10_slot6_article'])) error @endif" data-toggle="tab" href="#year10" wire:key="year10-tab" wire:click="updateTab('year10')">Year 10</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year11") active @endif @if($errors->hasany(['year11_slot1_article', 'year11_slot2_article', 'year11_slot3_article', 'year11_slot4_article', 'year11_slot5_article', 'year11_slot6_article'])) error @endif" data-toggle="tab" href="#year11" wire:key="year11-tab" wire:click="updateTab('year11')">Year 11</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year12") active @endif @if($errors->hasany(['year12_slot1_article', 'year12_slot2_article', 'year12_slot3_article', 'year12_slot4_article', 'year12_slot5_article', 'year12_slot6_article'])) error @endif" data-toggle="tab" href="#year12" wire:key="year12-tab" wire:click="updateTab('year12')">Year 12</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year13") active @endif @if($errors->hasany(['year13_slot1_article', 'year13_slot2_article', 'year13_slot3_article', 'year13_slot4_article', 'year13_slot5_article', 'year13_slot6_article'])) error @endif" data-toggle="tab" href="#year13" wire:key="year13-tab" wire:click="updateTab('year13')">Year 13</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "year14") active @endif @if($errors->hasany(['year14_slot1_article', 'year14_slot2_article', 'year14_slot3_article', 'year14_slot4_article', 'year14_slot5_article', 'year14_slot6_article'])) error @endif" data-toggle="tab" href="#year14" wire:key="year14-tab" wire:click="updateTab('year14')">Post Education</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.homepage-settings.year7')

        @include('livewire.admin.includes.homepage-settings.year8')

        @include('livewire.admin.includes.homepage-settings.year9')

        @include('livewire.admin.includes.homepage-settings.year10')

        @include('livewire.admin.includes.homepage-settings.year11')

        @include('livewire.admin.includes.homepage-settings.year12')

        @include('livewire.admin.includes.homepage-settings.year13')

        @include('livewire.admin.includes.homepage-settings.year14')

    </div>

    @include('livewire.admin.includes.homepage-settings.submit')

</div>


@push('scripts')
<script>

    function display_errors()
    {
        /* slots = $("input:radio.slot_type:checked");
        //console.log(slots);
        $(slots).each(function(i){

            //alert($(this).attr('name'));
            if ($(this).val() == 'managed'){
                name = $(this).attr('name');
                console.log(name);
                article_field = name.replace('type','article');
                console.log('#'+article_field + "_remove");
                console.log($('#'+article_field + "_remove").length);
                if ($('#'+article_field + "_remove").length)
                {
                    console.log("ok");
                    console.log('#'+article_field + "_error");
                    $('#'+article_field + "_error").hide();
                } else {
                    console.log("error");
                    console.log('#'+article_field + "_error");
                    $('#'+article_field + "_error").show();
                }

            } else {
                $('#'+article_field + "_error").hide();
            }
        }); */

    }

</script>
@endpush

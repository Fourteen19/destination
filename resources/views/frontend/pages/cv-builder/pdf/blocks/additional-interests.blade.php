@if ($cv->additional_interests)

    @if ($cv->page_break_before_additional_interests == "Y")
        <div class="page-break"></div>
    @endif

    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div style="margin-top: 5px">
                <div style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 5px; font-weight: bold;">Hobbies, interests & achievements</div>
                <div>{{$cv->additional_interests}}</div>
                </div>
            </td>
        </tr>
    </table>
@endif

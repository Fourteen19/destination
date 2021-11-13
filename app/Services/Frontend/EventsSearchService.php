<?php

namespace App\Services\Frontend;

use Carbon\Carbon;
use App\Models\EventLive;
use App\Models\ContentLive;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class EventsSearchService
{

    public $resEventsByKeyword;
    public $resEventsByRoute;
    public $resEventsBySector;
    public $resEventsWithExactTitle;
    public $resEventsContainsInTitle;
    public $resEventsContainsInLead;
    public $resEventsContainsInSummary;



    public function __construct()
    {
        //
    }



    /**
     * getMyEventsWithKeyword
     * Search events using a keyword
     *
     * @param  mixed $searchEventsString
     * @return void
     */
    public function getMyEventsWithKeyword($searchEventsString)
    {

        //dd("the keyword is:".$searchEventsString);

        return $this->processSearch($searchEventsString);

    }

    /**
     * getMyEventsWithString
     * Search events using an unfiltered string
     *
     * @param  mixed $searchEventsString
     * @return void
     */
    public function getMyEventsWithString($searchEventsString)
    {

        return $this->processSearch($searchEventsString);

    }



    /**
     * getKeywordsFromSearchString
     *
     * @param  mixed $orginalSearchEventsString
     * @return void
     */
    public function getKeywordsFromSearchString($orginalSearchEventsString){

        $searchString = remove_common_words( strtolower($orginalSearchEventsString) );

        //After removing the common words, check if we have any word left
        if (!empty($searchString))
        {

            $explodedSearchString = explode(" ", $searchString);

            $query = SystemKeywordTag::where("client_id", Session::get('fe_client')['id'])
                                    ->select('name', 'slug')
                                    ->where("live", '=', 'Y')
                                    ->where(function($query) use ($explodedSearchString) {
                                        foreach ($explodedSearchString as $string)
                                        {
                                            if ( (!empty($string)) && (strlen($string) > 2) )
                                            {
                                                $query->orwhere("slug", "LIKE", '%-'.$string.'-%');//word in the middle of  sentence
                                                $query->orwhere("slug", "LIKE", '{"en":"'.$string."-%"); // word at the beginning of a sentence
                                                $query->orwhere("slug", "LIKE", '%-'.$string.'"}'); // word at the end of a sentence
                                                $query->orwhere("slug", "=", '{"en":"'.$string.'"}'); // word at the end of a sentence
                                            }
                                        }
                                    });

            $res = $query->get()->toArray();

            $keywords = [];
            foreach($res as $key => $value){
                $keywords[] = [
                                'name' => $value['name'][app()->getLocale()],
                                'slug' => $value['slug'][app()->getLocale()]
                            ];
            }



            $tempKeywords = [];
            //compare each tag name with the string searched
            foreach($keywords as $key => $value)
            {

                $explodedTagName = explode(" ", strtolower($value['name']));

                //counts the number of common words between the search string and the tag
                $commonWords = array_intersect($explodedTagName, $explodedSearchString);

                //stores the tag in array for matching number of words
                $tempKeywords[ count($commonWords) ][] = $value;

            }

            //sort the array by key ie. the number of common words
            ksort($tempKeywords, SORT_NUMERIC );
            $reversedTempKeywords = array_reverse($tempKeywords);

            //we now have an array of tags sorted by the number of matching words in the name


            //push the tags in $keywords
            $keywords = [];
            foreach($reversedTempKeywords as $key => $value)
            {
                foreach($value as $keyKeyword => $valueKeyword)
                {
                    $keywords[] = $valueKeyword;
                }
            }

        } else {

            $keywords = [];

        }

        return $keywords;

    }






    private function searchForEventsWithAllTags($eventsHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }

        //search for events with all the tags
        $eventsWithAllTags = $eventsHaystack->filter(function ($event, $key) use ($keywords, $type) {


            //gets all the events keywords
            $eventKeywords = $event->tagsWithType($type)->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the event
            $result = array_intersect($eventKeywords, $keywords);

            //if perfect match, this event has all the keywords tags
            if ( (count($result) == count($eventKeywords)) && (count($result) > 0) )
            {
                return $event;
            }

        });

        return $eventsWithAllTags;

    }





    private function searchForEventsWithAnyTags($eventsHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }



        //search for events with any of the tags
        $eventsWithAnyKeyword = $eventsHaystack->filter(function ($event, $key) use ($keywords, $type) {

            //gets all the events keywords
            $eventKeywords = $event->tagsWithType($type)->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the event
            $result = array_intersect($eventKeywords, $keywords);

            //if perfect match, this event has all the keywords tags
            if (count($result) > 0){

                $event->searchFilterScore = count($result);
                return $event;
            }

        });

        return $eventsWithAnyKeyword->sortBy('searchFilterScore');

    }




    private function processSearch($orginalSearchEventsString)
    {

        // SELECTING
        //selects all the events relevant to the year

        //if logged in
        if (Auth::guard('web')->check() )
        {

            //if the logged in user is a user
            if (Auth::guard('web')->user()->type == 'user')
            {

                $events = EventLive::where('client_id', NULL)
                                    ->orWhere('client_id', Auth::guard('web')->user()->client_id)
                                    ->whereDate('date', '>', Carbon::today()->toDateString())
                                    ->with('tags')
                                    ->Where(function($query) {
                                        $query->where('all_institutions', 'Y')
                                              ->orwhereHas('institutions', function ($query) {
                                                    $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                                });
                                        })
                                    ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                    ->withAnyTags( [ app('currentTerm') ] , 'term')
                                    ->get();

            //if the logged in user is an admin,  we ignore the year as we want to be able to access all events
            } elseif (Auth::guard('web')->user()->type == 'admin'){

                $events = EventLive::where('client_id', NULL)
                                    ->orWhere('client_id', Auth::guard('web')->user()->client_id)
                                    ->whereDate('date', '>', Carbon::today()->toDateString())
                                    ->with('tags')
                                    ->Where(function($query) {
                                        $query->where('all_institutions', 'Y')
                                              ->orwhereHas('institutions', function ($query) {
                                                    $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                                });
                                        })
                                    ->get();

            } else {
                abort(404);
            }


        } else {

            $events = EventLive::where('client_id', NULL)
                                ->orWhere('client_id', Session::get('fe_client')['id'])
                                ->whereDate('date', '>', Carbon::today()->toDateString())
                                ->with('tags')
                                ->IsNotInternal()
                                ->get();
        }

        //extracts keywords from string
        $extractedKeywords = $this->getKeywordsFromSearchString($orginalSearchEventsString);

        //dd($extractedKeywords);

        $keywords = [];
        if (count($extractedKeywords) >0)
        {
            foreach($extractedKeywords as $key => $value){
                $keywords[] = $value['slug'];
            }
        }
        //dd($keywords);



        $lowercaseSearchEventsString = strtolower($orginalSearchEventsString);
        //dd($lowercaseSearchEventsString);



        $eventsWithAllKeyword = $this->searchForEventsWithAllTags($events, $keywords, 'keyword');
        //dd($eventsWithAllKeyword);
        $eventsWithAnyKeyword = $this->searchForEventsWithAnyTags($events, $keywords, 'keyword');
        //dd($eventsWithAnyKeyword);






        $eventsWithAllRoutes = $this->searchForEventsWithAllTags($events, $keywords, 'route');
        //dd($eventsWithAllRoutes);
        $eventsWithAnyRoutes = $this->searchForEventsWithAnyTags($events, $keywords, 'route');






        $eventsWithAllSubjects = $this->searchForEventsWithAllTags($events, $keywords, 'subject');
        $eventsWithAnySubjects = $this->searchForEventsWithAnyTags($events, $keywords, 'subject');




        $eventsWithAllSectors = $this->searchForEventsWithAllTags($events, $keywords, 'sector');
        $eventsWithAnySectors = $this->searchForEventsWithAnyTags($events, $keywords, 'sector');



//dd($events->get());

        //only keeps events with matching title
        $eventsWithExactTitle = $events->filter(function ($event, $key) use($lowercaseSearchEventsString) {
            if ($lowercaseSearchEventsString == strtolower($event->summary_heading))
            {
                return $event;
            }
        });




        //used to count number of times a word appear in an event (title, lead, ..)
        $explodedSearchString = explode(" ",  remove_common_words( strtolower($orginalSearchEventsString) ) );


        $eventsContainsInTitleTmp = $events->filter(function ($event, $key) use ($explodedSearchString) {

            //explodes the summary heading
            $explodedTitle = explode(" ", strtolower($event->summary_heading));

            //intersetcs the arrays
            $commonWords = array_intersect($explodedTitle, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $event->containsInTitle = count($commonWords);

            //return the event
            if (count($commonWords) > 0)
            {
                return $event;
            }
        });

        //sort by number of occurences
        $eventsContainsInTitle = $eventsContainsInTitleTmp->sortByDesc('containsInTitle');





        //only keeps events with search string contained in the lead paragraph
        $eventsContainsInLeadTmp = $events->filter(function ($event, $key) use ($explodedSearchString) {

            $lead = $event->summary_text;

            //explodes the summary heading
            $explodedTitle = explode(" ", strtolower($lead));

            //intersetcs the arrays
            $commonWords = array_intersect($explodedTitle, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $event->containsInLead = count($commonWords);

            //return the event
            if (count($commonWords) > 0)
            {
                return $event;
            }
        });

        //sort by number of occurences
        $eventsContainsInLead = $eventsContainsInLeadTmp->sortByDesc('containsInLead');






        //only keeps events with search string contained in the summary text
        $eventsContainsSummaryTmp = $events->filter(function ($event, $key) use($explodedSearchString) {
            // if ( (str_contains(strtolower($event->summary_heading), $lowercaseSearchEventsString)) || (str_contains(strtolower($event->summary_text), $lowercaseSearchEventsString)) )
            // {
            //     return $event;
            // }

            //explodes the summary heading
            $explodedSummaryText = explode(" ", $event->summary_text);

            //intersetcs the arrays
            $commonWords = array_intersect($explodedSummaryText, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $event->containsInSummaryText = count($commonWords);

            //return the event
            if (count($commonWords) > 0)
            {
                return $event;
            }


        });
        //dd($eventsContainsInSummary);

        //sort by number of occurences
        $eventsContainsInSummary = $eventsContainsSummaryTmp->sortByDesc('containsSummaryText');






        $eventsContainsInVenueTmp = $events->filter(function ($event, $key) use ($explodedSearchString) {

            //explodes the summary heading
            $explodedVenue = explode(" ", strtolower($event->venue_name));

            //intersetcs the arrays
            $commonWords = array_intersect($explodedVenue, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $event->containsInVenue = count($commonWords);

            //return the event
            if (count($commonWords) > 0)
            {
                return $event;
            }
        });

        //sort by number of occurences
        $eventsContainsInVenue = $eventsContainsInVenueTmp->sortByDesc('containsInVenue');




        $eventsContainsInTownTmp = $events->filter(function ($event, $key) use ($explodedSearchString) {

            //explodes the summary heading
            $explodedTown = explode(" ", strtolower($event->town));

            //intersetcs the arrays
            $commonWords = array_intersect($explodedTown, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $event->containsInTown = count($commonWords);

            //return the event
            if (count($commonWords) > 0)
            {
                return $event;
            }
        });

        //sort by number of occurences
        $eventsContainsInTown = $eventsContainsInTownTmp->sortByDesc('containsInTown');





        $eventsContainsInDateTmp = $events->filter(function ($event, $key) use ($explodedSearchString) {

            //explodes the summary heading
            $explodedDate = explode("-", strtolower($event->date));


            //if the middle part of the month is 1 (ie. january), set the $eventMonthString var to january, and so on ...
            if ($explodedDate[1] == 1){
                $eventMonthString = config('global.months')[0];
            } elseif ($explodedDate[1] == 2){
                $eventMonthString = config('global.months')[1];
            } elseif ($explodedDate[1] == 3){
                $eventMonthString = config('global.months')[2];
            } elseif ($explodedDate[1] == 4){
                $eventMonthString = config('global.months')[3];
            } elseif ($explodedDate[1] == 5){
                $eventMonthString = config('global.months')[4];
            } elseif ($explodedDate[1] == 6){
                $eventMonthString = config('global.months')[5];
            } elseif ($explodedDate[1] == 7){
                $eventMonthString = config('global.months')[6];
            } elseif ($explodedDate[1] == 8){
                $eventMonthString = config('global.months')[7];
            } elseif ($explodedDate[1] == 9){
                $eventMonthString = config('global.months')[8];
            } elseif ($explodedDate[1] == 10){
                $eventMonthString = config('global.months')[9];
            } elseif ($explodedDate[1] == 11){
                $eventMonthString = config('global.months')[10];
            } elseif ($explodedDate[1] == 12){
                $eventMonthString = config('global.months')[11];
            }


            foreach($explodedSearchString as $key => $value)
            {

                if ($value == $eventMonthString)
                {
                    //counts the number of common words and stores it for future sorting
                    $event->containsInTown += 1;
                }
            }

            if ($event->containsInTown > 0)
            {
                return $event;
            }

        });

        //sort by number of occurences
        $eventsContainsInDate = $eventsContainsInDateTmp->sortByDesc('containsInDate');






        //RANKING
        //Compiles the collection to return

        $result = collect([]);

         //adds the events with the exact title
        $result = $result->union($eventsWithExactTitle);

        //adds the events containing search string in title
        $result = $result->union($eventsContainsInTitle);

        //adds the events containing search string in lead para
        $result = $result->union($eventsContainsInLead);

        //adds the events containing search string in the venue name
        $result = $result->union($eventsContainsInVenue);

        //adds the events containing search string in the venue name
        $result = $result->union($eventsContainsInTown);

        //adds the events containing search string in the date
        $result = $result->union($eventsContainsInDate);

        //adds the events containing search string in summary
        // $result = $result->union($eventsContainsInSummary);

        //adds the events with the keyword
        $result = $result->union($eventsWithAllKeyword);
        $result = $result->union($eventsWithAnyKeyword);

         //adds the events with the tags
        $result = $result->union($eventsWithAllRoutes);
        $result = $result->union($eventsWithAllSubjects);
        $result = $result->union($eventsWithAllSectors);
        $result = $result->union($eventsWithAnyRoutes);
        $result = $result->union($eventsWithAnySubjects);
        $result = $result->union($eventsWithAnySectors);


        $result = $result->sortBy('date');

        return $result;

    }

}

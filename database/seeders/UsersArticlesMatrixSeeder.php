<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ContentArticle;
use Illuminate\Database\Seeder;
use App\Services\Admin\ContentService;
use Database\Factories\ContentFactory;
use Database\Factories\RelatedLinkFactory;
use Database\Factories\RelatedVideoFactory;
use App\Services\Frontend\SelfAssessmentService;

class UsersArticlesMatrixSeeder extends Seeder
{

    protected $selfAssessmentService;

    protected $contentService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(selfAssessmentService $selfAssessmentService, ContentService $contentService)
    {

        $this->selfAssessmentService = $selfAssessmentService;

        $this->contentService = $contentService;

    }



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Matrix seeding starts!');


        // USER A

        $userA = User::factory(['email' => 'usera@rfmedia.co.uk', 'school_year' => 9, 'client_id' => 1, 'institution_id' => 1])->create();
        $userA->syncTagsWithType(['NEET 16-18'], 'neet');

        $subjects = [
                'Agriculture, Horticulture and Animal Care' => 'Not applicable',
                'Art and Design' => 'Not applicable',
                'Business' => 'Not applicable',
                'Childcare' => 'Not applicable',
                'Computing and IT' => 'Not applicable',
                'Construction' => 'Not applicable',
                'Engineering' => 'Not applicable',
                'English' => 'Not applicable',
                'Hair and Beauty' => 'Not applicable',
                'Health and Social Care' => 'Not applicable',
                'Hospitality and Catering' => 'Not applicable',
                'Humanities' => 'Not applicable',
                'Languages' => 'Not applicable',
                'Maths' => 'I like it',
                'Media' => 'Not applicable',
                'Performing Arts' => 'Not applicable',
                'Public/Uniformed Services' => 'Not applicable',
                'Sciences' => 'Not applicable',
                'Social Sciences' => 'Not applicable',
                'Sport' => 'Not applicable',
                'Travel and Tourism' => 'Not applicable',
        ];
        $selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userA);
        $this->selfAssessmentService->allocateSubjectTagsForAssessment($selfAssessment, $subjects);
        $this->selfAssessmentService->AllocateRouteTagsForAssessment($selfAssessment, ['Higher education']);
        $this->selfAssessmentService->AllocateSectorTagsForAssessment($selfAssessment, ['Healthcare']);
        $selfAssessment->syncTagsWithType(['2-3'], 'career_readiness');
        $selfAssessment->career_readiness_average = 2;
        $selfAssessment->career_readiness_score_1 = 5;
        $selfAssessment->career_readiness_score_2 = 5;
        $selfAssessment->career_readiness_score_3 = 1;
        $selfAssessment->career_readiness_score_4 = 1;
        $selfAssessment->career_readiness_score_5 = 1;
        $selfAssessment->save();



        // USER B

        $userB = User::factory(['email' => 'userb@rfmedia.co.uk', 'school_year' => 9, 'client_id' => 1, 'institution_id' => 1])->create();
        $userB->syncTagsWithType(['NEET 18+'], 'neet');

        $subjects = [
            'Agriculture, Horticulture and Animal Care' => 'Not applicable',
            'Art and Design' => 'Not applicable',
            'Business' => 'Not applicable',
            'Childcare' => 'Not applicable',
            'Computing and IT' => 'Not applicable',
            'Construction' => 'Not applicable',
            'Engineering' => 'Not applicable',
            'English' => 'I like it',
            'Hair and Beauty' => 'Not applicable',
            'Health and Social Care' => 'Not applicable',
            'Hospitality and Catering' => 'Not applicable',
            'Humanities' => 'Not applicable',
            'Languages' => 'Not applicable',
            'Maths' => 'Not applicable',
            'Media' => 'Not applicable',
            'Performing Arts' => 'Not applicable',
            'Public/Uniformed Services' => 'Not applicable',
            'Sciences' => 'Not applicable',
            'Social Sciences' => 'Not applicable',
            'Sport' => 'Not applicable',
            'Travel and Tourism' => 'Not applicable',
        ];
        $selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userB);
        $this->selfAssessmentService->allocateSubjectTagsForAssessment($selfAssessment, $subjects);
        $this->selfAssessmentService->AllocateRouteTagsForAssessment($selfAssessment, ['Apprenticeships']);
        $this->selfAssessmentService->AllocateSectorTagsForAssessment($selfAssessment, ['Computing, Technology and Digital']);
        $selfAssessment->syncTagsWithType(['3-4'], 'career_readiness');
        $selfAssessment->career_readiness_average = 3.25;
        $selfAssessment->career_readiness_score_1 = 5;
        $selfAssessment->career_readiness_score_2 = 5;
        $selfAssessment->career_readiness_score_3 = 3;
        $selfAssessment->career_readiness_score_4 = 1;
        $selfAssessment->career_readiness_score_5 = 1;
        $selfAssessment->save();



        // USER C

        $userC = User::factory(['email' => 'userc@rfmedia.co.uk', 'school_year' => 10, 'client_id' => 1, 'institution_id' => 1])->create();
        $userC->syncTagsWithType(['Below Level 2'], 'neet');

        $subjects = [
                'Agriculture, Horticulture and Animal Care' => 'Not applicable',
                'Art and Design' => 'Not applicable',
                'Business' => 'Not applicable',
                'Childcare' => 'Not applicable',
                'Computing and IT' => 'Not applicable',
                'Construction' => 'Not applicable',
                'Engineering' => 'Not applicable',
                'English' => 'Not applicable',
                'Hair and Beauty' => 'Not applicable',
                'Health and Social Care' => 'Not applicable',
                'Hospitality and Catering' => 'Not applicable',
                'Humanities' => 'Not applicable',
                'Languages' => 'Not applicable',
                'Maths' => 'I like it',
                'Media' => 'Not applicable',
                'Performing Arts' => 'Not applicable',
                'Public/Uniformed Services' => 'Not applicable',
                'Sciences' => 'Not applicable',
                'Social Sciences' => 'Not applicable',
                'Sport' => 'Not applicable',
                'Travel and Tourism' => 'Not applicable',
        ];
        $selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userC);
        $this->selfAssessmentService->allocateSubjectTagsForAssessment($selfAssessment, $subjects);
        $this->selfAssessmentService->AllocateRouteTagsForAssessment($selfAssessment, ['Higher education']);
        $this->selfAssessmentService->AllocateSectorTagsForAssessment($selfAssessment, ['Computing, Technology and Digital']);
        $selfAssessment->syncTagsWithType(['1-2'], 'career_readiness');
        $selfAssessment->career_readiness_average = 1.5;
        $selfAssessment->career_readiness_score_1 = 3;
        $selfAssessment->career_readiness_score_2 = 3;
        $selfAssessment->career_readiness_score_3 = 1;
        $selfAssessment->career_readiness_score_4 = 1;
        $selfAssessment->career_readiness_score_5 = 1;
        $selfAssessment->save();



        // USER D

        $userD = User::factory(['email' => 'userd@rfmedia.co.uk', 'school_year' => 10, 'client_id' => 1, 'institution_id' => 1])->create();
        $userD->syncTagsWithType(['Below Level 2'], 'neet');

        $subjects = [
            'Agriculture, Horticulture and Animal Care' => 'Not applicable',
            'Art and Design' => 'Not applicable',
            'Business' => 'Not applicable',
            'Childcare' => 'Not applicable',
            'Computing and IT' => 'Not applicable',
            'Construction' => 'Not applicable',
            'Engineering' => 'Not applicable',
            'English' => 'I like it',
            'Hair and Beauty' => 'Not applicable',
            'Health and Social Care' => 'Not applicable',
            'Hospitality and Catering' => 'Not applicable',
            'Humanities' => 'Not applicable',
            'Languages' => 'Not applicable',
            'Maths' => 'Not applicable',
            'Media' => 'Not applicable',
            'Performing Arts' => 'Not applicable',
            'Public/Uniformed Services' => 'Not applicable',
            'Sciences' => 'Not applicable',
            'Social Sciences' => 'Not applicable',
            'Sport' => 'Not applicable',
            'Travel and Tourism' => 'Not applicable',
        ];
        $selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userD);
        $this->selfAssessmentService->allocateSubjectTagsForAssessment($selfAssessment, $subjects);
        $this->selfAssessmentService->AllocateRouteTagsForAssessment($selfAssessment, ['Apprenticeships']);
        $this->selfAssessmentService->AllocateSectorTagsForAssessment($selfAssessment, ['Healthcare']);
        $selfAssessment->syncTagsWithType(['4-5'], 'career_readiness');
        $selfAssessment->career_readiness_average = 4.5;
        $selfAssessment->career_readiness_score_1 = 5;
        $selfAssessment->career_readiness_score_2 = 5;
        $selfAssessment->career_readiness_score_3 = 5;
        $selfAssessment->career_readiness_score_4 = 3;
        $selfAssessment->career_readiness_score_5 = 1;
        $selfAssessment->save();



        /*********** ARTICLES *************/


        // Article 001
        //ID 21
        $article = $this->createDummyArticle('Client Y9-Maths-001');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);


        // Article 002
        //ID 22
        $article = $this->createDummyArticle('Client Y9-Higher-002');
        $article->content->syncTagsWithType(['Higher education'], 'route');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 003
        //ID 23
        $article = $this->createDummyArticle('Client Y9-Healthcare-003');
        $article->content->syncTagsWithType(['Healthcare'], 'sector');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Healthcare'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 004
        //ID 24
        $article = $this->createDummyArticle('Client Y9-CRS-2-to-3-004');
        $article->content->syncTagsWithType(['2-3'], 'career_readiness');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 005
        //ID 25
        $article = $this->createDummyArticle('Client Y9-English-005');
        $article->content->syncTagsWithType(['English'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['English'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 006
        //ID 26
        $article = $this->createDummyArticle('Client Y9-Apprent-006');
        $article->content->syncTagsWithType(['Apprenticeships'], 'route');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Apprenticeships'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 007
        //ID 27
        $article = $this->createDummyArticle('Client Y9-IT-007');
        $article->content->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Computing and IT'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 008
        //ID 28
        $article = $this->createDummyArticle('Client Y9-CRS-3-to-4-008');
        $article->content->syncTagsWithType(['3-4'], 'career_readiness');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 009
        //ID 29
        $article = $this->createDummyArticle('Client Y10-Maths-009');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Apprenticeships'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 010
        //ID 30
        $article = $this->createDummyArticle('Client Y10-Higher-010');
        $article->content->syncTagsWithType(['Higher education'], 'route');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 011
        //ID 31
        $article = $this->createDummyArticle('Client Y10-IT-011');
        $article->content->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Computing and IT', 'Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 012
        //ID 32
        $article = $this->createDummyArticle('Client Y10-CRS-1-to-2-012');
        $article->content->syncTagsWithType(['1-2'], 'career_readiness');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 013
        //ID 33
        $article = $this->createDummyArticle('Client Y10-English-013');
        $article->content->syncTagsWithType(['English'], 'subject');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['English'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 014
        //ID 34
        $article = $this->createDummyArticle('Client Y10-Apprent-014');
        $article->content->syncTagsWithType(['Apprenticeships'], 'route');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Apprenticeships'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 015
        //ID 35
        $article = $this->createDummyArticle('Client Y10-Healthcare-015');
        $article->content->syncTagsWithType(['Healthcare'], 'sector');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Healthcare', 'Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 016
        //ID 36
        $article = $this->createDummyArticle('Client Y10-CRS-4-to-5-016');
        $article->content->syncTagsWithType(['4-5'], 'career_readiness');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 017
        //ID 37
        $article = $this->createDummyArticle('Y9-Global');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Summer', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 018
        //ID 38
        $article = $this->createDummyArticle('Y10-Global');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Summer', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);

        // Article 019
        //ID 39
        $article = $this->createDummyArticle('Global-all');
        $article->content->syncTagsWithType(['7', '8', '9', '10', '11', 'post'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Summer', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType([], 'keyword');
        $this->contentService->makeLive($article->content);




        //Extra Articles for related articles

        // Related Article 002
        //ID 40
        $article = $this->createDummyArticle('Client Y9-Maths-002');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Related Article 003
        //ID 41
        $article = $this->createDummyArticle('Client Y9-Maths-003');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);

        // Related Article 004
        //ID 42
        $article = $this->createDummyArticle('Client Y9-Maths-004');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $this->contentService->makeLive($article->content);



        //High Priority  Article
        //ID 43
        $article = $this->createDummyArticle('Client Y9-Maths-005 High Priority');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $article->content->syncTagsWithType(['High priority'], 'flag');
        $this->contentService->makeLive($article->content);



        //Neet Article 1
        //ID 44
        $article = $this->createDummyArticle('Client Y9-Maths NEET 16-18');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $article->content->syncTagsWithType(['NEET 16-18'], 'neet');
        $this->contentService->makeLive($article->content);

        //Neet Article 2
        //ID 44
        $article = $this->createDummyArticle('Client Y9-Maths NEET 18+');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $article->content->syncTagsWithType(['NEET 18+'], 'neet');
        $this->contentService->makeLive($article->content);

        //Neet Article 3
        //ID 45
        $article = $this->createDummyArticle('Client Y9-Maths-005 Below Level 2');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['Spring', 'Autumn-Winter'], 'term');
        $article->content->syncTagsWithType(['Maths', 'Higher Education'], 'keyword');
        $article->content->syncTagsWithType(['Below Level 2'], 'neet');
        $this->contentService->makeLive($article->content);

        $this->command->info('Matrix seeding Done!');

    }


    public function createDummyArticle($title)
    {
        return ContentArticle::factory()
            ->has(ContentFactory::new(['client_id' => 1, 'title' => $title, 'slug' => Str::slug($title), 'summary_heading' => $title, 'summary_text' => $title." summary text"])
            ->has(RelatedVideoFactory::new()->times(2))
            ->has(RelatedLinkFactory::new()->times(2))
            )->create(['title' => $title]);

    }
}

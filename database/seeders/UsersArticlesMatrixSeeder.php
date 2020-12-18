<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContentArticle;
use Illuminate\Database\Seeder;
use App\Services\ContentService;
use Database\Factories\ContentFactory;
use Database\Factories\RelatedLinkFactory;
use Database\Factories\RelatedVideoFactory;
use Database\Factories\RelatedDownloadFactory;
use App\Services\Frontend\selfAssessmentService;

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

        $userA = User::factory(['email' => 'usera@rfmedia.co.uk', 'school_year' => 9, 'institution_id' => 1])->create();

        $selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userA);

        $selfAssessment->syncTagsWithType(['Maths'], 'subject');
        $selfAssessment->syncTagsWithType(['Higher education'], 'route');
        $selfAssessment->syncTagsWithType(['Healthcare'], 'sector');
        $selfAssessment->career_readiness_average = 2.5;



        // USER B

        $userB = User::factory(['email' => 'userb@rfmedia.co.uk', 'school_year' => 9, 'institution_id' => 1])->create();

        $this->selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userB);

        $this->selfAssessment->syncTagsWithType(['English'], 'subject');
        $this->selfAssessment->syncTagsWithType(['Apprenticeships'], 'route');
        $this->selfAssessment->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $this->selfAssessment->career_readiness_average = 3.5;



        // USER C

        $userC = User::factory(['email' => 'userc@rfmedia.co.uk', 'school_year' => 10, 'institution_id' => 1])->create();

        $this->selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userC);

        $this->selfAssessment->syncTagsWithType(['Maths'], 'subject');
        $this->selfAssessment->syncTagsWithType(['Higher education'], 'route');
        $this->selfAssessment->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $this->selfAssessment->career_readiness_average = 1.5;



        // USER D

        $userD = User::factory(['email' => 'userd@rfmedia.co.uk', 'school_year' => 10, 'institution_id' => 1])->create();

        $this->selfAssessment = $this->selfAssessmentService->getSelfAssessmentForUser($userD);

        $this->selfAssessment->syncTagsWithType(['English'], 'subject');
        $this->selfAssessment->syncTagsWithType(['Apprenticeships'], 'route');
        $this->selfAssessment->syncTagsWithType(['Healthcare'], 'sector');
        $this->selfAssessment->career_readiness_average = 4.5;




        /*********** ARTICLES *************/


        // Article 001
        $article = $this->createDummyArticle('Y9-Maths-001');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);


        // Article 002
        $article = $this->createDummyArticle('Y9-Higher-002');
        $article->content->syncTagsWithType(['Higher education'], 'route');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 003
        $article = $this->createDummyArticle('Y9-Healthcare-003');
        $article->content->syncTagsWithType(['Healthcare'], 'sector');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 004
        $article = $this->createDummyArticle('Y9-CRS-2-to-3-004');
        $article->content->syncTagsWithType(['2-3'], 'career_readiness');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 005
        $article = $this->createDummyArticle('Y9-English-005');
        $article->content->syncTagsWithType(['English'], 'subject');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 006
        $article = $this->createDummyArticle('Y9-Apprent-006');
        $article->content->syncTagsWithType(['Apprenticeships'], 'route');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 007
        $article = $this->createDummyArticle('Y9-IT-007');
        $article->content->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 008
        $article = $this->createDummyArticle('Y9-CRS-3-to-4-008');
        $article->content->syncTagsWithType(['3-4'], 'career_readiness');
        $article->content->syncTagsWithType(['9'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 009
        $article = $this->createDummyArticle('Y10-Maths-009');
        $article->content->syncTagsWithType(['Maths'], 'subject');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 010
        $article = $this->createDummyArticle('Y10-Higher-010');
        $article->content->syncTagsWithType(['Higher education'], 'route');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 011
        $article = $this->createDummyArticle('Y10-IT-011');
        $article->content->syncTagsWithType(['Computing, Technology and Digital'], 'sector');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 012
        $article = $this->createDummyArticle('Y10-CRS-1-to-2-012');
        $article->content->syncTagsWithType(['1-2'], 'career_readiness');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 013
        $article = $this->createDummyArticle('Y10-English-013');
        $article->content->syncTagsWithType(['English'], 'subject');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 014
        $article = $this->createDummyArticle('Y10-Apprent-014');
        $article->content->syncTagsWithType(['Apprenticeships'], 'route');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 015
        $article = $this->createDummyArticle('Y10-Healthcare-015');
        $article->content->syncTagsWithType(['Healthcare'], 'sector');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 016
        $article = $this->createDummyArticle('Y10-CRS-4-to-5-016');
        $article->content->syncTagsWithType(['4-5'], 'career_readiness');
        $article->content->syncTagsWithType(['10'], 'year');
        $this->contentService->makeLive($article->content);

        // Article 017
        $article = $this->createDummyArticle('Y9-Global');
        $article->content->syncTagsWithType(['9'], 'year');
        $article->content->syncTagsWithType(['global'], 'flag');
        $this->contentService->makeLive($article->content);

        // Article 018
        $article = $this->createDummyArticle('Y10-Global');
        $article->content->syncTagsWithType(['10'], 'year');
        $article->content->syncTagsWithType(['global'], 'flag');
        $this->contentService->makeLive($article->content);

        // Article 019
        $article = $this->createDummyArticle('Global-all');
        $article->content->syncTagsWithType(['global'], 'flag');
        $this->contentService->makeLive($article->content);

        $this->command->info('Matrix seeding Done!');

    }


    public function createDummyArticle($title)
    {
        return ContentArticle::factory()
            ->has(ContentFactory::new(['client_id' => 1, 'title' => $title, 'slug' => $title])
            ->has(RelatedVideoFactory::new()->times(2))
            ->has(RelatedLinkFactory::new()->times(2))
            ->has(RelatedDownloadFactory::new()->times(3))
            )->create(['title' => $title, 'summary_heading' => $title]);

    }
}

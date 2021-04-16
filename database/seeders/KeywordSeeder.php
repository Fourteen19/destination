<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemKeywordTag;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Keywords Tags Table seeding starts!');

        $keywords = [
            [
                'name' => 'Apprenticeships',
                'text' => 'working for a company and studying at the same time',
            ],
            [
                'name' => 'Employment and self-employment',
                'text' => 'working for a company or for yourself',
            ],
            [
                'name' => 'Full-time education',
                'text' => 'studying A levels or vocational courses at a college, sixth form, sixth form
                college or university technical college',
            ],
            [
                'name' => 'Higher education',
                'text' => 'studying for qualifications, such as a degree, at university or college',
            ],
            [
                'name' => 'Traineeships and training',
                'text' => 'studying for the skills you need in a job and getting work experience',
            ],
            [
                'name' => 'Agriculture, Horticulture and Animal Care',
                'text' => '',
            ],
            [
                'name' => 'Art and Design',
                'text' => 'includes subjects such as fine art, graphic design, textiles and photography',
            ],
            [
                'name' => 'Business',
                'text' => '',
            ],
            [
                'name' => 'Childcare',
                'text' => '',
            ],
            [
                'name' => 'Computing and IT',
                'text' => '',
            ],
            [
                'name' => 'Construction',
                'text' => 'includes subjects such construction and the built environment or specific trades such as bench joinery, plastering and bricklaying',
            ],
            [
                'name' => 'Engineering',
                'text' => 'includes subjects such as engineering and manufacturing and light vehicle maintenance and repair',
            ],
            [
                'name' => 'English',
                'text' => '',
            ],
            [
                'name' => 'Hair and Beauty',
                'text' => '',
            ],
            [
                'name' => 'Health and Social Care',
                'text' => '',
            ],
            [
                'name' => 'Hospitality and Catering',
                'text' => 'includes subjects such as professional cookery and food preparation and nutrition',
            ],
            [
                'name' => 'Humanities',
                'text' => 'includes subjects such as history, geography and religious studies',
            ],
            [
                'name' => 'Languages',
                'text' => '',
            ],
            [
                'name' => 'Maths',
                'text' => '',
            ],
            [
                'name' => 'Media',
                'text' => '',
            ],
            [
                'name' => 'Public/Uniformed Services',
                'text' => '',
            ],
            [
                'name' => 'Sciences',
                'text' => 'includes subjects such as biology chemistry and physics',
            ],
            [
                'name' => 'Social Sciences',
                'text' => 'includes subjects such as law, psychology and sociology',
            ],
            [
                'name' => 'Sport',
                'text' => 'includes subjects such as PE, sport and exercise science',
            ],
            [
                'name' => 'Travel and Tourism',
                'text' => '',
            ],
            [
                'name' => 'Agriculture, Environmental and Animal Care',
                'text' => 'examples of jobs in this sector include ecologist, farmer, groundsperson and vet)',
            ],
            [
                'name' => 'Business and Administration',
                'text' => 'examples of jobs in this sector include admin assistant, human resources manager, local government officer and medical secretary)',
            ],
            [
                'name' => 'Catering and Hospitality',
                'text' => 'examples of jobs in this sector include barista, chef, housekeeper and waiter',
            ],
            [
                'name' => 'Computing, Technology and Digital',
                'text' => 'examples of jobs in this sector include cyber intelligence officer, IT support technician, network engineer and software developer',
            ],
            [
                'name' => 'Creative and Media',
                'text' => 'examples of jobs in this sector include blacksmith, graphic designer, newspaper journalist and TV/film producer',
            ],
            [
                'name' => 'Healthcare',
                'text' => 'examples of jobs in this sector include dentist, hospital porter, nurse and physiotherapist',
            ],
            [
                'name' => 'Education and Childcare',
                'text' => 'examples of jobs in this sector include higher education lecturer, nursery worker, primary school teacher and teaching assistant',
            ],
            [
                'name' => 'Emergency and Uniform Services',
                'text' => 'examples of jobs in this sector include firefighter, RAF officer, security officer and soldier',
            ],
            [
                'name' => 'Engineering and Manufacturing',
                'text' => 'examples of jobs in this sector include aerospace engineer, motor mechanic, production worker and textile operative',
            ],
            [
                'name' => 'Legal, Finance and Accounting',
                'text' => 'examples of jobs in this sector include accounting technician, auditor, investment analyst and solicitor',
            ],
            [
                'name' => 'Performing Arts',
                'text' => 'examples of jobs in this sector include actor, dancer, prop maker and stage manager',
            ],
            [
                'name' => 'Science and Research',
                'text' => 'examples of jobs in this sector include clinical scientist, microbiologist, pharmacologist and physicist',
            ],
            [
                'name' => 'Sales, Marketing and Procurement',
                'text' => 'examples of jobs in this sector include marketing executive, retail buyer, sales assistant and visual merchandiser)',
            ],
            [
                'name' => 'Social Care',
                'text' => 'examples of jobs in this sector include adult care worker, probation officer, social worker and youth worker',
            ],
            [
                'name' => 'Sport and Leisure',
                'text' => 'examples of jobs in this sector include football coach, leisure centre assistant, lifeguard and personal trainer',
            ],
            [
                'name' => 'Transport and Logistics',
                'text' => 'examples of jobs in this sector include large goods vehicle driver, packer, supply chain manager and warehouse worker',
            ],
        ];


        $TagsTypes = ['keyword'];

        foreach($TagsTypes as $tagsType)
        {

            if ($tagsType == "keyword")
            {
                $items = $keywords;
            }


            foreach($items as $item)
            {
                $this->createTag($tagsType, $item, 1);
            }

            $this->command->info($tagsType.' Tags created!');

        }

        $this->command->info('Keywords Tags Table seeded!');

    }

    /**
     *
     * Creates the tag in the DB
     *
     */
    public function createTag($tagsType, $item, $clientId)
    {

        SystemKeywordTag::create([
            'name' => $item['name'],
            'text' => isset($item['text']) ? $item['text'] : NULL,
            'type' => $tagsType,
            'live' => 'Y',
            'client_id' => $clientId
       ]);

    }

}

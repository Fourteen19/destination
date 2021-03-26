<?php

namespace App\Http\Livewire\Admin;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Session;

class HomepageArticleSelector extends ArticleSelector
{

    protected $listeners = ['runValidation'];

    public $query= '';
    public array $articles = [];
    public string $selectedArticle = '';
    public int $highlightIndex = 0;
    public bool $showDropdown;
    public bool $includeClientArticles;

    public $label;
    public $name;

    public $rules = ['query' => 'nullable'];
    protected $messages = [
        'query.required' => 'Please select an article',
    ];

    public function mount($label, $articleUuid, $name, $includeClientArticles)
    {
        $this->reset();

        if ($articleUuid)
        {
            $article = ContentLive::where('uuid', '=', $articleUuid)->select('uuid', 'title')->first()->toArray();

            $this->selectedArticle = $article['uuid'];
            $this->query = $article['title'];
        }

        $this->label = $label;
        $this->name = $name;
        $this->includeClientArticles = $includeClientArticles;
    }



    public function runValidation($parentData){

        //extract numbers from $this->name
        //year7_slot1_type would return
        //Array ( [0] => Array([0] => 7, [1] => 1) )
        $data = preg_match_all('!\d+!', $this->name, $matches);

        if ($parentData['year'.$matches[0][0].'_slot'.$matches[0][1].'_type'] == 'managed'){
            $this->rules['query'] = 'required';

            if ($this->query == "")
            {
                $this->emitUp('formHasError', TRUE);
            }

        } else {
            $this->rules['query'] = 'nullable';
        }

        $this->validate();


    }

    public function render()
    {
        return view('livewire.admin.article-selector');
    }

}

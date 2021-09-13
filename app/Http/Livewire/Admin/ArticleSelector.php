<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Content;
use Illuminate\Support\Facades\Session;

class ArticleSelector extends Component
{
    protected $listeners = ['yearSelected' => 'yearSelected'];

    public $query= '';
    public array $articles = [];
    public string $selectedArticle = '0';
    public int $highlightIndex = 0;
    public bool $showDropdown;
    public bool $includeClientArticles;
//    public array $schoolYears = [];

    public $label;
    public $name;
    public $validate;

    public function mount($label, $articleUuid, $name, $includeClientArticles)
    {
        $this->reset();

        if ($articleUuid)
        {
            $article = Content::where('uuid', '=', $articleUuid)->select('uuid', 'title')->first();

            if ($article)
            {
                $article = $article->toArray();

                $this->selectedArticle = $article['uuid'];
                $this->query = $article['title'];
            }
        }

        $this->label = $label;
        $this->name = $name;
        $this->includeClientArticles = $includeClientArticles;
    }

/*     public function yearSelected($yearsFilter)
    {
        $postIndex = array_search("post", $yearsFilter);
        if ($postIndex)
        {
            $yearsFilter[$postIndex] = "14";
        }
        $this->schoolYears = $yearsFilter;

    } */

    public function reset(...$properties)
    {
        $this->articles = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedArticle = 0;
        $this->showDropdown = true;
        $this->emitUp('article_selector', [$this->name, NULL]);
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->articles) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->articles) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function selectArticle($id = null)
    {

        $id = $id ?: $this->highlightIndex;

        $article = $this->articles[$id] ?? null;

        if ($article) {
            //$this->showDropdown = true;
            $this->hideDropdown();
            $this->query = $article['title'];
            $this->selectedArticle = $article['uuid'];
            $this->emitUp('article_selector', [$this->name, $article['uuid']]);
        }
    }

    /**
     * updatedQuery
     * if includeClientArticles is TRUE, then display global and client articles
     * if includeClientArticles is FALSE, then display global articles
     *
     * @return void
     */
    public function updatedQuery()
    {

        if (strlen($this->query) > 2)
        {

            if ($this->includeClientArticles)
            {
                $articles = Content::where('title', 'like', '%' . $this->query. '%')
                    ->select('uuid', 'title')
                    ->CanSeeClientAndGlobal(Session::get('adminClientSelectorSelected'))
                    ->orderBy('title', 'asc');
                //    ->withAnyTags($this->schoolYears, 'year');

            } else {
                $articles = Content::where('title', 'like', '%' . $this->query. '%')
                    ->select('uuid', 'title')
                    ->where('client_id', '=', NULL)
                    ->orderBy('title', 'asc');
               //     ->withAnyTags($this->schoolYears, 'year');

            }

            $this->articles = $articles->get()->toArray();

        }

        return NULL;

    }


    public function render()
    {
        return view('livewire.admin.article-selector');
    }

}

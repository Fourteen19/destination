<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\ContentLive;

class ArticleSelector extends Component
{
    public $query= '';
    public array $articles = [];
    public string $selectedArticle = '';
    public int $highlightIndex = 0;
    public bool $showDropdown;

    public $label;
    public $name;

    public function mount($label, $articleUuid, $name)
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
    }

    public function reset(...$properties)
    {
        $this->articles = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedArticle = '';
        $this->showDropdown = true;
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

        $account = $this->articles[$id] ?? null;

        if ($account) {
            //$this->showDropdown = true;
            $this->hideDropdown();
            $this->query = $account['title'];
            $this->selectedArticle = $account['uuid'];
            $this->emitUp('article_selector', [$this->name, $account['uuid']]);
        }
    }

    public function updatedQuery()
    {
        $this->articles = ContentLive::where('title', 'like', '%' . $this->query. '%')->select('uuid', 'title')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.article-selector');
    }
}

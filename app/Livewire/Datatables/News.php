<?php

namespace App\Livewire\Datatables;

use App\Models\News as NewsModel;
use Illuminate\Database\Eloquent\Builder;
use Redot\Datatables\Actions\Action;
use Redot\Datatables\Columns\TernaryColumn;
use Redot\Datatables\Columns\TextColumn;
use Redot\Datatables\Datatable;
use Redot\Datatables\Filters\StringFilter;
use Redot\Datatables\Filters\TernaryFilter;

class News extends Datatable
{
    /**
     * Get the query source of the datatable.
     */
    public function query(): Builder
    {
        return NewsModel::query()->with('category');
    }

    /**
     * Get the columns for the datatable.
     */
    public function columns(): array
    {
        return [
            TextColumn::make('title', __('Title'))
                ->searchable()
                ->sortable(),
            TextColumn::make('locale', __('Locale'))
                ->sortable(),
            TextColumn::make('category.title', __('Category'))
                ->sortable(),
            TernaryColumn::make('published_at', __('Published')),
        ];
    }

    /**
     * Get the actions for the datatable.
     */
    public function actions(): array
    {
        return Datatable::defaultActionGroup([
            Action::edit('dashboard.news.edit'),
            Action::delete('dashboard.news.destroy'),
        ]);
    }

    /**
     * Get the filters for the datatable.
     */
    public function filters(): array
    {
        return [
            StringFilter::make('title', __('Title')),
            StringFilter::make('locale', __('Locale')),
            TernaryFilter::make(label: __('Published'))
                ->queries(
                    yes: fn (Builder $query) => $query->published(),
                    no: fn (Builder $query) => $query->unpublished(),
                ),
        ];
    }
}

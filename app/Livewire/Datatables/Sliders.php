<?php

namespace App\Livewire\Datatables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Redot\Datatables\Actions\Action;
use Redot\Datatables\Columns\DateColumn;
use Redot\Datatables\Columns\TernaryColumn;
use Redot\Datatables\Columns\TextColumn;
use Redot\Datatables\Datatable;
use Redot\Datatables\Filters\DateFilter;
use Redot\Datatables\Filters\SelectFilter;
use Redot\Datatables\Filters\StringFilter;
use Redot\Datatables\Filters\TernaryFilter;

class Sliders extends Datatable
{
    /**
     * Get the query source of the datatable.
     */
    public function query(): Builder
    {
        return Slider::query();
    }

    /**
     * Get the columns for the datatable.
     */
    public function columns(): array
    {
        return [
            TextColumn::make('locale', __('Locale'))
                ->width('120px')
                ->getter(fn (string $locale) => config('app.locales.' . $locale))
                ->sortable(),
            TextColumn::make('title', __('Title'))
                ->width('100%', min: '300px')
                ->sortable()
                ->searchable(),
            TernaryColumn::make('active', __('Active'))
                ->sortable(),
            DateColumn::make('created_at', __('Created At'))
                ->width('200px')
                ->sortable(),
        ];
    }

    /**
     * Get the actions for the datatable.
     */
    public function actions(): array
    {
        return Datatable::defaultActionGroup([
            Action::edit('dashboard.sliders.edit')->visible(route_allowed('dashboard.sliders.edit')),
            Action::delete('dashboard.sliders.destroy')->visible(route_allowed('dashboard.sliders.destroy')),
        ]);
    }

    /**
     * Get the filters for the datatable.
     */
    public function filters(): array
    {
        return [
            SelectFilter::make('locale', __('Locale'))
                ->options(collect(config('app.locales'))),
            StringFilter::make('title', __('Title')),
            TernaryFilter::make('active', __('Active')),
            DateFilter::make('created_at', __('Created At')),
        ];
    }
}

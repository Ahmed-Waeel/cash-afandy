<?php

namespace App\Livewire\Datatables;

use App\Models\Broker;
use Illuminate\Database\Eloquent\Builder;
use Redot\Datatables\Actions\Action;
use Redot\Datatables\Columns\TextColumn;
use Redot\Datatables\Datatable;
use Redot\Datatables\Filters\StringFilter;

class Brokers extends Datatable
{
    /**
     * Get the query source of the datatable.
     */
    public function query(): Builder
    {
        return Broker::query();
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
            TextColumn::make('email', __('Email'))
                ->searchable()
                ->sortable(),
            TextColumn::make('phone', __('Phone'))
                ->searchable()
                ->sortable(),
        ];
    }

    /**
     * Get the actions for the datatable.
     */
    public function actions(): array
    {
        return Datatable::defaultActionGroup([
            Action::edit('dashboard.brokers.edit'),
            Action::delete('dashboard.brokers.destroy'),
        ]);
    }

    /**
     * Get the filters for the datatable.
     */
    public function filters(): array
    {
        return [
            StringFilter::make('title', __('Title')),
            StringFilter::make('email', __('Email')),
            StringFilter::make('phone', __('Phone')),
        ];
    }
}

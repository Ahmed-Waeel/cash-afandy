<?php

namespace App\Livewire\Datatables;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Redot\Datatables\Actions\Action;
use Redot\Datatables\Columns\TextColumn;
use Redot\Datatables\Datatable;
use Redot\Datatables\Filters\SelectFilter;

class Subscribers extends Datatable
{
    /**
     * Get the query source of the datatable.
     */
    public function query(): Builder
    {
        return Subscriber::query();
    }

    /**
     * Get the columns for the datatable.
     */
    public function columns(): array
    {
        return [
            TextColumn::make('user.full_name', __('Name'))
                ->sortable()
                ->searchable(),

            TextColumn::make('email', __('Email'))
                ->sortable()
                ->searchable(),

            TextColumn::make('gender', __('Gender'))
                ->getter(fn ($subscriber) => __(ucfirst($subscriber->gender)))
                ->sortable(),

            TextColumn::make('created_at', __('Subscribed At'))
                ->getter(fn ($subscriber) => $subscriber->created_at->format('Y-m-d H:i'))
                ->sortable(),
        ];
    }

    /**
     * Get the actions for the datatable.
     */
    public function actions(): array
    {
        return [
            Action::delete('dashboard.subscribers.destroy')->visible(route_allowed('dashboard.subscribers.destroy')),
        ];
    }

    /**
     * Get the filters for the datatable.
     */
    public function filters(): array
    {
        return [
            SelectFilter::make('gender', __('Gender'))
                ->options(['male' => __('Male'), 'female' => __('Female')]),
        ];
    }
}

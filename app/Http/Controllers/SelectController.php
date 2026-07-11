<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Redot\Http\Controllers\Controller;
use Redot\Traits\RespondAsApi;

class SelectController extends Controller
{
    use RespondAsApi;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'term' => 'nullable|string',
            'limit' => 'nullable|integer|min:1|max:100',
            'parameters' => 'nullable|array',
        ]);

        $data = json_decode(decrypt($request->data));
        $term = trim($request->query('term', ''));
        $limit = (int) $request->query('limit', 20);

        // Merge the parameters with the term.
        $parameters = array_merge($request->query('parameters', []), [$data->term => $term]);
        $parameters = collect($parameters)->mapWithKeys(fn ($value, $key) => [sprintf('{%s}', $key) => $value])->toArray();
        $bindings = str_replace(array_keys($parameters), array_values($parameters), $data->bindings ?? []);

        // Prepare the query.
        $query = $data->query . " limit $limit";

        $items = $this->prepareResults(DB::select($query, $bindings), $data);

        return $this->respond([
            'data' => $items,
            'count' => count($items),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'ids' => 'required|string',
            'parameters' => 'nullable|array',
        ]);

        $data = json_decode(decrypt($request->data));
        $ids = array_values(array_filter(parse_csv($request->query('ids')), fn ($id) => filled($id)));

        if (blank($ids)) {
            return $this->respond([
                'data' => [],
                'count' => 0,
            ]);
        }

        $uniqid = uniqid('cte_');
        $key = $data->key;

        // Merge the parameters with the term.
        $parameters = array_merge($request->query('parameters', []), [$data->term => '']);
        $parameters = collect($parameters)->mapWithKeys(fn ($value, $key) => [sprintf('{%s}', $key) => $value])->toArray();
        $bindings = str_replace(array_keys($parameters), array_values($parameters), $data->bindings ?? []);
        $bindings = array_values((array) $bindings);

        // Prepare the query.
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "select $key from ($data->query) as $uniqid where $uniqid.$key in ($placeholders)";
        $bindings = [...$bindings, ...$ids];

        $items = $this->prepareResults(DB::select($query, $bindings), $data);

        return $this->respond([
            'data' => $items,
            'count' => count($items),
        ]);
    }

    /**
     * Prepare the results to be returned.
     */
    protected function prepareResults(array $items, $data): array
    {
        $model = $data->model;
        $columns = array_merge($data->columns, $data->appends ?? []);

        $relations = [];
        foreach ($columns as $column) {
            $relations = array_merge($relations, $this->extractRelations($column));
        }

        $items = array_column($items, $data->key);
        $items = $model::whereIn($data->key, $items)->with(array_unique($relations))->get();

        // Map the items to the required format.
        $items = $items->map(function ($item) use ($data, $columns) {
            $arr = $item->toArray();
            $arr = Arr::only(Arr::dot($arr), $columns);

            return array_merge([
                '__value' => Arr::get($arr, $data->key),
                '__text' => Arr::get($arr, $data->text),
                '__html' => $data->template ? view($data->template, ['item' => $item])->render() : '',
            ], $arr);
        });

        return $items->toArray();
    }

    /**
     * Extract relations from the column.
     */
    protected function extractRelations($column)
    {
        $relations = explode('.', $column);

        // Remove the last element.
        array_pop($relations);

        return $relations;
    }
}

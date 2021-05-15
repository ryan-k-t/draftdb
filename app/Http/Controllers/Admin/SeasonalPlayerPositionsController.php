<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeasonalPlayerPosition\BulkDestroySeasonalPlayerPosition;
use App\Http\Requests\Admin\SeasonalPlayerPosition\DestroySeasonalPlayerPosition;
use App\Http\Requests\Admin\SeasonalPlayerPosition\IndexSeasonalPlayerPosition;
use App\Http\Requests\Admin\SeasonalPlayerPosition\StoreSeasonalPlayerPosition;
use App\Http\Requests\Admin\SeasonalPlayerPosition\UpdateSeasonalPlayerPosition;
use App\Models\SeasonalPlayerPosition;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeasonalPlayerPositionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSeasonalPlayerPosition $request
     * @return array|Factory|View
     */
    public function index(IndexSeasonalPlayerPosition $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SeasonalPlayerPosition::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'seasonal_player_id', 'position_id'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.seasonal-player-position.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.seasonal-player-position.create');

        return view('admin.seasonal-player-position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSeasonalPlayerPosition $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSeasonalPlayerPosition $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SeasonalPlayerPosition
        $seasonalPlayerPosition = SeasonalPlayerPosition::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/seasonal-player-positions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/seasonal-player-positions');
    }

    /**
     * Display the specified resource.
     *
     * @param SeasonalPlayerPosition $seasonalPlayerPosition
     * @throws AuthorizationException
     * @return void
     */
    public function show(SeasonalPlayerPosition $seasonalPlayerPosition)
    {
        $this->authorize('admin.seasonal-player-position.show', $seasonalPlayerPosition);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SeasonalPlayerPosition $seasonalPlayerPosition
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SeasonalPlayerPosition $seasonalPlayerPosition)
    {
        $this->authorize('admin.seasonal-player-position.edit', $seasonalPlayerPosition);


        return view('admin.seasonal-player-position.edit', [
            'seasonalPlayerPosition' => $seasonalPlayerPosition,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSeasonalPlayerPosition $request
     * @param SeasonalPlayerPosition $seasonalPlayerPosition
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSeasonalPlayerPosition $request, SeasonalPlayerPosition $seasonalPlayerPosition)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SeasonalPlayerPosition
        $seasonalPlayerPosition->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/seasonal-player-positions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/seasonal-player-positions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySeasonalPlayerPosition $request
     * @param SeasonalPlayerPosition $seasonalPlayerPosition
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySeasonalPlayerPosition $request, SeasonalPlayerPosition $seasonalPlayerPosition)
    {
        $seasonalPlayerPosition->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySeasonalPlayerPosition $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySeasonalPlayerPosition $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SeasonalPlayerPosition::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

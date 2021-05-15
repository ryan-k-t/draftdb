<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeasonalPlayer\BulkDestroySeasonalPlayer;
use App\Http\Requests\Admin\SeasonalPlayer\DestroySeasonalPlayer;
use App\Http\Requests\Admin\SeasonalPlayer\IndexSeasonalPlayer;
use App\Http\Requests\Admin\SeasonalPlayer\StoreSeasonalPlayer;
use App\Http\Requests\Admin\SeasonalPlayer\UpdateSeasonalPlayer;
use App\Models\SeasonalPlayer;
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

class SeasonalPlayerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSeasonalPlayer $request
     * @return array|Factory|View
     */
    public function index(IndexSeasonalPlayer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SeasonalPlayer::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'player_id', 'season', 'school', 'city', 'state', 'classification_id', 'commitment', 'height', 'weight', 'bats', 'throws'],

            // set columns to searchIn
            ['id', 'school', 'city', 'state', 'commitment']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.seasonal-player.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.seasonal-player.create');

        return view('admin.seasonal-player.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSeasonalPlayer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSeasonalPlayer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SeasonalPlayer
        $seasonalPlayer = SeasonalPlayer::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/seasonal-players'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/seasonal-players');
    }

    /**
     * Display the specified resource.
     *
     * @param SeasonalPlayer $seasonalPlayer
     * @throws AuthorizationException
     * @return void
     */
    public function show(SeasonalPlayer $seasonalPlayer)
    {
        $this->authorize('admin.seasonal-player.show', $seasonalPlayer);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SeasonalPlayer $seasonalPlayer
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SeasonalPlayer $seasonalPlayer)
    {
        $this->authorize('admin.seasonal-player.edit', $seasonalPlayer);


        return view('admin.seasonal-player.edit', [
            'seasonalPlayer' => $seasonalPlayer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSeasonalPlayer $request
     * @param SeasonalPlayer $seasonalPlayer
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSeasonalPlayer $request, SeasonalPlayer $seasonalPlayer)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SeasonalPlayer
        $seasonalPlayer->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/seasonal-players'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/seasonal-players');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySeasonalPlayer $request
     * @param SeasonalPlayer $seasonalPlayer
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySeasonalPlayer $request, SeasonalPlayer $seasonalPlayer)
    {
        $seasonalPlayer->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySeasonalPlayer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySeasonalPlayer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SeasonalPlayer::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

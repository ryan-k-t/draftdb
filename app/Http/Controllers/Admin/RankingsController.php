<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ranking\BulkDestroyRanking;
use App\Http\Requests\Admin\Ranking\DestroyRanking;
use App\Http\Requests\Admin\Ranking\IndexRanking;
use App\Http\Requests\Admin\Ranking\StoreRanking;
use App\Http\Requests\Admin\Ranking\UpdateRanking;
use App\Models\Ranking;
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

class RankingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRanking $request
     * @return array|Factory|View
     */
    public function index(IndexRanking $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Ranking::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'seasonal_player_id', 'ranking_instance_id', 'rank'],

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

        return view('admin.ranking.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ranking.create');

        return view('admin.ranking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRanking $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRanking $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Ranking
        $ranking = Ranking::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/rankings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/rankings');
    }

    /**
     * Display the specified resource.
     *
     * @param Ranking $ranking
     * @throws AuthorizationException
     * @return void
     */
    public function show(Ranking $ranking)
    {
        $this->authorize('admin.ranking.show', $ranking);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ranking $ranking
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Ranking $ranking)
    {
        $this->authorize('admin.ranking.edit', $ranking);


        return view('admin.ranking.edit', [
            'ranking' => $ranking,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRanking $request
     * @param Ranking $ranking
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRanking $request, Ranking $ranking)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Ranking
        $ranking->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/rankings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/rankings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRanking $request
     * @param Ranking $ranking
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRanking $request, Ranking $ranking)
    {
        $ranking->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRanking $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRanking $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Ranking::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RankingInstance\BulkDestroyRankingInstance;
use App\Http\Requests\Admin\RankingInstance\DestroyRankingInstance;
use App\Http\Requests\Admin\RankingInstance\IndexRankingInstance;
use App\Http\Requests\Admin\RankingInstance\StoreRankingInstance;
use App\Http\Requests\Admin\RankingInstance\UpdateRankingInstance;
use App\Models\RankingInstance;
use App\Models\Source;
use App\Http\Resources\RankingInstance as RankingInstanceResource;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Libraries\RankingsImporter;

class RankingInstancesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRankingInstance $request
     * @return array|Factory|View
     */
    public function index(IndexRankingInstance $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(RankingInstance::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'source_id', 'season', 'date'],

            // set columns to searchIn
            ['id'],

            function ($query) use ($request) {
                $query->with(['source']);
                if($request->has('sources')){
                    $query->whereIn('source_id', $request->get('sources'));
                }
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ranking-instance.index', [
            'data' => $data,
            'sources' => Source::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ranking-instance.create');

        return view('admin.ranking-instance.create', [
            'sources' => Source::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRankingInstance $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRankingInstance $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['source_id'] = $request->getSourceId();

        // Store the RankingInstance
        $rankingInstance = RankingInstance::create($sanitized);

        // now process the import data
        $importer = new RankingsImporter( $rankingInstance, $sanitized['import_file'][0]['path']);
        $import_errors = $importer->process();
        Log::debug( print_r( $import_errors, true));

        // if errors, delete the rankingInstance
        if( is_array($import_errors) && count( $import_errors ) > 0):
            //delete
            $rankingInstance->delete();
            //return errors
            return response()->json([
                'success' => FALSE,
                'message' => "Unable to process import file"
            ], 422);
        endif;

        if ($request->ajax()) {
            return ['redirect' => url('admin/ranking-instances'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ranking-instances');
    }

    /**
     * Display the specified resource.
     *
     * @param RankingInstance $rankingInstance
     * @throws AuthorizationException
     * @return void
     */
    public function show(RankingInstance $rankingInstance)
    {
        $this->authorize('admin.ranking-instance.show', $rankingInstance);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RankingInstance $rankingInstance
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(RankingInstance $rankingInstance)
    {
        $this->authorize('admin.ranking-instance.edit', $rankingInstance);


        return view('admin.ranking-instance.edit', [
            'rankingInstance' => new RankingInstanceResource( $rankingInstance ),
            'selectedSource' => $rankingInstance->source,
            'sources' => Source::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRankingInstance $request
     * @param RankingInstance $rankingInstance
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRankingInstance $request, RankingInstance $rankingInstance)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['source_id'] = $request->getSourceId();

        // Update changed values RankingInstance
        $rankingInstance->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ranking-instances'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ranking-instances');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRankingInstance $request
     * @param RankingInstance $rankingInstance
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRankingInstance $request, RankingInstance $rankingInstance)
    {
        $rankingInstance->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRankingInstance $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRankingInstance $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    RankingInstance::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

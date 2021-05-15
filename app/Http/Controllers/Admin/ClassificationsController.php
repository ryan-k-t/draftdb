<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Classification\BulkDestroyClassification;
use App\Http\Requests\Admin\Classification\DestroyClassification;
use App\Http\Requests\Admin\Classification\IndexClassification;
use App\Http\Requests\Admin\Classification\StoreClassification;
use App\Http\Requests\Admin\Classification\UpdateClassification;
use App\Models\Classification;
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

class ClassificationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexClassification $request
     * @return array|Factory|View
     */
    public function index(IndexClassification $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Classification::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description'],

            // set columns to searchIn
            ['id', 'name', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.classification.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.classification.create');

        return view('admin.classification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClassification $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreClassification $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Classification
        $classification = Classification::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/classifications'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/classifications');
    }

    /**
     * Display the specified resource.
     *
     * @param Classification $classification
     * @throws AuthorizationException
     * @return void
     */
    public function show(Classification $classification)
    {
        $this->authorize('admin.classification.show', $classification);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Classification $classification
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Classification $classification)
    {
        $this->authorize('admin.classification.edit', $classification);


        return view('admin.classification.edit', [
            'classification' => $classification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClassification $request
     * @param Classification $classification
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateClassification $request, Classification $classification)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Classification
        $classification->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/classifications'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/classifications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyClassification $request
     * @param Classification $classification
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyClassification $request, Classification $classification)
    {
        $classification->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyClassification $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyClassification $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Classification::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

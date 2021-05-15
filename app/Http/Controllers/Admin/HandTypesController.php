<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HandType\BulkDestroyHandType;
use App\Http\Requests\Admin\HandType\DestroyHandType;
use App\Http\Requests\Admin\HandType\IndexHandType;
use App\Http\Requests\Admin\HandType\StoreHandType;
use App\Http\Requests\Admin\HandType\UpdateHandType;
use App\Models\HandType;
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

class HandTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexHandType $request
     * @return array|Factory|View
     */
    public function index(IndexHandType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(HandType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.hand-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.hand-type.create');

        return view('admin.hand-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHandType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreHandType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the HandType
        $handType = HandType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/hand-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/hand-types');
    }

    /**
     * Display the specified resource.
     *
     * @param HandType $handType
     * @throws AuthorizationException
     * @return void
     */
    public function show(HandType $handType)
    {
        $this->authorize('admin.hand-type.show', $handType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HandType $handType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(HandType $handType)
    {
        $this->authorize('admin.hand-type.edit', $handType);


        return view('admin.hand-type.edit', [
            'handType' => $handType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHandType $request
     * @param HandType $handType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateHandType $request, HandType $handType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values HandType
        $handType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hand-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/hand-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyHandType $request
     * @param HandType $handType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyHandType $request, HandType $handType)
    {
        $handType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyHandType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyHandType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    HandType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

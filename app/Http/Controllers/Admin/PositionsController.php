<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Position\BulkDestroyPosition;
use App\Http\Requests\Admin\Position\DestroyPosition;
use App\Http\Requests\Admin\Position\IndexPosition;
use App\Http\Requests\Admin\Position\StorePosition;
use App\Http\Requests\Admin\Position\UpdatePosition;
use App\Models\Position;
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

class PositionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPosition $request
     * @return array|Factory|View
     */
    public function index(IndexPosition $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Position::class)->processRequestAndGet(
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

        return view('admin.position.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.position.create');

        return view('admin.position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePosition $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePosition $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Position
        $position = Position::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/positions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/positions');
    }

    /**
     * Display the specified resource.
     *
     * @param Position $position
     * @throws AuthorizationException
     * @return void
     */
    public function show(Position $position)
    {
        $this->authorize('admin.position.show', $position);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Position $position
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Position $position)
    {
        $this->authorize('admin.position.edit', $position);


        return view('admin.position.edit', [
            'position' => $position,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePosition $request
     * @param Position $position
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePosition $request, Position $position)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Position
        $position->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/positions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/positions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPosition $request
     * @param Position $position
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPosition $request, Position $position)
    {
        $position->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPosition $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPosition $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Position::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Player\BulkDestroyPlayer;
use App\Http\Requests\Admin\Player\DestroyPlayer;
use App\Http\Requests\Admin\Player\IndexPlayer;
use App\Http\Requests\Admin\Player\StorePlayer;
use App\Http\Requests\Admin\Player\UpdatePlayer;
use App\Models\Player;
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

class PlayersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPlayer $request
     * @return array|Factory|View
     */
    public function index(IndexPlayer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Player::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'middle_name', 'last_name', 'preferred_name', 'date_of_birth'],

            // set columns to searchIn
            ['id', 'first_name', 'middle_name', 'last_name', 'preferred_name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.player.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.player.create');

        return view('admin.player.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlayer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePlayer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Player
        $player = Player::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/players'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/players');
    }

    /**
     * Display the specified resource.
     *
     * @param Player $player
     * @throws AuthorizationException
     * @return void
     */
    public function show(Player $player)
    {
        $this->authorize('admin.player.show', $player);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Player $player)
    {
        $this->authorize('admin.player.edit', $player);


        return view('admin.player.edit', [
            'player' => $player,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePlayer $request
     * @param Player $player
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePlayer $request, Player $player)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Player
        $player->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/players'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/players');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPlayer $request
     * @param Player $player
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPlayer $request, Player $player)
    {
        $player->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPlayer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPlayer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Player::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}

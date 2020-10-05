<?php
/**
 * Copyright (c) 2018.
 * @author Antony [leantony] Chacha
 */

namespace Leantony\Grid\Listeners;

use Leantony\Grid\Events\UserActionRequested;

class HandleUserAction
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserActionRequested $event
     * @return mixed
     * @throws \Throwable
     */
    public function handle(UserActionRequested $event)
    {
        $parametersKey = $event->grid->getSessionFiltersKey();
        if ($event->grid->saveFiltersInSession() && empty($event->request->query()) && $event->request->session()->has($parametersKey)) {
            $event->request->merge($event->request->session()->get($parametersKey));
        } elseif($event->request->query('reset')) {
            $event->request->session()->forget($parametersKey);
            \App::abort(302, '', ['Location' => url()->current()]);
        }
        
        if (!empty($event->request->query())) {
            if (!in_array($parametersKey, ['export'])) {
                $event->request->session()->put($parametersKey, $event->request->query());
            }

            if ($event->request->has($event->grid->getGridSearchParam())) {
                // search
                (new SearchDataHandler(
                    $event->grid, $event->request,
                    $event->builder, $event->validTableColumns, $event->args
                ))->searchRows();

            } else {
                // filter
                (new RowFilterHandler(
                    $event->grid, $event->request,
                    $event->builder, $event->validTableColumns, $event->args
                ))->filterRows();
            }

            // sort
            (new SortDataHandler(
                $event->grid, $event->request,
                $event->builder, $event->validTableColumns, $event->args
            ))->sort();
        }

        $paginator = (new GridPaginationHandler($event->grid, $event->request, $event->builder));

        // export
        if ($event->request->has($event->grid->getGridExportParam())) {
            // do not export at this point
            return [
                'exporter' => (new DataExportHandler(
                    $event->grid, $event->request,
                    $event->builder, $event->validTableColumns, $event->args
                )),
                'data' => $paginator->paginate()
            ];
        }
        // paginate
        return $paginator->paginate();
    }
}
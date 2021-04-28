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
        } elseif($event->request->query('reset') == $parametersKey) {
            $event->request->session()->forget($parametersKey);
            \App::abort(302, '', ['Location' => url()->current()]);
        }
        
        if (!empty($event->request->query())) {
            $queryParams = $event->request->query();
            $validColumns = $event->validTableColumns;

            foreach($queryParams as $queryParam => $queryValue) {
                $queryParamCandidate = str_replace($event->grid->getGridDatabaseTable()().'_', '', $queryParam);
                if(!in_array($queryParamCandidate, $validColumns) && $queryParam != 'p-'.$event->grid->getId()) {
                    unset($queryParams[$queryParam]);
                }
            }

            if (!empty($queryParams)) {
                $event->request->session()->put($parametersKey, $queryParams);
            }

            if ($event->request->has($event->grid->getGridSearchParam() . '-' . $event->grid->getId())) {
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
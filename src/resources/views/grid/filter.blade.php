@foreach($columns as $col)
    @if(!$col->filter)
        <th></th>
    @elseif(!$col->filter->enabled)
        <th></th>
    @else
        <th>
            {!! $col->filter->render(['titleSetOnColumn' => $col->filterTitle]) !!}
        </th>
    @endif
    @if($loop->last)
        <th class="{{ $grid->getGridFilterFieldColumnClass() }}">
            <div class="pull-right">
                <button type="submit"
                        class="btn btn-outline-primary grid-filter-button"
                        title="{{ __('Filter data') }}"
                        form="{{ $formId }}"><i class="fa fa-filter"></i> {{ __('Filter') }}
                </button>
                @if( $grid->isFiltered() )
                    <input type="hidden" name="reset" class="grid_filter_reset" value="0" form="{{ $formId }}"/>
                    <button type="submit"
                            class="btn btn-outline-primary grid-reset-button"
                            title="{{ __('Filter filters') }}"
                            onclick="javascript:jQuery(this).parent().find('.grid_filter_reset').val(1);return true;"
                            form="{{ $formId }}"><i class="fas fa-minus"></i> {{ __('Reset') }}
                    </button>
                @endif
            </div>
        </th>
    @endif
@endforeach

<?php

namespace App\Nova;

use App\Models\Enums\AttrType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MemberAttr extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\MemberAttr>
     */
    public static $model = \App\Models\MemberAttr::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'attr_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'attr_name', 'attr_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make(__('Attribute Type'), 'attr_type')
                ->displayUsingLabels()
                ->readonly(function (NovaRequest $request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                })
                ->options(AttrType::getOptions()),

            Text::make(__('Attribute Name'), 'attr_name'),

            Text::make(__('Attribute ID'), 'attr_id')
                ->readonly(function (NovaRequest $request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

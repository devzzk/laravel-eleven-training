<?php

namespace App\Nova;

use App\Models\Enums\Gender;
use App\Models\MemberAttr;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Member extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Member>
     */
    public static $model = \App\Models\Member::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->filterable(),
            Text::make(__('Name'), 'nick_name')
                ->filterable(),

            Select::make(__('Gender'), 'info.gender')
                ->displayUsingLabels()
                ->options(Gender::getOptions()),

            Date::make(__('Birthday'), 'info.birthday'),

            KeyValue::make(__('Open Id'), 'openid'),

            Text::make(__('Union Id'), 'union_id'),

            Text::make(__('Phone'), 'info.phone_number')
                ->displayUsing(function ($phoneNumber) {
                    return $phoneNumber ? substr_replace($phoneNumber, '****', 3, 4) : null;
                }),

            Number::make(__('Point'), 'point'),

            Select::make(__('Level'), 'level')
                ->displayUsingLabels()
                ->options(function () {
                    return [];
                }),

            Number::make(__('Experience'), 'experience')
                ->hideFromIndex(),

            Text::make(__('Source'), 'source_code'),

            Text::make(__('login_id'))
                ->hideFromIndex()
                ->filterable(function ($request, $query, $value) {
                    return $query->where('login_id', md5($value));
                }),

            KeyValue::make(__('Other Data'), function () {
                $data = $this->other_data;
                $attrs = MemberAttr::pluck('attr_name', 'attr_id');
                $results = collect();
                collect($data)->each(function ($item, $key) use ($attrs, &$results) {
                    $results->put($attrs[$key], $item);
                });

                return $results->toArray();
            }),

            Text::make(__('First Name'), 'info.first_name')
                ->hideFromIndex(),
            Text::make(__('Last Name'), 'info.last_name')
                ->hideFromIndex(),
            Text::make(__('Country'), 'info.country')
                ->hideFromIndex(),
            Text::make(__('Province'), 'info.province')
                ->hideFromIndex(),
            Text::make(__('City'), 'info.city')
                ->hideFromIndex(),
            Text::make(__('District'), 'info.district')
                ->hideFromIndex(),
            Text::make(__('Address'), 'info.address')
                ->hideFromIndex(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

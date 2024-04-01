<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\ProductBrand;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function  subtitle(){
        return "Brand: {$this->brand->name} ";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'description', 'sku',
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
            //ID::make()->sortable(),
            Slug::make('Slug')
            ->from('name')
            ->required()
            ->withMeta(
                ['extraAttributes' =>[
                    'readonly' => true
                ]
            ])
            ->hideFromIndex()
            ->textAlign('left'),

            Text::make('Name')
            ->required()
            ->showOnPreview()
            ->placeholder('Product Name...')
            ->textAlign('left')
            ->sortable(),

            Markdown::make('Description')
            ->required()
            ->showOnPreview(),

            Currency::make('Price')
            ->required()
            ->showOnPreview()
            ->placeholder('Product price')
            ->textAlign('right')
            ->sortable(),

            Text::make('Sku')
            ->required()
            ->placeholder('Product SKU')
            ->textAlign('center')
            ->sortable()
            ->help('Number that retailers use to differentiate products and track inventory levels.'),

            Number::make('Quantity')
            ->required()
            ->showOnPreview()
            ->placeholder('Product Quantity')
            ->textAlign('right')
            ->sortable(),

            //relation 1 Product belong 1 branch
            BelongsTo::make('Brand'),

            Boolean::make('Status', 'is_published')
            ->required()
            ->showOnPreview()
            ->textAlign('center')
            ->sortable(),

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
        return [
            new ProductBrand()
        ];
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

    //allow compact lines
    public static $tableStyle = 'tight';

    //show borders of columns in index view
    //public static $showColumnBorders = true;

    //replace/modify behaivour of click on rows
    public static $clickAction = 'edit'; //ignore

    //quantity of results per page
    public static $perPageOptions = [1,3,5];

}

<?php

namespace App\Orchid\Resources;

use App\Http\Requests\ClipRequest;
use App\Models\Client;
use App\Models\Clip;
use App\Models\Direction;
use App\Models\Manager;
use App\View\Components\Admin\SightImage;
use Illuminate\Http\Request;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Upload;

class ClipResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Clip::class;

    public static function label():string
    {
        return __('Clips');
    }

    public static function singularLabel():string
    {
        return __('Clip');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title(__('Name')),

            Relation::make('direction_id')
                ->title(__('Direction'))
                ->fromModel(Direction::class, 'name'),

            Relation::make('client_id')
                ->title(__('Client'))
                ->fromModel(Client::class, 'name'),

            Relation::make('manager_id')
                ->title(__('Manager'))
                ->fromModel(Manager::class, 'name'),

            Upload::make('file')
                ->groups('file')
                ->title('File'),

            DateTimer::make('date_start')
                ->title(__('Start date'))
                ->format24hr()
                ->enableTime(),

            DateTimer::make('date_end')
                ->title(__('End date')),

            CheckBox::make('archived')
                ->title(__('Located in the archive'))
                ->sendTrueOrFalse()

        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),

            TD::make('name', __('Name')),

            TD::make('direction', __('Direction'))
                ->render(function(Clip $model){
                    return $model->direction->name;
                }),

            TD::make('client', __('Client'))
                ->render(function(Clip $model){
                    return $model->client->name;
                }),

            TD::make('manager', __('Manager'))
                ->render(function(Clip $model){
                    return $model->manager->name;
                }),

            TD::make('date_start', __('Start date')),

            TD::make('date_end', __('End date')),

            TD::make('archived', __('Archived'))
                ->render(function(Clip $model){
                    return $model->archived ? __('Yes') : __('No');
                }),

        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),

            Sight::make('name', __('Name')),

            Sight::make('direction', __('Direction'))
                ->render(function(Clip $model){
                    return $model->direction->name;
                }),

            Sight::make('client', __('Client'))
                ->render(function(Clip $model){
                    return $model->client->name;
                }),

            Sight::make('manager', __('Manager'))
                ->render(function(Clip $model){
                    return $model->manager->name;
                }),

            Sight::make('file', __('File'))
                ->render(function(Clip $model){
                    return (new SightImage(src: $model->file->first()?->url()))->render();
                }),

            Sight::make('date_start', __('Start date')),

            Sight::make('date_end', __('End date')),

            Sight::make('archived', __('Archived'))
                ->render(function(Clip $model){
                    return $model->archived ? __('Yes') : __('No');
                }),

            Sight::make('created_at', __('Date of creation'))
                ->render(fn($model) => $model->created_at->toDateTimeString()),

            Sight::make('updated_at', __('Update date'))
                ->render(fn($model) => $model->updated_at->toDateTimeString()),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function onSave(ResourceRequest $request, Clip $clip){

        $clipRequest = ClipRequest::convertRequest($request);
        $validated = $clipRequest->validated();

        $clip->fill($clipRequest->all())->save();
        $clip->file()->sync($clipRequest->file);
    }
}
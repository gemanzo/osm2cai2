<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class DownloadGeojson extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Download GeoJSON';

    public $withoutConfirmation = true;

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $modelType = $models->first()->getMorphClass();

        //trim app\models
        $modelType = str_replace('App\Models\\', '', $modelType);

        //redirect to the download url api
        foreach ($models as $model) {
            return Action::redirect(url('/api/geojson/'.$modelType.'/'.$model->id));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}

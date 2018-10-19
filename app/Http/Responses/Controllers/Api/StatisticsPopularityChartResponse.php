<?php

namespace App\Http\Responses\Controllers\Api;

use Illuminate\Contracts\Support\Responsable;

class StatisticsPopularityChartResponse implements Responsable
{
    protected $chart_data = [];

    /**
     * @param array $chart_data
     */
    public function __construct(array $chart_data)
    {
        $this->chart_data = $chart_data;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return [
            'labels' => $this->chart_data['views']->pluck('month'),
            'options' => [],
            'datasets' => [
                [
                    'label' => trans('users.views2'),
                    'fill' => false,
                    'backgroundColor' => '#484074',
                    'borderColor' => '#484074',
                    'data' => $this->chart_data['views']->pluck('sum'),
                ],
                [
                    'label' => trans('users.likes'),
                    'fill' => false,
                    'backgroundColor' => '#cf4545',
                    'borderColor' => '#cf4545',
                    'data' => $this->chart_data['likes']->pluck('sum'),
                ],
                [
                    'label' => trans('messages.favorites'),
                    'fill' => false,
                    'backgroundColor' => '#d49d10',
                    'borderColor' => '#d49d10',
                    'data' => $this->chart_data['favs']->pluck('sum'),
                ],
            ],
        ];
    }
}

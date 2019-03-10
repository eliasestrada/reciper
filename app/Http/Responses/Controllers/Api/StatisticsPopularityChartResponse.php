<?php

namespace App\Http\Responses\Controllers\Api;

use Illuminate\Contracts\Support\Responsable;

class StatisticsPopularityChartResponse implements Responsable
{
    /**
     * @var array
     */
    private $chart_data = [];

    /**
     * @param array $chart_data
     * @return void
     */
    public function __construct(array $chart_data)
    {
        $this->chart_data = $chart_data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toResponse($request): array
    {
        return [
            'labels' => array_column($this->chart_data['views'], 'month'),
            'options' => [],
            'datasets' => [
                [
                    'label' => trans('users.views2'),
                    'fill' => false,
                    'backgroundColor' => '#484074',
                    'borderColor' => '#484074',
                    'data' => array_column($this->chart_data['views'], 'sum'),
                ],
                [
                    'label' => trans('users.likes'),
                    'fill' => false,
                    'backgroundColor' => '#cf4545',
                    'borderColor' => '#cf4545',
                    'data' => array_column($this->chart_data['likes'], 'sum'),
                ],
                [
                    'label' => trans('messages.favorites'),
                    'fill' => false,
                    'backgroundColor' => '#d49d10',
                    'borderColor' => '#d49d10',
                    'data' => array_column($this->chart_data['favs'], 'sum'),
                ],
            ],
        ];
    }
}

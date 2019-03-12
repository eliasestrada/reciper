<?php

namespace App\Http\Responses\Controllers\Api;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;

class StatisticsPopularityChartResponse implements Responsable
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $recipes;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @param \Illuminate\Support\Collection $chart_data
     * @param int|null $user_id
     * @return void
     */
    public function __construct(Collection $recipes, ?int $user_id = null)
    {
        $this->recipes = $recipes;
        $this->user_id = $user_id ?? user()->id;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toResponse($request): array
    {
        $ttl = config('cache.timing.user_statistics_data');
        $key = "user:{$this->user_id}:chart_data";

        // dump(Redis::ttl($key));

        return cache()->remember($key, $ttl, function () {
            return $this->reponseChartArray();
        });
    }

    /**
     * @return array
     */
    public function reponseChartArray(): array
    {
        $rules = $this->generateRulesArray();

        $chart_data = [
            'views' => $this->generateArrayWithChartData('views', $rules),
            'likes' => $this->generateArrayWithChartData('likes', $rules),
            'favs' => $this->generateArrayWithChartData('favs', $rules),
        ];

        return [
            'labels' => array_column($chart_data['views'], 'month'),
            'options' => [],
            'datasets' => [
                [
                    'label' => trans('users.views2'),
                    'fill' => false,
                    'backgroundColor' => '#484074',
                    'borderColor' => '#484074',
                    'data' => array_column($chart_data['views'], 'sum'),
                ],
                [
                    'label' => trans('users.likes'),
                    'fill' => false,
                    'backgroundColor' => '#cf4545',
                    'borderColor' => '#cf4545',
                    'data' => array_column($chart_data['likes'], 'sum'),
                ],
                [
                    'label' => trans('messages.favorites'),
                    'fill' => false,
                    'backgroundColor' => '#d49d10',
                    'borderColor' => '#d49d10',
                    'data' => array_column($chart_data['favs'], 'sum'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function generateRulesArray(): array
    {
        return array_map(function ($num) {
            return [
                'month' => now()->startOfMonth()->subMonths($num - 1)->month,
                'from' => now()->startOfMonth()->subMonths($num - 1)->toDateString(),
                'to' => now()->startOfMonth()->subMonths($num - 2)->toDateString(),
                'sum' => 0,
            ];
        }, [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]);
    }

    /**
     * @param string $column
     * @param array $rules
     * @return array
     */
    public function generateArrayWithChartData(string $column, array $rules): array
    {
        if (!in_array($column, ['likes', 'views', 'favs'])) {
            $msg = 'getDataFromUser 1 parameter can only have one of three values. Given value does not match any of them';
            throw new \Exception($msg);
        }

        // Takes rules array and fills out the 'sum' column with data from database
        foreach ($rules as $key => $rule) {
            $rules[$key]['sum'] += $this->recipes->map(function ($recipe) use ($rule, $column) {
                return $recipe[$column]
                    ->where('created_at', '>=', $rule['from'])
                    ->where('created_at', '<=', $rule['to'])
                    ->count();
            })->sum();
        }

        return $this->convertMonthNumberToName($rules);
    }

    /**
     * @param array $rules
     * @return array
     */
    public function convertMonthNumberToName(array $rules): array
    {
        return array_map(function ($rule) {
            $rule['month'] = trans("date.month_{$rule['month']}");
            return $rule;
        }, $rules);
    }
}

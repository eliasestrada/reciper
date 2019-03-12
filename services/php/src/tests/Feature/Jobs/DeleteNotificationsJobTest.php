<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\Jobs\DeleteNotificationsJob;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteNotificationsJobTest extends TestCase
{
    use DatabaseTransactions;

    private $controller;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new DeleteNotificationsJob;
    }

    /**
     * @test
     */
    public function deleteNotifications_method_deletes_all_checked_notifications(): void
    {
        $notification_id = $this->createNotificationReadAt(now()->subHour());
        $this->controller->deleteNotifications();
        $this->assertDatabaseMissing('notifications', ['id' => $notification_id]);
    }

    /**
     * @test
     */
    public function deleteNotifications_method_does_not_delete_not_checked_notifications(): void
    {
        $notification_id = $this->createNotificationReadAt();
        $this->controller->deleteNotifications();
        $this->assertDatabaseHas('notifications', ['id' => $notification_id]);
    }

    /**
     * Function helper
     *
     * @param \Illuminate\Support\Carbon|null $read_at
     * @return string
     */
    private function createNotificationReadAt(?Carbon $read_at = null): string
    {
        DatabaseNotification::create([
            'id' => $id = string_random(7),
            'type' => 'Some type',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => 1,
            'data' => 'Some text',
            'read_at' => $read_at,
        ]);
        return $id;
    }
}

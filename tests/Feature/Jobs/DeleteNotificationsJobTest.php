<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeleteNotificationsJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class DeleteNotificationsJobTest extends TestCase
{
    use DatabaseTransactions;

    private $controller;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new DeleteNotificationsJob;
    }

    /**
     * @author Cho
     * @test
     */
    public function deleteNotifications_method_deletes_all_checked_notifications(): void
    {
        $notification_id = $this->createNotificationReadAt(now()->subHour());
        $this->controller->deleteNotifications();
        $this->assertDatabaseMissing('notifications', ['id' => $notification_id]);
    }

    /**
     * @author Cho
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
     * @param string|null $read_at
     * @return string
     */
    private function createNotificationReadAt(?string $read_at = null): string
    {
        DatabaseNotification::create([
            'id' => $id = str_random(7),
            'type' => 'Some type',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => 1,
            'data' => 'Some text',
            'read_at' => $read_at,
        ]);
        return $id;
    }
}

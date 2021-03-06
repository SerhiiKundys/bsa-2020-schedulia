<?php

namespace App\Services\Zoom;

use App\Entity\Event;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Http;

final class ZoomService
{
    private const ZOOM_MEETING_API_ENDPOINT = 'https://api.zoom.us/v2/users/me/meetings';
    private const ZOOM_OAUTH_TOKEN_POST_REQUEST_URL = 'https://zoom.us/oauth/token';

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function meeting(Event $event): string
    {
        $user = $this->userRepository->getById($event->eventType->owner_id);

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $user->zoom_access_token,
        ])->post(self::ZOOM_MEETING_API_ENDPOINT, [
            "topic" => $event->eventType->name,
            "start_time" => $event->start_date,
            "timezone" => $event->timezone
        ]);

        $zoomResponseArr = json_decode($response->body(), true);

        return $zoomResponseArr['start_url'];
    }

    public function saveToken(string $code, int $userId): void
    {
        $token = $this->getZoomToken($code);

        $user = $this->userRepository->getById($userId);

        if ($user->zoom_access_token == null) {
            $user->zoom_access_token = $token['access_token'];
            $user->save();
        } else {
            $user->update(['zoom_access_token' => $token['access_token']]);
        }
    }

    public function getZoomToken(string $code): array
    {
        $responseToken = Http::withHeaders([
            "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
        ])->asForm()->post(self::ZOOM_OAUTH_TOKEN_POST_REQUEST_URL, [
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => env('ZOOM_REDIRECT_URI')
        ]);

        return json_decode($responseToken->body(), true);
    }
}

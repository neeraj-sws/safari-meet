<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationMessage;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

if (! function_exists('log_activity')) {
    /**
     * Create an activity log entry.
     *
     * @param string $action  // e.g. 'safari.delete'
     * @param array|null $payload // custom payload/metadata (associative)
     * @param \Illuminate\Http\Request|null $request // optional override request
     */
    function log_activity(string $action, array $payload = null, $request = null)
    {
        $request = $request ?? request();

        $whitelist = config('activity.whitelist_actions', []);
        if (!empty($whitelist) && !in_array($action, $whitelist)) {
            return null;
        }

        $storeParams = config('activity.store_parameters', true);
        $params = [];
        if ($storeParams) {
            if (config('activity.log_full_request', true)) {
                $params = $request->all();
            } else {
                $params = $payload['parameters'] ?? [];
            }
        }

        $actor = null;
        $actorType = null;
        $actorId = null;
        $identifier = null;
        $guardUsed = null;

        foreach (['web', 'user_api', 'admin'] as $guard) {
            if (auth($guard)->check()) {
                $actor = auth($guard)->user();
                $actorType = class_basename(get_class($actor));
                $actorId = $actor->getKey();
                $identifier = $actor->email ?? ($actor->name ?? $actor->getKey());
                $guardUsed = $guard;
                break;
            }
        }

        if (!$actor && auth()->check()) {
            $actor = auth()->user();
            $actorType = class_basename(get_class($actor));
            $actorId = $actor->getKey();
            $identifier = $actor->email ?? ($actor->name ?? $actor->getKey());
            $guardUsed = null;
        }

        if (!$actor) {
            $actorType = 'Guest';
            $actorId = null;
            $identifier = request()->cookie('anon_id') ?? session()->getId();
        }

        if ($payload && is_array($payload)) {
            $params = array_merge($params ?? [], $payload);
        }

        $parts = explode('.', $action);
        $category = $parts[0] ?? 'general';


        $actorType = $payload['actor_type'] ?? $actorType;
        $actorId = $payload['actor_id'] ?? $actorId;
        $identifier = $payload['actor_identifier'] ?? $identifier;
        $guardUsed = $payload['guard'] ?? $guardUsed;
        $category = $payload['category'] ?? $category;

        $messages = config('activity.messages', []);
        $message = $payload['message'] ?? ($messages[$action] ?? ucfirst(str_replace('.', ' ', $action)));


        return ActivityLog::create([
            'actor_type'      => $actorType,
            'actor_id'        => $actorId,
            'actor_identifier' => $identifier,
            'action'          => $action,
            'category'         => $category,
            'message'          => $message,
            'guard'           => $guardUsed ?? null,
            'method'          => $request->method() ?? null,
            'url'             => $request->fullUrl() ?? null,
            'parameters'      => $params ? json_decode(json_encode($params), true) : null,
            'ip_address'      => $request->ip() ?? null,
            'user_agent'      => substr($request->userAgent() ?? '', 0, 1000),
            'happened_at'     => now(),
        ]);
    }
}

if (!function_exists('createNotification')) {

    function createNotification(
        $type,
        int $receiverId,
        $receiver_type = null,
        ?int $senderId = null,
        $sender_type = null,
        array $data = [],
        ?string $category = 'activity',
        ?string $message = null
    ) {
        try {

            if (!$message) {
                $template = NotificationMessage::where('notification_message_id', $type)
                    ->where('is_active', true)
                    ->first();

                if (!$template) {
                    Log::warning("Notification Template Not Found: {$type}");
                    return false;
                }

                $message = $template->message;
                $heading = $template->heading;
            }
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $message = str_replace('{'.$key.'}', $value, $message);
                }
            }

            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $heading = str_replace('{'.$key.'}', $value, $heading);
                }
            }

           $data =  Notification::create([
                'receiver_id'    => $receiverId,
                'receiver_type'    => $receiver_type,
                'sender_id'  => $senderId,
                'sender_type'  => $sender_type,
                'type'       => $type,
                'heading'    => $heading,
                'message'    => $message,
                'data'       => !empty($data) ? json_encode($data) : null,
                'category'   => $category,
                'is_read'    => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Notification Create Error: ' . $e->getMessage());
            return false;
        }
    }
}

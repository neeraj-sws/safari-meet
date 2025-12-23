<?php

namespace App\Helpers;

use App\Models\Feature;
use App\Models\SeoPage;
use App\Models\NotificationTemplate;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class UserHelper
{
    public static function name($guard = 'admin')
    {
        return Auth::guard($guard)->check()
            ? Auth::guard($guard)->user()->name
            : 'Guest';
    }

    public static function photo($guard = 'admin')
    {
        $user = Auth::guard($guard)->user();

        if (!$user || !$user->profile_photo) {
            return asset('assets/images/avatars/avatar-2.png');
        }

        return asset($user->profile_photo);
    }
    public static function imageDimensionRule(string $expected = '4:3')
    {
        return function ($attribute, $value, $fail) use ($expected) {
            if (!$value || !$value->isValid()) {
                return;
            }

            [$width, $height] = getimagesize($value->getPathname());

            if (Str::contains($expected, ':')) {
                [$ew, $eh] = explode(':', $expected);
                $expectedRatio = round($ew / $eh, 2);
                $actualRatio   = round($width / $height, 2);

                if ($actualRatio !== $expectedRatio) {
                    $fail("Uploaded image size is {$width}x{$height}px — Expected aspect ratio is {$expected} (e.g. " . ($ew * 100) . "x" . ($eh * 100) . " px).");
                }
            } elseif (Str::contains($expected, 'x')) {
                [$ew, $eh] = explode('x', strtolower($expected));
                $ew = (int) $ew;
                $eh = (int) $eh;

                if ($width !== $ew || $height !== $eh) {
                    $fail("Uploaded image size is {$width}x{$height}px — Expected exact size is {$ew}x{$eh}px.");
                }
            } else {
                $fail("Invalid format passed for image dimension validation. Use '4:3' or '800x600'.");
            }
        };
    }

    public static function SeoDetails($slug, $id = null)
    {
        if ($slug == 'parkDetailsPage') {
            return $seocontant = $id;
        }
        if ($slug == 'speciesDetails') {
            return $seocontant = $id;
        }
        $seocontant = SeoPage::where('slug', $slug)->first();
        if (!empty($seocontant)) {
            return $seocontant;
        } else {
            return null;
        }
    }

    public static function inclusionList($ids)
    {
        $ids = json_decode($ids);
        if (!is_array($ids) || count($ids) <= 0) {
            return '401';
        }
        $featurs =   Feature::whereIn('features_id', $ids)->get();

        if (is_array($featurs) || count($featurs) > 0) {
            return $featurs;
        } else {
            return [];
        }
    }

    public static function UserIPDetails()
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);

        $platform = $agent->platform();
        $platformVersion = $agent->version($platform);

        return ([
            'browser'     => $browser . ' ' . $browserVersion,
            'os'          => $platform . ' ' . $platformVersion,
            'device'      => $agent->device(),
            'is_mobile'   => $agent->isMobile(),
            'is_desktop'  => $agent->isDesktop(),
            'ip_address'  => request()->ip(),
            'referer'     => request()->headers->get('referer'),
            'user_agent'  => request()->header('User-Agent'),
        ]);
    }

    public static function getUserColor($name)
    {
        $colors = ['#f44336', '#e91e63', '#9c27b0', '#3f51b5', '#2196f3', '#009688', '#4caf50', '#ff9800', '#795548'];

        if (empty($name) || !is_string($name)) {
            return $colors[0];
        }
        $index = ord(strtoupper($name[0])) % count($colors);
        return $colors[$index];
    }


    public static function parseTemplate(string $key, array $data): array
    {
        $template = NotificationTemplate::where('template_code', $key)->firstOrFail();

        $subject = $template->subject;
        $body = $template->body;

        foreach ($data as $key => $value) {
            $subject = str_replace('{{' . $key . '}}', $value, $subject);
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }

    public static function generateUsername($fullName)
    {
        $base = strtolower(Str::slug($fullName));
        do {
            $username = $base . rand(10, 9999);
        } while (User::where('username', $username)->exists());

        return $username;
    }

}

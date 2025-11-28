<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private const CACHE_KEY = 'app_settings';
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Get a setting value by key
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->getAllCached();
        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value
     */
    public function set(string $key, $value, string $type = 'text', string $group = 'general'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        $this->clearCache();
    }

    /**
     * Get all settings for a specific group
     */
    public function getGroup(string $group): array
    {
        $settings = $this->getAllCached();
        return array_filter($settings, function ($value, $key) use ($group, $settings) {
            $setting = Setting::where('key', $key)->first();
            return $setting && $setting->group === $group;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Get all settings cached
     */
    private function getAllCached(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Set multiple settings at once
     */
    public function setMultiple(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $existing = Setting::where('key', $key)->first();
            
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $existing->type ?? 'text',
                    'group' => $existing->group ?? 'general',
                ]
            );
        }

        $this->clearCache();
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Get all settings grouped by category
     */
    public function getAllGrouped(): array
    {
        $settings = Setting::all()->groupBy('group');
        
        return $settings->map(function ($groupSettings) {
            return $groupSettings->mapWithKeys(function ($setting) {
                return [$setting->key => [
                    'value' => $setting->value,
                    'type' => $setting->type,
                ]];
            });
        })->toArray();
    }

    /**
     * Delete a setting
     */
    public function delete(string $key): void
    {
        Setting::where('key', $key)->delete();
        $this->clearCache();
    }
}

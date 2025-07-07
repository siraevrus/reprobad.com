<?php

namespace App\Services;

use App\Models\Seo;

class SeoService
{
    public static function getSeoData($pageType, $pageId)
    {
        return Seo::where('page_type', $pageType)
                  ->where('page_id', $pageId)
                  ->first();
    }

    public static function getMetaTags($pageType, $pageId)
    {
        $seo = self::getSeoData($pageType, $pageId);
        
        if (!$seo) {
            return [
                'title' => null,
                'description' => null,
                'keywords' => null,
                'og_title' => null,
                'og_description' => null,
                'og_image' => null,
            ];
        }

        return [
            'title' => $seo->title,
            'description' => $seo->description,
            'keywords' => $seo->keywords,
            'og_title' => $seo->og_title,
            'og_description' => $seo->og_description,
            'og_image' => $seo->og_image,
        ];
    }
} 
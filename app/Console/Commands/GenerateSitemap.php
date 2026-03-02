<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Text;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml file with all site URLs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $baseUrl = config('app.url');
        $urls = [];

        // Главная страница
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];

        // Статические страницы
        $staticPages = [
            '/menu' => 'weekly',
            '/articles' => 'weekly',
            '/events' => 'weekly',
            '/products' => 'weekly',
            '/complex' => 'weekly',
            '/text' => 'monthly',
            '/usefully-tips' => 'weekly',
            '/faq' => 'monthly',
            '/company' => 'monthly',
            '/privacy' => 'yearly',
            '/about' => 'monthly',
            '/contacts' => 'monthly',
            '/map' => 'monthly',
        ];

        foreach ($staticPages as $path => $changefreq) {
            $urls[] = [
                'loc' => $baseUrl . $path,
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => $changefreq,
                'priority' => '0.8'
            ];
        }

        // Статьи
        $articles = Article::active()->get();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => $baseUrl . '/articles/' . $article->alias,
                'lastmod' => $article->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }

        // События
        $events = Event::active()->get();
        foreach ($events as $event) {
            $urls[] = [
                'loc' => $baseUrl . '/events/' . $event->alias,
                'lastmod' => $event->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }

        // Комплексы
        $complexes = Complex::active()->get();
        foreach ($complexes as $complex) {
            $urls[] = [
                'loc' => $baseUrl . '/complex/' . $complex->alias,
                'lastmod' => now()->format('Y-m-d'), // Complex не имеет timestamps
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }

        // Полезные советы
        $advises = Advise::active()->get();
        foreach ($advises as $advise) {
            $urls[] = [
                'loc' => $baseUrl . '/usefully-tips/' . $advise->alias,
                'lastmod' => $advise->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }

        // Меню
        $menus = Menu::active()->get();
        foreach ($menus as $menu) {
            if (!empty($menu->alias)) {
                $urls[] = [
                    'loc' => $baseUrl . '/menu/' . $menu->alias,
                    'lastmod' => isset($menu->updated_at) ? $menu->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => '0.6'
                ];
            }
        }

        // Тексты
        $texts = Text::active()->get();
        foreach ($texts as $text) {
            $urls[] = [
                'loc' => $baseUrl . '/text/' . $text->alias,
                'lastmod' => $text->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        // Генерация XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        // Сохранение файла
        $filePath = public_path('sitemap.xml');
        File::put($filePath, $xml);

        $this->info("Sitemap generated successfully! Total URLs: " . count($urls));
        $this->info("File saved to: {$filePath}");

        return 0;
    }
}


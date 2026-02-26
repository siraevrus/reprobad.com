<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{

    public array $rules = [
        'title' => 'required|string',
        'content' => 'required|string',
        'alias' => 'required|unique:articles,alias',
        'description' => 'string|nullable',
        'image' => 'string|nullable',
        'icon' => 'string|nullable',
        'category' => 'string|nullable',
        'time' => 'string|nullable',
        'active' => 'boolean|required',
        'seo_description' => 'string|nullable',
    ];

    public function index(Request $request): View|JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $query = Article::query();
        if ($search !== '') {
            $searchVariants = $this->buildSearchVariants($search);
            $query->where(function ($builder) use ($searchVariants) {
                foreach ($searchVariants as $variant) {
                    $builder->orWhere('title', 'like', '%' . $variant . '%')
                        ->orWhere('alias', 'like', '%' . $variant . '%');
                }
            });
        }

        $resources = $query
            ->orderByDesc('id')
            ->paginate(env('PAGINATION_LIMIT', 20))
            ->withQueryString();

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.articles.index', compact('resources', 'search'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Article::query()->findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request) : JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['content'] = $this->normalizeEmbeds($data['content'] ?? '');

        $resource = Article::query()->create($data);

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), array_merge($this->rules, [
            'alias' => 'required|unique:articles,alias,' . $id,
        ]));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['content'] = $this->normalizeEmbeds($data['content'] ?? '');

        $resource = Article::query()->findOrFail($id);
        $resource->fill($data);
        $resource->save();

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        $files = Storage::disk('public')->files('icons');
        $icons = array_map(fn($file) => Storage::disk('public')->url($file), $files);
        return view('admin.articles.create', compact('icons'));
    }

    public function edit(): View
    {
        $files = Storage::disk('public')->files('icons');
        $icons = array_map(fn($file) => Storage::disk('public')->url($file), $files);
        return view('admin.articles.create', compact('icons'));
    }

    public function switch($id): RedirectResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }

    public function home($id): RedirectResponse
    {
        $resource = Article::findOrFail($id);
        $resource->home = $resource->home == false;
        $resource->save();
        session()->flash('message', 'Элементы на главной странице обновлены');
        return back();
    }

    private function normalizeEmbeds(string $html): string
    {
        $result = preg_replace_callback(
            '/<iframe\b[^>]*src=["\']https?:\/\/(?:www\.)?rutube\.ru\/play\/embed\/[^"\']+["\'][^>]*>/i',
            function (array $matches): string {
                $tag = $matches[0];

                // Remove sandbox to allow Rutube player scripts to run.
                $tag = preg_replace('/\s+sandbox(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+))?/i', '', $tag) ?? $tag;

                if (!preg_match('/\sallow(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'))/i', $tag)) {
                    $tag = rtrim($tag, '>') . ' allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media">';
                }

                return $tag;
            },
            $html
        );

        return $result ?? $html;
    }

    private function buildSearchVariants(string $search): array
    {
        $search = trim($search);
        if ($search === '') {
            return [];
        }

        $variants = [$search];

        // Handle wrong keyboard layout (ru <-> en).
        $variants[] = strtr($search, $this->ruToEnLayoutMap());
        $variants[] = strtr($search, $this->enToRuLayoutMap());

        // Add simple typo-tolerant variants by removing one character.
        if (mb_strlen($search) >= 5) {
            $maxVariants = 6;
            for ($i = 0; $i < mb_strlen($search) && $maxVariants > 0; $i++) {
                $variants[] = mb_substr($search, 0, $i) . mb_substr($search, $i + 1);
                $maxVariants--;
            }
        }

        return array_values(array_unique(array_filter($variants)));
    }

    private function ruToEnLayoutMap(): array
    {
        return [
            'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p',
            'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k',
            'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm',
            'б' => ',', 'ю' => '.', 'ё' => '`',
            'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P',
            'Х' => '{', 'Ъ' => '}', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K',
            'Д' => 'L', 'Ж' => ':', 'Э' => '"', 'Я' => 'Z', 'Ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M',
            'Б' => '<', 'Ю' => '>', 'Ё' => '~',
        ];
    }

    private function enToRuLayoutMap(): array
    {
        return [
            'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з',
            '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л',
            'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь',
            ',' => 'б', '.' => 'ю', '`' => 'ё',
            'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З',
            '{' => 'Х', '}' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л',
            'L' => 'Д', ':' => 'Ж', '"' => 'Э', 'Z' => 'Я', 'X' => 'Ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь',
            '<' => 'Б', '>' => 'Ю', '~' => 'Ё',
        ];
    }
}

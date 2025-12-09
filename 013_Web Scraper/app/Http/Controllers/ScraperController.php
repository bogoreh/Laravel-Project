<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WebScraperService;
use App\Models\ScrapedData;
use Validator;

class ScraperController extends Controller
{
    protected $scraperService;

    public function __construct(WebScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function index()
    {
        $scrapedData = ScrapedData::orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('scraper.index', compact('scrapedData'));
    }

    public function create()
    {
        return view('scraper.create');
    }

    public function scrape(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'selectors' => 'nullable|array',
            'selectors.*' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Parse custom selectors if provided
        $selectors = [];
        if ($request->has('custom_selectors')) {
            $customSelectors = explode(',', $request->input('custom_selectors'));
            foreach ($customSelectors as $index => $selector) {
                $trimmed = trim($selector);
                if (!empty($trimmed)) {
                    $selectors["custom_{$index}"] = $trimmed;
                }
            }
        }

        // Scrape the website
        $result = $this->scraperService->scrapeWebsite(
            $request->input('url'),
            $selectors
        );

        // Save to database
        $scrapedData = $this->scraperService->saveScrapedData(
            $request->input('url'),
            $result,
            $request->input('title')
        );

        if ($result['success']) {
            return view('scraper.results', [
                'data' => $result['data'],
                'scrapedData' => $scrapedData,
                'success' => true
            ]);
        } else {
            return view('scraper.results', [
                'error' => $result['error'],
                'scrapedData' => $scrapedData,
                'success' => false
            ]);
        }
    }

    public function show($id)
    {
        $scrapedData = ScrapedData::findOrFail($id);
        
        return view('scraper.show', compact('scrapedData'));
    }

    public function destroy($id)
    {
        $scrapedData = ScrapedData::findOrFail($id);
        $scrapedData->delete();

        return redirect()->route('scraper.index')
            ->with('success', 'Scraped data deleted successfully.');
    }

    public function clearAll()
    {
        ScrapedData::truncate();

        return redirect()->route('scraper.index')
            ->with('success', 'All scraped data cleared successfully.');
    }
}
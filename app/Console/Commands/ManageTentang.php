<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tentang;

class ManageTentang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tentang:manage {action : list, edit, toggle} {--section=} {--title=} {--subtitle=} {--description=} {--content=} {--image=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage tentang content: list, edit sections, or toggle active status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list':
                $this->listSections();
                break;
            case 'edit':
                $this->editSection();
                break;
            case 'toggle':
                $this->toggleSection();
                break;
            default:
                $this->error('Invalid action. Use: list, edit, or toggle');
        }
    }

    private function listSections()
    {
        $sections = Tentang::orderBy('sort_order')->get();
        
        if ($sections->isEmpty()) {
            $this->info('No sections found.');
            return;
        }

        $this->table(
            ['ID', 'Section', 'Title', 'Active', 'Sort Order'],
            $sections->map(function ($section) {
                return [
                    $section->id,
                    $section->section,
                    substr($section->title ?? '', 0, 50) . (strlen($section->title ?? '') > 50 ? '...' : ''),
                    $section->is_active ? 'Yes' : 'No',
                    $section->sort_order
                ];
            })
        );
    }

    private function editSection()
    {
        $sectionName = $this->option('section') ?: $this->ask('Section name (hero, about, vision_mission, journey)');
        
        $section = Tentang::where('section', $sectionName)->first();
        
        if (!$section) {
            $this->error("Section '{$sectionName}' not found.");
            return;
        }

        $title = $this->option('title') ?: $this->ask('Title', $section->title);
        $subtitle = $this->option('subtitle') ?: $this->ask('Subtitle (optional)', $section->subtitle);
        $description = $this->option('description') ?: $this->ask('Description (optional)', $section->description);
        $content = $this->option('content') ?: $this->ask('Content (optional)', $section->content);
        $image = $this->option('image') ?: $this->ask('Image (optional)', $section->image);

        $section->update([
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'content' => $content,
            'image' => $image,
        ]);

        $this->info("Section '{$sectionName}' updated successfully.");
    }

    private function toggleSection()
    {
        $this->listSections();
        
        $sectionName = $this->ask('Enter section name to toggle active status');
        $section = Tentang::where('section', $sectionName)->first();

        if (!$section) {
            $this->error('Section not found.');
            return;
        }

        $section->update(['is_active' => !$section->is_active]);
        $status = $section->is_active ? 'activated' : 'deactivated';
        $this->info("Section '{$section->section}' has been {$status}.");
    }
}

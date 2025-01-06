<?php

namespace App\Filament\Resources\ChapterResource\Pages;

use App\Filament\Resources\ChapterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChapter extends EditRecord
{
    protected static string $resource = ChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $chapter = $this->getRecord();
        
        return [
            route('filament.admin.resources.series.index') => 'Series',
            route('filament.admin.resources.series.edit', ['record' => $chapter->serie]) => $chapter->serie->title,
            '#' => "Chapter {$chapter->order_number}",
        ];
    }
}

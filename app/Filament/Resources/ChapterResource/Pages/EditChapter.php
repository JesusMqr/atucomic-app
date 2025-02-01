<?php

namespace App\Filament\Resources\ChapterResource\Pages;

use App\Filament\Resources\ChapterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditChapter extends EditRecord
{
    protected static string $resource = ChapterResource::class;

    protected function beforeEdit(): void
    {
        $user = auth()->user();
        
        if (!$user->hasRole('super_admin') && $this->record->serie->owner_id !== $user->id) {
            $this->redirect('/admin');
        }
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $user = auth()->user();
        if (!$user->hasRole('super_admin') && $record->owner_id !== $user->id) {
            abort(403);
            
        }

        return parent::handleRecordUpdate($record, $data);
    }

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

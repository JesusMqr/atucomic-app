<?php

namespace App\Filament\Resources\SerieResource\Pages;

use App\Filament\Resources\SerieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
class EditSerie extends EditRecord
{
    protected static string $resource = SerieResource::class;

    protected function beforeEdit(): void
    {
        $user = auth()->user();
        
        if (!$user->hasRole('super_admin') && $this->record->owner_id !== $user->id) {
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
}

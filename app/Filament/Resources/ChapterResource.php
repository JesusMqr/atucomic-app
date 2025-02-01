<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChapterResource\Pages;
use App\Filament\Resources\ChapterResource\RelationManagers;
use App\Models\Chapter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChapterResource\RelationManagers\ImagesRelationManager;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;




class ChapterResource extends Resource
{
    protected static ?string $model = Chapter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->numeric()
                    ->label('Chapter Number'),
                Forms\Components\TextInput::make('image_url')
                    ->label('Cover Image URL'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChapters::route('/'),
            'create' => Pages\CreateChapter::route('/create'),
            'edit' => Pages\EditChapter::route('/{record}/edit'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasRole('super_admin') ||
        $record->serie->owner_id === auth()->user()->id;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole('super_admin') ||
        $record->serie->owner_id === auth()->user()->id;
    }

    public static function canShow(Model $record):bool
    {
        return auth()->user()->hasRole('super_admin') ||
        $record->serie->owner_id === auth()->user()->id;
    }
}

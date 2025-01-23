<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SerieResource\Pages;
use App\Filament\Resources\SerieResource\RelationManagers;
use App\Models\Serie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use App\Filament\Resources\SerieResource\RelationManagers\ChaptersRelationManager;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;


class SerieResource extends Resource
{
    protected static ?string $model = Serie::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view_serie');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->columnSpanFull()->label('Título')->required(),
                Forms\Components\Textarea::make('description')->columnSpanFull()->label('Descripción'),
                Forms\Components\TextInput::make('cover_image_url')->label('Imagen url portada')->required(),
                Forms\Components\TextInput::make('banner_image_url')->label('Imagen url banner'),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->required()
                    ->options([
                        'manga' => 'Manga',
                        'manhwa' => 'Manhwa', 
                        'comic' => 'Comic',
                        'other' => 'Otro'
                    ]),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options([
                        'ongoing' => 'En emisión',
                        'completed' => 'Completado',
                        'hiatus' => 'En pausa',
                        'cancelled' => 'Cancelado'
                    ]),
                Forms\Components\TextInput::make('author')->label('Autor'),
                Hidden::make('owner_id')->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('owner.name'),
                Tables\Columns\ImageColumn::make('cover_image_url'),
                Tables\Columns\TextColumn::make('chapters_count')->counts('chapters'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'ongoing' => 'En emisión',
                            'completed' => 'Completado',
                            'hiatus' => 'En pausa', 
                            'cancelled' => 'Cancelado',
                            default => $state
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ongoing' => 'success',
                        'completed' => 'info',
                        'hiatus' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'manga' => 'Manga',
                            'manhwa' => 'Manhwa',
                            'comic' => 'Comic',
                            'other' => 'Otro',
                            default => $state
                        };
                    }),
                
                Tables\Columns\TextColumn::make('author'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'manga' => 'Manga',
                        'manhwa' => 'Manhwa', 
                        'comic' => 'Comic',
                        'other' => 'Otro'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'ongoing' => 'En emisión',
                        'completed' => 'Completado', 
                        'hiatus' => 'En pausa',
                        'cancelled' => 'Cancelado'
                    ]),
                Tables\Filters\SelectFilter::make('updated_at')
                    ->options([
                        'desc' => 'Most Recent',
                        'asc' => 'Oldest',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, string $order): Builder => $query->orderBy('updated_at', $order)
                        );
                    })
                ,
                Tables\Filters\SelectFilter::make('chapters_count')
                    ->options([
                        'desc' => 'Most Chapters',
                        'asc' => 'Least Chapters'
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, string $order): Builder => $query->withCount('chapters')->orderBy('chapters_count', $order)
                        );
                    })
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
            ChaptersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSerie::route('/create'),
            'edit' => Pages\EditSerie::route('/{record}/edit'),
        ];
    }

    public static function getTableQuery(): Builder 
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getTableQuery();
        }
        
        return auth()->user()->series()->getQuery();
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }
        
        return auth()->user()->series()->getQuery();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasRole('super_admin') || 
        $record->owner_id === auth()->user()->id;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole('super_admin') || 
        $record->owner_id === auth()->user()->id;
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeestypeResource\Pages;
use App\Filament\Resources\FeestypeResource\RelationManagers;
use App\Models\Feestype;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeestypeResource extends Resource
{
    protected static ?string $model = Feestype::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-rupee';
    protected static ?string $navigationGroup = 'Fees Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name') 
                    ->required()
                    ->label('Fees Type') 
                    ->maxLength(255)
                    ->placeholder('e.g. Tuition Fees') 
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') 
                    ->sortable()
                    ->searchable()
                    ->label('Fees Type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeestypes::route('/'),
            //'create' => Pages\CreateFeestype::route('/create'),
            'edit' => Pages\EditFeestype::route('/{record}/edit'),
        ];
    }
}

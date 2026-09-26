<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\FeeStructureResource\Pages;
use App\Filament\Resources\FeeStructureResource\RelationManagers;
use App\Models\FeeStructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeeStructureResource extends Resource
{
    protected static ?string $model = FeeStructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Fees Management';
    protected static ?string $label = 'Fee Structure';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('stream_id') 
                    ->required()
                    ->relationship('stream', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpan(2)
                    ->label('Select Class:'),

                Forms\Components\Select::make('term')
                    ->required()
                    ->options([
                        'First Term' => 'First Term',
                        'Second Term' => 'Second Term',
                        'Third Term' => 'Third Term',
                    ])
                    ->columnSpan(2)
                    ->label('Select Term:'),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->columnSpan(2)
                    ->label('Amount:'),

                Forms\Components\Hidden::make('added_by')
                    ->default(Auth::user()->id)
                    ->required()
                    ->columnSpan(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('stream.name')
                    ->searchable()
                    ->label('Class')
                    ->sortable(),
                Tables\Columns\TextColumn::make('term')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Added By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Added At'),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeeStructures::route('/'),
            'create' => Pages\CreateFeeStructure::route('/create'),
           /* 'edit' => Pages\EditFeeStructure::route('/{record}/edit'),*/
        ];
    }
}

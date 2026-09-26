<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\SchoolExpenseResource\Pages;
use App\Filament\Resources\SchoolExpenseResource\RelationManagers;
use App\Models\SchoolExpense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolExpenseResource extends Resource
{
    protected static ?string $model = SchoolExpense::class;

    protected static ?string $navigationGroup = 'Administration';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                  Forms\Components\TextInput::make('description') 
                    ->required()
                    ->label('Description:') 
                    ->maxLength(255)
                    ->columnSpan(2)
                    ->placeholder('e.g. Bus Repairs'),

                 Forms\Components\TextInput::make('amount') 
                    ->required()
                    ->label('Amount:') 
                    ->maxLength(10)
                    ->numeric()
                    ->minValue(1)
                    ->columnSpan(2)
                    ->placeholder('e.g. 30000'),

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
                Tables\Columns\TextColumn::make('description') 
                    ->sortable()
                    ->searchable()
                    ->label('Description:'),

                Tables\Columns\TextColumn::make('amount') 
                    ->sortable()
                    ->label('Amount:'),

                Tables\Columns\TextColumn::make('user.name') 
                    ->sortable()
                    ->label('Added By'),
            ])
            ->filters([
                //
            ])
            ->actions([
                /*Tables\Actions\EditAction::make(), */
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   /* Tables\Actions\DeleteBulkAction::make(),*/
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
            'index' => Pages\ListSchoolExpenses::route('/'),
            'create' => Pages\CreateSchoolExpense::route('/create'),
            /*'edit' => Pages\EditSchoolExpense::route('/{record}/edit'),*/
        ];
    }
}

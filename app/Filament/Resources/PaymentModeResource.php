<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentModeResource\Pages;
use App\Filament\Resources\PaymentModeResource\RelationManagers;
use App\Models\PaymentMode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentModeResource extends Resource
{
    protected static ?string $model = PaymentMode::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Fees Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name') 
                    ->required()
                    ->label('Payment Name') 
                    ->maxLength(255)
                    ->placeholder('e.g. MPESA') 
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
                    ->label('Payment Mode Name'),
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
            'index' => Pages\ListPaymentModes::route('/'),
            //'create' => Pages\CreatePaymentMode::route('/create'),
            'edit' => Pages\EditPaymentMode::route('/{record}/edit'),
        ];
    }
}

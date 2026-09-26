<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $label = 'Users';
    protected static ?int $navigationSort = 3;

    protected function handleRecordCreation(array $data): User
    {
        $record =  static::getModel()::create($data);

        $creator= Auth::user()->name;

        //send an email
        $emailSubject= "Welcome on board ".extract_firstname($record->name).".";
        $emailMessage="Greetings ".extract_firstname($record->name).", you have been added as an administrator to our website with the following details:
            Username: ".$record->email."
            Password: ".$record->password."

            This action was done by: ".$creator.". Contact him through: ".Auth::user()->email."
        .";
        $receiver = $record->email;
        sendEmail($receiver,$emailMessage,$emailSubject);

        return $record;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->label('User Name')
                ->placeholder('e.g. John Kamau')
                ->columnSpan(2)
                ->maxLength(255),

                Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->label('Email Address')
                ->columnSpan(2)
                ->placeholder('e.g. example@website.com')
                ->maxLength(255),

                Forms\Components\Select::make('role_id')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->label('User Role')
                ->columnSpan(2)
                ->searchable(),

                Forms\Components\TextInput::make('password')
                ->required()
                ->password()
                ->revealable()
                ->hiddenOn('edit')
                ->label('Password')
                ->columnSpan(2)
                ->placeholder('*********')
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('User Name'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('User Email Address'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()
                    ->sortable()
                    ->label('Role'),
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
            'index' => Pages\ListUsers::route('/'),
           // 'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

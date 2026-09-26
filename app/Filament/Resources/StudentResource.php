<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use Filament\Tables\Actions\Action;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    //protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Students Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Details')
                ->description('Fill the new Student Details.')
                ->schema([
                     //Form for adding a student
                Forms\Components\TextInput::make('name') 
                    ->required()
                    ->label('Enter Name') 
                    ->maxLength(255)
                    ->placeholder('e.g. Obed Paul') 
                    ->columnSpan(2),

                Forms\Components\Select::make('gender')
                ->required()
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                ])
                ->label('Select Gender')
                ->columnSpan(2),

                Forms\Components\Select::make('stream_id') 
                    ->required()
                    ->relationship('stream', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                        ->label('Class Name')
                        ->placeholder('e.g. Pre Primary 1')
                        ->required()
                        ->maxLength(255),
                        ])
                    ->label('Select Class')
                    ->columnSpan('1/2'),

                Forms\Components\TextInput::make('admission_number') 
                    ->required()
                    ->maxLength(15)
                    ->placeholder('e.g. XY1234')
                    ->columnSpan('1/2'),

                Forms\Components\Hidden::make('added_by')
                    ->default(Auth::user()->id)
                    ->required()
                    ->columnSpan(2),

                ]),

               Forms\Components\Section::make('Guardian Details')
                ->description('Fill the new Student\'s Guardian Details.')
                ->schema([
                        Forms\Components\TextInput::make('guardian_name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Baba Obed') 
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('guardian_phone')
                            ->required()
                            ->tel()
                            ->maxLength(10)
                            ->placeholder('e.g. 0701234567')
                            ->columnSpan(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('admission_number')
                    ->searchable()
                    ->sortable()
                    ->label('Admission No.'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Student Name'),

                Tables\Columns\TextColumn::make('gender')
                    ->sortable()
                    ->label('Gender'),
                Tables\Columns\TextColumn::make('stream.name')
                    ->searchable()
                    ->sortable()
                    ->label('Class'),
                Tables\Columns\TextColumn::make('guardian_name')
                    ->label('Guardian Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_phone')
                    ->searchable()
                    ->label('Guardian Phone No.'),
                Tables\Columns\TextColumn::make('studentaccount.balance')
                    ->label('Fee Balance')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Admitted By')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Admitted on'),
            ])
            
            ->filters([

                Filter::make('With Fee Balance') 
                    ->query(fn (Builder $query): Builder => $query->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '<', 0))),

                Filter::make('Without Fee Balance') 
                    ->query(fn (Builder $query): Builder => $query->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '>', -1))),

                SelectFilter::make('stream')
                ->relationship('stream', 'name')
                ->preload()
                ->searchable()
                ->label('Class'),

                SelectFilter::make('added_by')
                ->relationship('user', 'name')
                ->preload()
                ->searchable()
                ->label('Admitted By'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                /*ImportAction::make('import')
                    ->importer(StudentImporter::class),*/
                    
                ExportAction::make('export')
                    ->exporter(StudentExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                
                ExportBulkAction::make('export')
                    ->exporter(StudentExporter::class),

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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}

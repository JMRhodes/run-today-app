<?php

namespace App\Filament\Resources;

use App\Enums\ActivityType;
use App\Filament\Resources\ActivityResource\Pages\ListActivities;
use App\Models\Activity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(auth()->user()->id),
                TextInput::make('distance')
                    ->placeholder('0.00')
                    ->numeric()
                    ->inputMode('decimal')
                    ->columns(1)
                    ->required(),
                TextInput::make('time')
                    ->mask('99:99')
                    ->placeholder('00:00')
                    ->columns(1)
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options(ActivityType::class)
                    ->selectablePlaceholder(false)
                    ->default(ActivityType::RUN->value)
                    ->required(),
                DateTimePicker::make('started_at')
                    ->default(now())
                    ->timezone('America/Chicago')
                    ->seconds(false)
                    ->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('user.avatar_url')
                        ->circular()
                        ->label('Name')
                        ->defaultImageUrl(
                            fn (
                                Model $record
                            ): string => "https://api.dicebear.com/9.x/initials/svg?seed={$record->user->name}"
                        )
                        ->grow(false)
                        ->visibleFrom('md'),
                    Stack::make([
                        TextColumn::make('user.name')
                            ->size('md')
                            ->label(''),
                        TextColumn::make('started_at')
                            ->label('Date')
                            ->size('xs')
                            ->color('gray')
                            ->since(),
                    ])
                        ->space(1)
                        ->visibleFrom('md'),
                    Stack::make([
                        TextColumn::make('user.name')
                            ->label(''),
                        TextColumn::make('started_at')
                            ->label('Date')
                            ->size('xs')
                            ->color('gray')
                            ->since(),
                    ])->hiddenFrom('md')
                        ->space(1),
                    TextColumn::make('type')
                        ->badge()
                        ->columnSpan(1)
                        ->visibleFrom('md'),
                    TextColumn::make('distance')
                        ->size('lg')
                        ->alignEnd()
                        ->description('miles', position: 'above')
                        ->weight('bold')
                        ->columnSpan(1),
                    TextColumn::make('time')
                        ->size('lg')
                        ->alignEnd()
                        ->description('time', position: 'above')
                        ->columnSpan(1),
                ]),
            ])
            ->defaultSort('started_at', 'desc')
            ->filters([
                //
            ])
            ->defaultPaginationPageOption(50)
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                        ->requiresConfirmation(),
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
            'index' => ListActivities::route('/'),
        ];
    }
}

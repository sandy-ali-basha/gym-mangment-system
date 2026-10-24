<?php

namespace App\Filament\Resources\GymClasses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GymClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('coach_id')
                    ->relationship('coach', 'full_name')
                    ->searchable()
                    ->preload(),
                TextInput::make('category'),
                Select::make('gender')->options(['female' => 'Women', 'male' => 'Men', 'mixed' => 'Mixed']),
                TextInput::make('duration_minutes')
                    ->required()
                    ->numeric(),
                TextInput::make('capacity')
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

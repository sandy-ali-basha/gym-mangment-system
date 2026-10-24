<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                DatePicker::make('registered_at')
                    ->required(),
                Select::make('gender')
                    ->options(['female' => 'Women', 'male' => 'Men'])
                    ->required(),
                FileUpload::make('profile_photo_path')
                    ->image()
                    ->directory('client-profiles'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->required()
                    ->default('active'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('emergency_contact_name'),
                TextInput::make('emergency_contact_phone')
                    ->tel(),
            ]);
    }
}

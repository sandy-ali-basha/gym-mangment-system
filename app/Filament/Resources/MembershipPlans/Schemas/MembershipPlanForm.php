<?php

namespace App\Filament\Resources\MembershipPlans\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MembershipPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('اسم الخطة')
                    ->required(),
                TextInput::make('duration_days')->label('المدة بالأيام')
                    ->required()
                    ->numeric(),
                TextInput::make('price')->label('السعر')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س'),
                Textarea::make('features')->label('المميزات')
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('الخطة نشطة')
                    ->required(),
            ]);
    }
}

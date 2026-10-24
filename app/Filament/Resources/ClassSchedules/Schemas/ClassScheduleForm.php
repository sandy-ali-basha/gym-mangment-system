<?php

namespace App\Filament\Resources\ClassSchedules\Schemas;

use App\Models\GymClass;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class ClassScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('gym_class_id')
                    ->relationship('gymClass', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (?int $state, Set $set, Get $get): void {
                        $class = GymClass::find($state);
                        if ($class === null) {
                            return;
                        }

                        $set('coach_id', $class->coach_id);
                        $start = $get('starts_at');
                        if ($start !== null) {
                            $set('ends_at', Carbon::createFromFormat('H:i', $start)->addMinutes($class->duration_minutes)->format('H:i'));
                        }
                    })
                    ->required(),
                Select::make('coach_id')
                    ->relationship('coach', 'full_name')
                    ->searchable()
                    ->preload(),
                Select::make('days_of_week')
                    ->label('Day of week')
                    ->multiple()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (?array $state, Set $set): mixed => $set('day_of_week', $state[0] ?? null))
                    ->options(['saturday' => 'Saturday', 'sunday' => 'Sunday', 'monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday'])
                    ->required(),
                Hidden::make('day_of_week'),
                TimePicker::make('starts_at')
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->live()
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        $class = GymClass::find($get('gym_class_id'));
                        if ($class !== null && $state !== null) {
                            $set('ends_at', Carbon::createFromFormat('H:i', $state)->addMinutes($class->duration_minutes)->format('H:i'));
                        }
                    })
                    ->required(),
                TimePicker::make('ends_at')
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->required(),
                TextInput::make('location'),
            ]);
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Site Settings';

    /**
     * @var array<string, string|null>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::values());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Section::make('Contact details')
                        ->description('Shown in the site footer and on the contact page.')
                        ->columns(2)
                        ->schema([
                            TextInput::make('church_name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('address')
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->tel()
                                ->maxLength(255),
                            TextInput::make('email')
                                ->email()
                                ->maxLength(255),
                            TextInput::make('whatsapp')
                                ->label('WhatsApp number')
                                ->tel()
                                ->helperText('Include the country code, e.g. +256 700 000000.')
                                ->maxLength(255),
                            TextInput::make('service_times')
                                ->label('Main service times')
                                ->placeholder('Sundays 9:00 AM & 11:00 AM')
                                ->maxLength(255),
                        ]),
                    Section::make('Social media')
                        ->columns(3)
                        ->schema([
                            TextInput::make('facebook_url')->label('Facebook link')->url()->maxLength(255),
                            TextInput::make('youtube_url')->label('YouTube link')->url()->maxLength(255),
                            TextInput::make('instagram_url')->label('Instagram link')->url()->maxLength(255),
                        ]),
                    Section::make('Giving')
                        ->schema([
                            Textarea::make('giving_instructions')
                                ->label('How to give')
                                ->helperText('e.g. Mobile money numbers and bank details. Leave empty to show "coming soon" on the Give page.')
                                ->rows(6),
                        ]),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::saveMany($this->form->getState());

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->send();
    }
}

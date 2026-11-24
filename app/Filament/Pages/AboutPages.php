<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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
 * Text for the fixed-design Vision Bearer and Church Profile pages.
 *
 * @property-read Schema $form
 */
class AboutPages extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.about-pages';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 11;

    protected static ?string $title = 'About Pages';

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
                    Section::make('Vision Bearer')
                        ->description('The founder / senior leader shown on About Us → Vision Bearer.')
                        ->columns(2)
                        ->schema([
                            TextInput::make('vision_bearer_name')
                                ->label('Name')
                                ->maxLength(255),
                            TextInput::make('vision_bearer_title')
                                ->label('Title')
                                ->placeholder('Founder & Senior Pastor')
                                ->maxLength(255),
                            FileUpload::make('vision_bearer_photo')
                                ->label('Photo')
                                ->disk('public')
                                ->image()
                                ->imageEditor()
                                ->automaticallyResizeImagesToWidth('1200')
                                ->directory('about')
                                ->maxSize(10240)
                                ->columnSpanFull(),
                            Textarea::make('vision_bearer_bio')
                                ->label('Biography')
                                ->helperText('Leave a blank line between paragraphs.')
                                ->rows(10)
                                ->columnSpanFull(),
                            Textarea::make('vision_bearer_quote')
                                ->label('Quote or scripture')
                                ->rows(2),
                            TextInput::make('vision_bearer_quote_reference')
                                ->label('Quote reference')
                                ->placeholder('Mark 16:15')
                                ->maxLength(255),
                        ]),
                    Section::make('Church Profile')
                        ->description('Our story, shown on About Us → Church Profile above the mission, vision and core values.')
                        ->columns(2)
                        ->schema([
                            TextInput::make('church_founded')
                                ->label('Year founded')
                                ->maxLength(255),
                            TextInput::make('church_founder')
                                ->label('Founded by')
                                ->maxLength(255),
                            Textarea::make('church_history')
                                ->label('Our story')
                                ->helperText('Leave a blank line between paragraphs.')
                                ->rows(12)
                                ->columnSpanFull(),
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
            ->title('About pages saved')
            ->send();
    }
}

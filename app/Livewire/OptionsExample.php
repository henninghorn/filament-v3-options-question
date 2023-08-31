<?php

namespace App\Livewire;

use Filament\Forms\Get;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Filament\Forms\Components\Radio;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;

class OptionsExample extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * This should simulate calling an external API
     *
     * @param string|null $date
     * @return array
     */
    public function generateOptionsFromApi(?string $date): array
    {
        // Call some external API

        // Add artifical loading time
        sleep(1);

        // Return API data based on $date
        // Str::random() is used to display
        // the data changes on form updates
        return [
            'option_a' => sprintf('A | %s | 👉 %s %s', $date, Str::random(), '👈 this will change on form update..'),
            'option_b' => sprintf('B | %s | 👉 %s %s', $date, Str::random(), '👈 this will change on form update..'),
            'option_c' => sprintf('C | %s | 👉 %s %s', $date, Str::random(), '👈 this will change on form update..'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make("First step")
                    ->schema([
                        DatePicker::make('some_date')
                            ->label('Some date')
                            ->helperText('This should trigger an update on options below..')
                            ->default(now())
                            ->minDate(now()->startOfDay())
                            ->native(false)
                            ->closeOnDateSelection()
                            ->live(),
                        Radio::make('some_options')
                            ->label("👆 These options are based on date above")
                            ->options(function (Get $get) {
                                return $this->generateOptionsFromApi($get('some_date'));
                            })
                            ->hidden(fn (Get $get): bool => !$get('some_date')),
                        TextInput::make('some_text')
                            ->label("👇 Changing this live() field will trigger the options' callback")
                            ->live(),
                        TextInput::make('some_other_text')
                            ->label("This non-live() field will not do anything"),
                    ]),
                Wizard\Step::make('Final step')
                    ->schema([
                        Placeholder::make('Remember the option labels?')
                            ->content("Go back and check them, they have been changed!")
                    ]),
            ])->nextAction(fn (\Filament\Forms\Components\Actions\Action $action) => $action->label('This will update the options'))
        ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.options-example');
    }
}

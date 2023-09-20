<?php

namespace App\Livewire\Settings;

use App\Settings\GeneralSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CompanyDetails extends Component
{

    /**
     * The component's state.
     */
    public array $state = [];


    /**
     * Prepare the component.
     */
    public function mount(GeneralSetting $setting): void
    {
        $this->state = [
            'site_name'=> $setting->site_name,
            'company_name' => $setting->company_name,
            'website' => $setting->company_website,
            'email' => $setting->company_primary_contact_email,
            'employee_count' => $setting->company_employee_count,
            'city' => $setting->company_city,
            'state' => $setting->company_state,
            'country' => $setting->company_country
        ];
    }


    public function saveSettings(GeneralSetting $setting): void
    {
        $this->resetErrorBag();
        Validator::make($this->state, [
            'site_name'=> ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'employee_count' => ['required', 'int', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255']
        ])->validateWithBag('saveSettings');

        $setting->site_name = $this->state['site_name'];
        $setting->company_name = $this->state['company_name'];
        $setting->company_website = $this->state['website'];
        $setting->company_primary_contact_email = $this->state['email'];
        $setting->company_employee_count = $this->state['employee_count'];
        $setting->company_city = $this->state['city'];
        $setting->company_state = $this->state['state'];
        $setting->company_country = $this->state['country'];
        $setting->save();

        Notification::make()
            ->title('Company information updated')
            ->success()
            ->body('Your Company information has been updated successfully.')
            ->send();
    }


    public function render()
    {
        return view('livewire.settings.company-details');
    }
}

<?php

namespace App\Livewire\Admin\Species\Details\PhysicalAppereance;

use App\Models\SpeciesPhysicalAppereancesModel;
use Livewire\Component;

class Appearance extends Component
{
    public $species, $characterDetails, $pageTitle = 'Appearance';
    public $appearance_short_discription, $traits = [], $physicalAppereanceData;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        // $this->dispatch('initializeCKEditor');
        $this->physicalAppereanceData = SpeciesPhysicalAppereancesModel::where('species_id', $this->species->id)->where('species_details_characterstics_id', $this->characterDetails['species_details_characterstic_id'])->first();
        if (!empty($this->physicalAppereanceData)) {
            $this->appearance_short_discription = $this->physicalAppereanceData->appearance_description;
            $traitsData  = json_decode($this->physicalAppereanceData->trait, true);
            $defaultTraits = [
                'Length' => ['Male' => '', 'Female' => ''],
                'Weight' => ['Male' => '', 'Female' => ''],
                'Height' => ['Male' => '', 'Female' => ''],
            ];
            $this->traits = array_replace_recursive($defaultTraits, $traitsData ?? []);
        } else {
            $this->traits = [
                'Length' => ['Male' => '', 'Female' => ''],
                'Weight' => ['Male' => '', 'Female' => ''],
                'Height' => ['Male' => '', 'Female' => ''],
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.species.details.physical-appereance.appearance');
    }

    public function store()
    {
        $rules = [
            'appearance_short_discription' => 'required|string',

            'traits.Length.Male' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[A-Za-z0-9().,\-–_|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Male length cannot have leading or trailing spaces.');
                    }
                },
            ],
            'traits.Length.Female' => [
                'required',
                'string',
                'min:3',
                'max:30',
                 'regex:/^[A-Za-z0-9().,\-–_|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Female length cannot have leading or trailing spaces.');
                    }
                },
            ],
            'traits.Weight.Male' => [
                'required',
                'string',
                'min:3',
                'max:30',
                 'regex:/^[A-Za-z0-9().,\-–_|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Male weight cannot have leading or trailing spaces.');
                    }
                },
            ],
            'traits.Weight.Female' => [
                'required',
                'string',
                'min:3',
                'max:30',
                 'regex:/^[A-Za-z0-9().,\-–_|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Female weight cannot have leading or trailing spaces.');
                    }
                },
            ],
            'traits.Height.Male' => [
                'required',
                'string',
                'min:3',
                'max:30',
                 'regex:/^[A-Za-z0-9().,\-_–|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Male height cannot have leading or trailing spaces.');
                    }
                },
            ],
            'traits.Height.Female' => [
                'required',
                'string',
                'min:3',
                'max:30',
                 'regex:/^[A-Za-z0-9().,\-–_|\/ ]+$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Female height cannot have leading or trailing spaces.');
                    }
                },
            ],
        ];

        $messages = [
            'appearance_short_discription.required' => 'The appearance is required.',
            'appearance_short_discription.string'   => 'The appearance must be a string.',

            'traits.Length.Male.required' => 'The male length is required.',
            'traits.Length.Male.string'   => 'The male length must be a string.',
            'traits.Length.Male.min'      => 'The male length must be at least 3 characters.',
            'traits.Length.Male.max'      => 'The male length may not be greater than 10 characters.',
            'traits.Length.Male.regex'    => 'The male length may only contain letters, numbers, spaces, and these special characters: (),|/-_',

            'traits.Length.Female.required' => 'The female length is required.',
            'traits.Length.Female.string'   => 'The female length must be a string.',
            'traits.Length.Female.min'      => 'The female length must be at least 3 characters.',
            'traits.Length.Female.max'      => 'The female length may not be greater than 10 characters.',
            'traits.Length.Female.regex'    => 'The female length may only contain letters, numbers, spaces, and these special characters: (),|/-_',

            'traits.Weight.Male.required' => 'The male weight is required.',
            'traits.Weight.Male.string'   => 'The male weight must be a string.',
            'traits.Weight.Male.min'      => 'The male weight must be at least 3 characters.',
            'traits.Weight.Male.max'      => 'The male weight may not be greater than 10 characters.',
            'traits.Weight.Male.regex'    => 'The male weight may only contain letters, numbers, spaces, and these special characters: (),|/-_',

            'traits.Weight.Female.required' => 'The female weight is required.',
            'traits.Weight.Female.string'   => 'The female weight must be a string.',
            'traits.Weight.Female.min'      => 'The female weight must be at least 3 characters.',
            'traits.Weight.Female.max'      => 'The female weight may not be greater than 10 characters.',
            'traits.Weight.Female.regex'    => 'The female weight may only contain letters, numbers, spaces, and these special characters: (),|/-_',

            'traits.Height.Male.required' => 'The male height is required.',
            'traits.Height.Male.string'   => 'The male height must be a string.',
            'traits.Height.Male.min'      => 'The male height must be at least 3 characters.',
            'traits.Height.Male.max'      => 'The male height may not be greater than 10 characters.',
            'traits.Height.Male.regex'    => 'The male height may only contain letters, numbers, spaces, and these special characters: (),|/-_',

            'traits.Height.Female.required' => 'The female height is required.',
            'traits.Height.Female.string'   => 'The female height must be a string.',
            'traits.Height.Female.min'      => 'The female height must be at least 3 characters.',
            'traits.Height.Female.max'      => 'The female height may not be greater than 10 characters.',
            'traits.Height.Female.regex'    => 'The female height may only contain letters, numbers, spaces, and these special characters: (),|/-_',
        ];

        $this->validate($rules, $messages);

        if (!empty($this->physicalAppereanceData)) {
            $this->physicalAppereanceData->appearance_description = $this->appearance_short_discription;
            $this->physicalAppereanceData->trait = json_encode($this->traits);
            $this->physicalAppereanceData->save();
        } else {
            $this->physicalAppereanceData =  SpeciesPhysicalAppereancesModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'appearance_description' => $this->appearance_short_discription,
                'trait' => json_encode($this->traits),
            ]);
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}

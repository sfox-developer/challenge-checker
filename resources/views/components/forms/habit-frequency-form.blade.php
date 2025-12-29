@props([
    'frequencyType' => 'daily',
    'frequencyCount' => 1,
])

<x-forms.frequency-selector 
    :frequency-type="$frequencyType"
    :frequency-count="$frequencyCount"
/>

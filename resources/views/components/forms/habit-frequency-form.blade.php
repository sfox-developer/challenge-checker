@props([
    'frequencyType' => 'daily',
    'frequencyCount' => 1,
    'selectedDays' => []
])

<x-forms.frequency-selector 
    :frequency-type="$frequencyType"
    :frequency-count="$frequencyCount"
    :selected-days="$selectedDays"
/>

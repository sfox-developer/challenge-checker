@props([
    'frequencyType' => 'daily',
    'frequencyCount' => 1,
    'selectedDays' => []
])

<x-frequency-selector 
    :frequency-type="$frequencyType"
    :frequency-count="$frequencyCount"
    :selected-days="$selectedDays"
/>

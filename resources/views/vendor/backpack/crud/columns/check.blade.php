{{-- checkbox with loose false/null/0 checking --}}
@php
$checkValue = data_get($entry, $column['name']);

$checkedIcon = data_get($column, 'icons.checked', 'fa-check-square-o');
$uncheckedIcon = data_get($column, 'icons.unchecked', 'fa-square-o');

$exportCheckedText = data_get($column, 'labels.checked', '是');
$exportUncheckedText = data_get($column, 'labels.unchecked', '否');

$icon = $checkValue == false ? $uncheckedIcon : $checkedIcon;
$text = $checkValue == false ? $exportUncheckedText : $exportCheckedText;
@endphp

<span>{{ $text }}</span>

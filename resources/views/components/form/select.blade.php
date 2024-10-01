@props([
    'disabled' => false,
    'withicon' => false,
    'options' => [], // Tambahkan opsi untuk select
])

<select style="width:100%" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'px-4 py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-sky-300 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1',
]) !!}>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>

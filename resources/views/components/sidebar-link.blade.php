{{-- Blade component for sidebar links --}}
{{-- resources/views/components/sidebar-link.blade.php --}}
@props(['href','icon','active'=>false])
<a href="{{ $href }}"
   class="w-12 h-12 flex items-center justify-center rounded-lg transition-colors
          {{ $active ? 'bg-white bg-opacity-30 text-indigo-700' : 'text-gray-500 hover:bg-white/20 hover:text-gray-800' }}">
  <i class="{{ $icon }} text-xl"></i>
</a>

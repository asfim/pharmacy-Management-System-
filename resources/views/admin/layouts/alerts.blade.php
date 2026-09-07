@if(session('success'))
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-xl mb-5 text-sm font-medium" x-data x-init="setTimeout(() => $el.remove(), 4000)">
    <i class="fas fa-check-circle text-green-600"></i>
    {{ session('success') }}
    <button onclick="this.closest('div').remove()" class="ml-auto text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl mb-5 text-sm font-medium" x-data x-init="setTimeout(() => $el.remove(), 4000)">
    <i class="fas fa-exclamation-circle text-red-600"></i>
    {{ session('error') }}
    <button onclick="this.closest('div').remove()" class="ml-auto text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
</div>
@endif
@if(isset($errors) && $errors->any())
<div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl mb-5 text-sm">
    <p class="font-semibold mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following errors:</p>
    <ul class="list-disc pl-5 space-y-0.5">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

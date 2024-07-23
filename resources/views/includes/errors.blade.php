<div>
    @if(session()->has('error'))
        <div class="p-3 bg-danger text-white info-error">
            <p>ERROR: {{ session()->get('error') }}</p>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="p-3 bg-success text-white info-success">
            <p>{{ session()->get('success') }}</p>
        </div>
    @endif
</div>

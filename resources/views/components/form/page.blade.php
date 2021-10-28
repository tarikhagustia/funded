<div class="container-fluid">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <form action="{{ $action }}" method="{{ $method }}" autocomplete="on" {{ $attributes }}>
                            @csrf
                            {{ $slot }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
